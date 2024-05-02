{!! view_render_event('bagisto.shop.checkout.cart.summary.before') !!}

<v-cart-summary
    :cart="cart"
    :is-cart-loading="isCartLoading"
>
</v-cart-summary>

{!! view_render_event('bagisto.shop.checkout.cart.summary.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-cart-summary-template"
    >
        <template v-if="isCartLoading">
            <!-- onepage Summary Shimmer Effect -->
            <x-shop::shimmer.checkout.onepage.cart-summary/>
        </template>

        <template v-else>
            <div
                class="sticky top-8 h-max w-[442px] max-w-full ltr:pl-8 rtl:pr-8 max-lg:w-auto max-lg:max-w-[442px] max-lg:ltr:pl-0 max-lg:rtl:pr-0">
                <h1 class="text-2xl font-medium max-sm:text-xl">
                    @lang('shop::app.checkout.onepage.summary.cart-summary')
                </h1>

                <div class="grid mt-10 border-b border-[#E9E9E9] max-sm:mt-5">
                    <div
                        class="flex gap-x-4 pb-5"
                        v-for="item in cart.items"
                    >

                        {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_image.before') !!}

                        <img
                            class="max-w-[90px] max-h-[90px] w-[90px] h-[90px] rounded-md"
                            :src="item.base_image.small_image_url"
                            :alt="item.name"
                            width="110"
                            height="110"
                        />

                        {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_image.after') !!}

                        <div>
                            {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_name.before') !!}

                            <p
                                class="text-base text-navyBlue max-sm:text-sm max-sm:font-medium"
                                v-text="item.name"
                            >
                            </p>

                            {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_name.after') !!}

                            <p class="mt-2.5 text-lg font-medium max-sm:text-sm max-sm:font-normal">
                                @lang('shop::app.checkout.onepage.summary.price_&_qty', ['price' => '@{{ item.formatted_price }}', 'qty' => '@{{ item.quantity }}'])
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-4 mt-6 mb-8">

                    {!! view_render_event('bagisto.shop.checkout.onepage.summary.sub_total.before') !!}

                    <div class="flex text-right justify-between">
                        <p class="text-base max-sm:text-sm max-sm:font-normal">
                            @lang('shop::app.checkout.onepage.summary.sub-total')
                        </p>

                        <p
                            class="text-base font-medium max-sm:text-sm"
                            v-text="cart.base_sub_total"
                        >
                        </p>
                    </div>

                    {!! view_render_event('bagisto.shop.checkout.onepage.summary.sub_total.after') !!}


                    {!! view_render_event('bagisto.shop.checkout.onepage.summary.tax.before') !!}

                    <div
                        class="flex text-right justify-between"
                        v-for="(amount, index) in cart.base_tax_amounts"
                        v-if="parseFloat(cart.base_tax_total)"
                    >
                        <p class="text-base max-sm:text-sm max-sm:font-normal">
                            @lang('shop::app.checkout.onepage.summary.tax') (@{{ index }})%
                        </p>

                        <p
                            class="text-base font-medium max-sm:text-sm"
                            v-text="amount"
                        >
                        </p>
                    </div>

                    {!! view_render_event('bagisto.shop.checkout.onepage.summary.tax.after') !!}

                    {!! view_render_event('bagisto.shop.checkout.onepage.summary.delivery_charges.before') !!}

                    <div
                        class="flex text-right justify-between"
                        v-if="cart.selected_shipping_rate"
                    >
                        <p class="text-base">
                            @lang('shop::app.checkout.onepage.summary.delivery-charges')
                        </p>

                        <p
                            class="text-base font-medium"
                            v-text="cart.selected_shipping_rate"
                        >
                        </p>
                    </div>

                    {!! view_render_event('bagisto.shop.checkout.onepage.summary.delivery_charges.after') !!}

                    {!! view_render_event('bagisto.shop.checkout.onepage.summary.discount_amount.before') !!}

                    <div
                        class="flex text-right justify-between"
                        v-if="cart.base_discount_amount && parseFloat(cart.base_discount_amount) > 0"
                    >
                        <p class="text-base">
                            @lang('shop::app.checkout.onepage.summary.discount-amount')
                        </p>

                        <p
                            class="text-base font-medium"
                            v-text="cart.formatted_base_discount_amount"
                        >
                        </p>
                    </div>

                    {!! view_render_event('bagisto.shop.checkout.onepage.summary.discount_amount.after') !!}

                    {!! view_render_event('bagisto.shop.checkout.onepage.summary.coupon.before') !!}

                    @include('shop::checkout.cart.coupon')

                    {!! view_render_event('bagisto.shop.checkout.onepage.summary.coupon.after') !!}

                    {!! view_render_event('bagisto.shop.checkout.onepage.summary.grand_total.before') !!}

                    <div class="flex text-right justify-between">
                        <p class="text-lg font-semibold">
                            @lang('shop::app.checkout.onepage.summary.grand-total')
                        </p>

                        <p
                            class="text-lg font-semibold"
                            v-text="cart.base_grand_total"
                        >
                        </p>
                    </div>

                    {!! view_render_event('bagisto.shop.checkout.onepage.summary.grand_total.after') !!}
                </div>

                <div v-if="canPlaceOrder">
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label>
                            Select Delivery Timeslot
                        </x-shop::form.control-group.label>

                        <input
                            type="date"
                            name="delivery_date"
                            id="delivery_date"
                            v-model="delivery_date"
                            label="Set Delivery Date & Time"
                            placeholder="Set Delivery Date & Time"
                            class="max-w-md w-full"
                            @change="checkDateValidity"
                        />

                        <div class="text-xs text-red-500 mt-1" v-if="errors && errors.delivery_date">
                            <span>@{{ errors.delivery_date[0] }}</span>
                        </div>

                    </x-shop::form.control-group>

                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            Select Timeslot
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="select"
                            class="mb-3"
                            name="timeslot"
                            id="timeslot"
                            rules="required"
                            v-model="timeslot"
                            :label="trans('shop::app.customers.account.profile.gender')"
                        >
                            <option selected disabled>
                                Select Pickup timeslot
                            </option>

                            <option value="Morning 8.00AM - 4.00PM">
                                Morning 8.00AM - 4.00PM
                            </option>

                            <option value="Evening 4.00PM - 7.00PM">
                                Evening 4.00PM - 7.00PM
                            </option>
                        </x-shop::form.control-group.control>

                        <div class="text-xs text-red-500" v-if="errors && errors.timeslot">
                            <span>@{{ errors.timeslot[0] }}</span>
                        </div>
                    </x-shop::form.control-group>

                    <x-shop::form.control-group>
                        <x-shop::form.control-group.control
                            type="textarea"
                            class="mb-3"
                            name="additional_notes"
                            id="additional_notes"
                            v-model="additional_notes"
                            placeholder="Additional Notes (Optional)"
                        />
                    </x-shop::form.control-group>

                    <div class="flex justify-end mb-4">
                        <x-shop::button
                            type="button"
                            class="secondary-button max-w-full w-max py-3 px-11 rounded-2xl max-sm:text-sm max-sm:px-6 max-sm:mb-10"
                            button-type="secondary-button"
                            title="Confirm Delivery Date & Time"
                            @click="storeDeliveryDateTime"
                        />
                    </div>
                </div>

                <template v-if="canPlaceOrder">
                    <div v-if="selectedPaymentMethod?.method == 'paypal_smart_button'">
                        {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.before') !!}

                        <v-paypal-smart-button></v-paypal-smart-button>

                        {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.after') !!}
                    </div>

                    <div
                        class="flex justify-end"
                        v-else
                    >
                        <div v-if="storeDeliveryDateTimeTriggered">
                            {!! view_render_event('bagisto.shop.checkout.onepage.summary.place_order_button.before') !!}

                            <div v-if="selectedPaymentMethod?.method === 'marx'">
                                <button type="button" style="margin-bottom: 20px" @click="payWithMarx" class="primary-button w-max py-3 px-11 bg-navyBlue rounded-2xl max-sm:text-sm max-sm:px-6 max-sm:mb-10">Pay by Visa/Master card</button>
                            </div>

                            <div v-else>
                                <x-shop::button
                                    v-if="!isLoading"
                                    type="button"
                                    class="primary-button w-max py-3 px-11 bg-navyBlue rounded-2xl max-sm:text-sm max-sm:px-6 max-sm:mb-10"
                                    :title="trans('shop::app.checkout.onepage.summary.place-order')"
                                    :loading="false"
                                    @click="placeOrder"
                                />

                                <x-shop::button
                                    type="button"
                                    class="primary-button w-max py-3 px-11 bg-navyBlue rounded-2xl max-sm:text-sm max-sm:px-6 max-sm:mb-10"
                                    v-else
                                    :title="trans('shop::app.checkout.onepage.summary.place-order')"
                                    :loading="true"
                                    :disabled="true"
                                />
                            </div>

                            {!! view_render_event('bagisto.shop.checkout.onepage.summary.place_order_button.after') !!}
                        </div>
                    </div>
                </template>
            </div>
        </template>
    </script>

    <script type="module">
        app.component('v-cart-summary', {
            template: '#v-cart-summary-template',

            props: ['cart', 'isCartLoading'],

            data() {
                return {
                    canPlaceOrder: false,

                    selectedPaymentMethod: null,

                    isLoading: false,

                    errors: [],

                    delivery_date: null,

                    timeslot: null,

                    storeDeliveryDateTimeTriggered: false,

                    additional_notes: null,
                }
            },

            mounted() {
                console.log(this.selectedPaymentMethod)
                this.$emitter.on('can-place-order', (value) => this.canPlaceOrder = true);

                this.$emitter.on('after-payment-method-selected', (value) => this.selectedPaymentMethod = value);
            },

            methods: {
                storeDeliveryDateTime() {
                    // console.log(this.selectedPaymentMethod)
                    this.$axios.post("{{ route('shop.checkout.onepage.delivery_date.store') }}", {
                        delivery_date: this.delivery_date,
                        timeslot: this.timeslot,
                        additional_notes: this.additional_notes,
                    })
                        .then(res => {
                            if (res.data.success === true) {
                                this.canPlaceOrder = true;
                                this.errors = [];
                                this.storeDeliveryDateTimeTriggered = true;
                            }
                        })
                        .catch(error => {
                            if ([400, 422].includes(error.response.request.status)) {
                                this.errors = error.response.data.errors;
                                // this.canPlaceOrder = false;
                                this.storeDeliveryDateTimeTriggered = false;
                            }
                        });
                },
                placeOrder() {
                    // console.log(this.selectedPaymentMethod)
                    this.isLoading = true;

                    this.$axios.post('{{ route('shop.checkout.onepage.orders.store') }}')
                        .then(response => {
                            if (response.data.data.redirect) {
                                window.location.href = response.data.data.redirect_url;
                            } else {
                                window.location.href = '{{ route('shop.checkout.onepage.success') }}';
                            }

                            if (localStorage.getItem('customerAddresses')) {
                                localStorage.removeItem('customerAddresses');
                            }

                            this.isLoading = false;
                            this.storeDeliveryDateTimeTriggered = false;
                        })
                        .catch(error => {
                            // console.log(error)
                            this.isProcessing = false
                        });
                },
                payWithMarx() {
                    this.isLoading = true;

                    this.$axios.post('{{ route('marcx.pay.now') }}')
                        .then(response => {
                            if (response.data.data.redirect) {
                                window.location.href = response.data.data.redirect_url;
                            } else {
                                window.location.href = '{{ route('shop.checkout.onepage.success') }}';
                            }

                            if (localStorage.getItem('customerAddresses')) {
                                localStorage.removeItem('customerAddresses');
                            }

                            this.isLoading = false;
                            this.storeDeliveryDateTimeTriggered = false;
                        })
                        .catch(error => {
                            // console.log(error)
                            this.isProcessing = false
                        });
                },
                checkDateValidity() {
                    console.log(this.selectedPaymentMethod)
                    let selectedDate = new Date(document.getElementById('delivery_date').value);
                    let disabledDates = ['2024-04-13', '2024-04-14', '2024-04-15', '2024-04-16', '2024-04-17', '2024-04-18', '2024-04-19', '2024-04-23']; // Add dates to disable here in the format 'YYYY-MM-DD'

                    let dateString = selectedDate.toISOString().slice(0, 10);

                    if (disabledDates.includes(dateString)) {
                        document.getElementById('delivery_date').value = ''; // Clear the input field
                        this.delivery_date = null;
                        alert("This date is disabled. Please choose another date.");
                    }
                }
            },
        });
    </script>
@endPushOnce
