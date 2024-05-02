<!-- SEO Meta Content -->
@push('meta')
    <meta name="description" content="@lang('shop::app.customers.login-form.page-title')"/>

    <meta name="keywords" content="@lang('shop::app.customers.login-form.page-title')"/>
@endPush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.login-form.page-title')
    </x-slot>

    <div class="min-h-screen flex">
            <div
                class="flex-1 flex flex-col justify-center py-2 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24"
            >
                <div class="mx-auto w-full max-w-sm lg:w-96">
                    <div>
                        {!! view_render_event('bagisto.shop.customers.login.logo.before') !!}
                        <a href="{{ route('shop.home.index') }}"  class="m-[0_auto_20px_auto]"  aria-label="@lang('shop::app.customers.login-form.bagisto')">
                            <img
                                class="h-12 w-auto"
                                src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                                alt="{{ config('app.name') }}"
                            />
                        </a>
                        {!! view_render_event('bagisto.shop.customers.login.logo.after') !!}
                        <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                            @lang('shop::app.customers.login-form.page-title')
                        </h2>
                        <p class="mt-2 text-sm text-gray-600">
                            @lang('shop::app.customers.login-form.form-login-text')
                        </p>
                    </div>

                    <div class="mt-8">
                        <div>
                            <div>
                                <div class="flex justify-center">
                                    {!! view_render_event('bagisto.shop.customers.login_form_controls.after') !!}
                                </div>
                            </div>

                            <div class="mt-6 relative">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
              <span class="px-2 bg-white text-gray-500">
                Or continue with
              </span>
                                </div>
                            </div>
                        </div>
                        {!! view_render_event('bagisto.shop.customers.login.before') !!}
                        <x-shop::form :action="route('shop.customer.session.create')">

                            {!! view_render_event('bagisto.shop.customers.login_form_controls.before') !!}

                            <!-- Email -->
                            <x-shop::form.control-group>
                                <x-shop::form.control-group.label class="required">
                                    @lang('shop::app.customers.login-form.email')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="email"
                                    name="email"
                                    rules="required|email"
                                    value=""
                                    :label="trans('shop::app.customers.login-form.email')"
                                    placeholder="email@example.com"
                                    aria-label="@lang('shop::app.customers.login-form.email')"
                                    aria-required="true"
                                />

                                <x-shop::form.control-group.error control-name="email" />
                            </x-shop::form.control-group>

                            <!-- Password -->
                            <x-shop::form.control-group>
                                <x-shop::form.control-group.label class="required">
                                    @lang('shop::app.customers.login-form.password')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="password"
                                    id="password"
                                    name="password"
                                    rules="required|min:6"
                                    value=""
                                    :label="trans('shop::app.customers.login-form.password')"
                                    :placeholder="trans('shop::app.customers.login-form.password')"
                                    aria-label="@lang('shop::app.customers.login-form.password')"
                                    aria-required="true"
                                />

                                <x-shop::form.control-group.error control-name="password" />
                            </x-shop::form.control-group>

                            <div class="flex justify-between">
                                <div class="select-none items-center flex gap-1.5">
                                    <input
                                        type="checkbox"
                                        id="show-password"
                                        class="hidden peer"
                                        onchange="switchVisibility()"
                                    />

                                    <label
                                        class="icon-uncheck text-2xl text-navyBlue peer-checked:icon-check-box peer-checked:text-navyBlue cursor-pointer"
                                        for="show-password"
                                    ></label>

                                    <label
                                        class="text-base text-[#6E6E6E] max-sm:text-xs ltr:pl-0 rtl:pr-0 select-none cursor-pointer"
                                        for="show-password"
                                    >
                                        @lang('shop::app.customers.login-form.show-password')
                                    </label>
                                </div>

                                <div class="block">
                                    <a
                                        href="{{ route('shop.customers.forgot_password.create') }}"
                                        class="text-base cursor-pointer text-black max-sm:text-xs"
                                    >
                                <span>
                                    @lang('shop::app.customers.login-form.forgot-pass')
                                </span>
                                    </a>
                                </div>
                            </div>

                            <!-- Captcha -->
                            @if (core()->getConfigData('customer.captcha.credentials.status'))
                                <div class="flex mt-5">
                                    {!! Captcha::render() !!}
                                </div>
                            @endif

                            <!-- Submit Button -->
                            <div class="flex gap-9 flex-wrap mt-4 items-center">
                                <button
                                    class="primary-button block w-full max-w-[374px] py-4 px-11 m-0 ltr:ml-0 rtl:mr-0 mx-auto rounded-2xl text-base text-center"
                                    type="submit"
                                >
                                    @lang('shop::app.customers.login-form.button-title')
                                </button>
                            </div>
                        </x-shop::form>
                        {!! view_render_event('bagisto.shop.customers.login.after') !!}
                    </div>
                    <p class="mt-5 text-[#6E6E6E] font-medium">
                        @lang('shop::app.customers.login-form.new-customer')

                        <a
                            class="text-navyBlue"
                            href="{{ route('shop.customers.register.index') }}"
                        >
                            @lang('shop::app.customers.login-form.create-your-account')
                        </a>
                    </p>
                    <p class="mt-8 mb-4 text-center text-[#6E6E6E] text-xs">
                        @lang('shop::app.customers.login-form.footer', ['current_year'=> date('Y') ])
                    </p>
                </div>
            </div>
            <div class="hidden lg:block relative w-0 flex-1">
                <img
                    class="absolute inset-0 h-full w-full object-cover"
                    src="https://images.unsplash.com/photo-1588861472194-6883d8b5e552?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt=""
                />
            </div>
        </div>

    @push('scripts')
        {!! Captcha::renderJS() !!}

        <script>
            function switchVisibility() {
                let passwordField = document.getElementById("password");

                passwordField.type = passwordField.type === "password"
                    ? "text"
                    : "password";
            }
        </script>
    @endpush
</x-shop::layouts>
