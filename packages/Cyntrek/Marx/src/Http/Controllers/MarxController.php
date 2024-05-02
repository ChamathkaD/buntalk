<?php

namespace Cyntrek\Marx\Http\Controllers;

use Carbon\Carbon;
use Cyntrek\Marx\Payment\Marx;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Webkul\Checkout\Facades\Cart;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Payment\Facades\Payment;
use Webkul\Sales\Models\Order;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\OrderRepository;

class MarxController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected Marx $marx,
        protected OrderRepository $orderRepository,
        protected InvoiceRepository $invoiceRepository,
        protected CustomerRepository $customerRepository
    ) {
    }

    /**
     * Marx order creation for approval of client.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrder()
    {
        try {
            return response()->json($this->marx->createOrder($this->buildRequestBody()));
        } catch (\Exception $e) {
            return response()->json(json_decode($e->getMessage()), 400);
        }
    }

    /**
     * Build request body.
     *
     * @return array
     */
    protected function buildRequestBody()
    {
        $cart = Cart::getCart();

        $data = [
            'merchantRID'       => 'CT2020/09/09/MR0001',
            'amount'            => $this->marx->formatCurrencyValue((float) $cart->sub_total + $cart->tax_total + ($cart->selected_shipping_rate ? $cart->selected_shipping_rate->price : 0) - $cart->discount_amount),
            'validTimeLimit'    => 5,
            'returnUrl'         => '',
            'customerMail'      => $cart->billing_address->email,
            'customerMobile'    => $cart->billing_address->phone,
            'mode'              => 'WEB',
            'orderSummary'      => 'Order Description',
            'customerReference' => 'CT2020/09/09/CUST0001',
        ];

        return $data;
    }

    public function payNow()
    {

        if (Cart::hasError()) {
            return new JsonResource([
                'redirect'     => true,
                'redirect_url' => route('shop.checkout.cart.index'),
            ]);
        }

        Cart::collectTotals();

        $this->validateOrder();

        $cart = Cart::getCart();

        if ($redirectUrl = Payment::getRedirectUrl($cart)) {
            return new JsonResource([
                'redirect'     => true,
                'redirect_url' => $redirectUrl,
            ]);
        }

        $order = $this->orderRepository->create(Cart::prepareDataForOrder());

        return $this->payMarkx($order);

        Cart::deActivateCart();
        Cart::activateCartIfSessionHasDeactivatedCartId();
        session()->flash('order', $order);

        return $this->payMarkx($order);
    }

    private function payMarkx($order)
    {
        $email = $order->customer_email;
        $contact = '+94711225489';
        $studentId = $order->id;
        $pay = $order->grand_total;
        $currency = 'LKR';
        $time = Carbon::now()->timestamp;
        $reference = "$studentId|$time";

        $_SESSION['currency'] = $currency;

        //        $user_secret = "\$2a\$10\$0.ogcTfS46TZIlKdyUeKHu0Hr2cDGcbNiufzIybnDtYpULkd4V3Li";
        $user_secret = '$2a$10$w7Scumi8.hJSXnPY69IE8O2ftFl3whDOyevy66I0l3ZKY64L4Y1pu';
        $url = 'https://app.marx.lk/api/v2/ipg/orders';

        $marx_args = [
            'merchantRID'       => $reference, // unique reference id for the process of order
            'amount'            => floatval($pay),
            'returnUrl'         => 'https://buntalk.lk/payment-confirm',
            'validTimeLimit'    => 30,
            'customerMail'      => $email,
            'customerMobile'    => $contact,
            'mode'              => 'WEB',
            'orderSummary'      => $studentId.' '.$pay,
            'customerReference' => $studentId.' '.$email,
            'paymentMethod'     => 'VISA_MASTERCARD',
        ];

        $response = Http::withHeaders([
            'user_secret'  => $user_secret,
            'Content-Type' => 'application/json',
        ])->post($url, $marx_args);

        if ($response->successful()) {
            $data = json_decode($response, true);
            Log::info($data);
            if ($data !== null) {
                $payUrl = $data['data']['payUrl'];
                Log::info($payUrl);

                return response()->json(['data' => ['redirect' => true, 'redirect_url' => $payUrl]]);
            } else {
                Log::error('Payment Error');

                return response()->json(['error' => 'Payment Error'], 500);
            }
        } else {
            Log::error('Payment Error 2');

            return response()->json(['error' => 'Payment Error'], 500);
        }
    }

    public function validateOrder()
    {
        $cart = Cart::getCart();

        $minimumOrderAmount = core()->getConfigData('sales.order_settings.minimum_order.minimum_order_amount') ?: 0;

        if (
            auth()->guard('customer')->check()
            && auth()->guard('customer')->user()->is_suspended
        ) {
            throw new \Exception(trans('shop::app.checkout.cart.suspended-account-message'));
        }

        if (
            auth()->guard('customer')->user()
            && ! auth()->guard('customer')->user()->status
        ) {
            throw new \Exception(trans('shop::app.checkout.cart.inactive-account-message'));
        }

        if (! $cart->checkMinimumOrder()) {
            throw new \Exception(trans('shop::app.checkout.cart.minimum-order-message', ['amount' => core()->currency($minimumOrderAmount)]));
        }

        if ($cart->haveStockableItems() && ! $cart->shipping_address) {
            throw new \Exception(trans('shop::app.checkout.cart.check-shipping-address'));
        }

        if (! $cart->billing_address) {
            throw new \Exception(trans('shop::app.checkout.cart.check-billing-address'));
        }

        if (
            $cart->haveStockableItems()
            && ! $cart->selected_shipping_rate
        ) {
            throw new \Exception(trans('shop::app.checkout.cart.specify-shipping-method'));
        }

        if (! $cart->payment) {
            throw new \Exception(trans('shop::app.checkout.cart.specify-payment-method'));
        }
    }

    /**
     * @throws \Exception
     */
    public function payConfirm(Request $request)
    {
        $mur = $request->mur;
        $tr = $request->tr;

        $mur_parts = explode('|', $mur);

        $user_secret = '$2a$10$w7Scumi8.hJSXnPY69IE8O2ftFl3whDOyevy66I0l3ZKY64L4Y1pu';
        $url = 'https://app.marx.lk/api/v2/ipg/orders/'.$tr;

        $marx_args = [
            'merchantRID' => $mur,
        ];

        $response = Http::withHeaders([
            'user_secret'  => $user_secret,
            'Content-Type' => 'application/json',
        ])->put($url, $marx_args);

        if ($response->successful()) {
            $data = json_decode($response, true);
            if ($data !== null) {
                $summaryResult = $data['data']['summaryResult'];
                if ($summaryResult == 'SUCCESS') {
                    //                    $this->updatePaymentsTable($data);

                    $success = $this->saveOrder($mur_parts[0]);

                    if ($success) {
                        return redirect()->route('shop.checkout.onepage.success');
                    }
                } else {
                    session()->flash('error', 'Payment not successfully!');

                    return redirect()->route('shop.checkout.cart.index');
                }
            } else {
                Log::error('Payment Validation Error');

                return response()->json(['error' => 'Payment Validation Error'], 500);
            }
        } else {
            Log::error('Payment Validation Error 2');

            return response()->json(['error' => 'Payment Error'], 500);
        }
    }

    /**
     * Saving order once captured and all formalities done.
     *
     * @return \Illuminate\Http\Response
     */
    protected function saveOrder($order_id = null)
    {
        if (Cart::hasError()) {
            return response()->json(['redirect_url' => route('shop.checkout.cart.index')], 403);
        }

        try {
            Cart::collectTotals();

            $this->validateOrder();

            $order = Order::find($order_id);

            //            $order = $this->orderRepository->create(Cart::prepareDataForOrder());

            $this->orderRepository->update(['status' => 'processing'], $order->id);

            if ($order->canInvoice()) {
                $this->invoiceRepository->create($this->prepareInvoiceData($order));
            }

            Cart::deActivateCart();

            session()->flash('order', $order);

            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            session()->flash('error', trans('shop::app.common.error'));

            throw $e;
        }
    }

    /**
     * Prepares order's invoice data for creation.
     *
     * @param  \Webkul\Sales\Models\Order  $order
     * @return array
     */
    protected function prepareInvoiceData($order)
    {
        $invoiceData = ['order_id' => $order->id];

        foreach ($order->items as $item) {
            $invoiceData['invoice']['items'][$item->id] = $item->qty_to_invoice;
        }

        return $invoiceData;
    }

    protected function updatePaymentsTable($data)
    {
        DB::table('payments')->insert([
            'transactionId'        => $data['data']['gatewayResponse']['transaction']['id'],
            'result'               => $data['data']['gatewayResponse']['result'],
            'amount'               => $data['data']['gatewayResponse']['transaction']['amount'],
            'currency'             => $data['data']['gatewayResponse']['transaction']['currency'],
            'authenticationStatus' => $data['data']['gatewayResponse']['transaction']['authenticationStatus'],
            'response'             => json_encode($data),
            'created_at'           => Carbon::now(),
            'updated_at'           => Carbon::now(),
        ]);
    }
}

