<p> new blacde ppp ppp @{{selectedPaymentMethod?.method}}</p>
@pushOnce('scripts')
    <script type="module">
        app.component('v-marcx-payment', {
            template: '#v-marcx-payment-template',

            mounted() {
                this.register();
            },

            methods: {
                register() {
                  console.log('marcx registered')
                },

                getOptions() {
                    let options = {
                        style: {
                            layout:  'vertical',
                            shape:   'rect',
                        },

                        authorizationFailed: false,

                        enableStandardCardFields: false,

                        alertBox: (message) => {
                            this.$emitter.emit('add-flash', { type: 'error', message: message });
                        },

                        createOrder: (data, actions) => {
                            return this.$axios.get("{{ route('paypal.smart-button.create-order') }}")
                                .then(response => response.data.result)
                                .then(order => order.id)
                                .catch(error => {
                                    if (error.response.data.error === 'invalid_client') {
                                        options.authorizationFailed = true;

                                        options.alertBox('@lang('Something went wrong.')');
                                    }

                                    return error;
                                });
                        },

                        onApprove: (data, actions) => {
                            this.$axios.post("{{ route('paypal.smart-button.capture-order') }}", {
                                _token: "{{ csrf_token() }}",
                                orderData: data
                            })
                                .then(response => {
                                    if (response.data.success) {
                                        if (response.data.redirect_url) {
                                            window.location.href = response.data.redirect_url;
                                        } else {
                                            window.location.href = "{{ route('shop.checkout.onepage.success') }}";
                                        }
                                    }
                                })
                                .catch(error => window.location.href = "{{ route('shop.checkout.cart.index') }}");
                        },

                        onError: (error) => {
                            if (! options.authorizationFailed) {
                                options.alertBox('@lang('Something went wrong.')');
                            }
                        },
                    };

                    return options;
                },
            },
        });
    </script>
@endPushOnce
