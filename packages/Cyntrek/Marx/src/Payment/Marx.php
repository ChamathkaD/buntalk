<?php

namespace Cyntrek\Marx\Payment;

use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use Webkul\Payment\Payment\Payment;

class Marx extends Payment
{
    /**
     * Client ID.
     *
     * @var string
     */
    protected $clientId;

    /**
     * Client secret.
     *
     * @var string
     */
    protected $clientSecret;

    /**
     * Payment method code
     *
     * @var string
     */
    protected $code = 'marx';

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Create order for approval of client.
     *
     * @param  array  $body
     * @return HttpResponse
     */
    public function createOrder($body)
    {
        $request = new OrdersCreateRequest;
        $request->headers['key'] = $this->clientSecret;
        $request->headers['value'] = '$2a$10$x1CAe9YuEz9G1X1ZQrTrLOJXFu2PSvrwLuBcWpgT2ecRAx5sxfOhW';
        $request->body = $body;

        return $request;
    }

    public function getRedirectUrl()
    {

    }

    /**
     * Initialize properties.
     *
     * @return void
     */
    protected function initialize()
    {
        $this->clientId = $this->getConfigData('client_id') ?: '';

        $this->clientSecret = $this->getConfigData('client_secret') ?: '';
    }

    /**
     * Format a currency value
     *
     * @param $number
     * @return float
     */
    public function formatCurrencyValue($number): float
    {
        return round((float) $number, 2);
    }
}