/* sample response
{
  "status": 0,
  "message": "SUCCESS",
  "data": {
    "summaryResult": "SUCCESS",
    "gatewayResponse": {
      "authorizationResponse": {
        "commercialCard": null,
        "commercialCardIndicator": "1",
        "date": "0526",
        "posData": "1025100006600",
        "posEntryMode": "812",
        "processingCode": "000000",
        "responseCode": "00",
        "returnAci": null,
        "stan": "43908",
        "time": "083648",
        "cardSecurityCodeError": "P",
        "financialNetworkCode": "MCC",
        "transactionIdentifier": "6P1851"
      },
      "device": {
        "browser": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36",
        "ipAddress": "112.134.143.255"
      },
      "gatewayEntryPoint": "WEB_SERVICES_API",
      "merchant": "0020070",
      "order": {
        "amount": 213,
        "chargeback": {
          "amount": 0,
          "currency": "LKR"
        },
        "creationTime": "2023-05-26T08:26:29.547Z",
        "currency": "LKR",
        "id": "aa0675b6-f59c-44fe-bb8c-500a5e2bfdfe",
        "merchantCategoryCode": "4814",
        "status": "CAPTURED",
        "totalAuthorizedAmount": 213,
        "totalCapturedAmount": 213,
        "totalRefundedAmount": 0
      },
      "response": {
        "acquirerCode": "00",
        "acquirerMessage": "Approved",
        "cardSecurityCode": {
          "acquirerCode": "P",
          "gatewayCode": "NOT_PROCESSED"
        },
        "gatewayCode": "APPROVED"
      },
      "result": "SUCCESS",
      "sourceOfFunds": {
        "provided": {
          "card": {
            "brand": "MASTERCARD",
            "expiry": {
              "month": "12",
              "year": "24"
            },
            "fundingMethod": "DEBIT",
            "nameOnCard": null,
            "number": "555555xxxxxx8194",
            "scheme": "MASTERCARD",
            "storedOnFile": "NOT_STORED"
          }
        },
        "type": "CARD"
      },
      "timeOfRecord": "2023-05-26T08:36:48.218Z",
      "transaction": {
        "id": "576ba0d6-d25f-4378-bff1-8c6edf38c3a0",
        "amount": 213,
        "authenticationStatus": "AUTHENTICATION_SUCCESSFUL",
        "authorizationCode": "819300",
        "currency": "LKR",
        "receipt": "314608043908",
        "source": "INTERNET",
        "terminal": "0001",
        "type": "PAYMENT",
        "acquirer": {
          "batch": 20230526,
          "date": "0526",
          "id": "CARGILLSBANK_S2I",
          "merchantId": "0020070",
          "settlementDate": "2023-05-26",
          "timeZone": "+0530",
          "transactionId": "6P1851"
        },
        "stan": "43908"
      },
      "version": "62",
      "3DSecure": null,
      "3DSecureId": null
    }
  }
}
*/
