<!-- SEO Meta Content -->
@push('meta')
    <meta name="description" content="@lang('shop::app.customers.signup-form.page-title')"/>

    <meta name="keywords" content="@lang('shop::app.customers.signup-form.page-title')"/>
@endPush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.signup-form.page-title')
    </x-slot>

    <div class="min-h-screen flex">
            <div
                class="flex-1 flex flex-col justify-center py-2 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24"
            >
                <div class="mx-auto w-full max-w-sm lg:w-96">
                    <div>
                        {!! view_render_event('bagisto.shop.customers.sign-up.logo.before') !!}

                        <a href="{{ route('shop.home.index') }}"  class="m-[0_auto_20px_auto]"  aria-label="@lang('shop::app.customers.login-form.bagisto')">
                            <img
                                class="h-12 w-auto"
                                src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                                alt="{{ config('app.name') }}"
                            />
                        </a>

                        {!! view_render_event('bagisto.shop.customers.sign-up.logo.before') !!}
                        <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                            @lang('shop::app.customers.signup-form.page-title')
                        </h2>
                        <p class="mt-2 text-sm text-gray-600">
                            @lang('shop::app.customers.signup-form.form-signup-text')
                        </p>
                    </div>

                    <div class="mt-2">
                        <div class="flex justify-center">
                            {!! view_render_event('bagisto.shop.customers.login_form_controls.after') !!}
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

                    <div class="mt-4">

                        <x-shop::form :action="route('shop.customers.register.store')">
                            {!! view_render_event('bagisto.shop.customers.signup_form_controls.before') !!}

                            <x-shop::form.control-group>
                                <x-shop::form.control-group.label class="required">
                                    @lang('shop::app.customers.signup-form.first-name')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="text"
                                    name="first_name"
                                    rules="required"
                                    :value="old('first_name')"
                                    :label="trans('shop::app.customers.signup-form.first-name')"
                                    :placeholder="trans('shop::app.customers.signup-form.first-name')"
                                    aria-label="@lang('shop::app.customers.signup-form.first-name')"
                                    aria-required="true"
                                />

                                <x-shop::form.control-group.error control-name="first_name" />
                            </x-shop::form.control-group>

                            {!! view_render_event('bagisto.shop.customers.signup_form.first_name.after') !!}

                            <x-shop::form.control-group>
                                <x-shop::form.control-group.label class="required">
                                    @lang('shop::app.customers.signup-form.last-name')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="text"
                                    name="last_name"
                                    rules="required"
                                    :value="old('last_name')"
                                    :label="trans('shop::app.customers.signup-form.last-name')"
                                    :placeholder="trans('shop::app.customers.signup-form.last-name')"
                                    :aria-label="trans('shop::app.customers.signup-form.last-name')"
                                    aria-required="true"
                                />

                                <x-shop::form.control-group.error control-name="last_name" />
                            </x-shop::form.control-group>

                            {!! view_render_event('bagisto.shop.customers.signup_form.last_name.after') !!}

                            <x-shop::form.control-group>
                                <x-shop::form.control-group.label class="required">
                                    @lang('shop::app.customers.signup-form.email')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="email"
                                    name="email"
                                    rules="required|email"
                                    :value="old('email')"
                                    :label="trans('shop::app.customers.signup-form.email')"
                                    placeholder="email@example.com"
                                    aria-label="@lang('shop::app.customers.signup-form.email')"
                                    aria-required="true"
                                />

                                <x-shop::form.control-group.error control-name="email" />
                            </x-shop::form.control-group>

                            {!! view_render_event('bagisto.shop.customers.signup_form.email.after') !!}

                            <x-shop::form.control-group class="mb-6">
                                <x-shop::form.control-group.label class="required">
                                    @lang('shop::app.customers.signup-form.password')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="password"
                                    name="password"
                                    rules="required|min:6"
                                    :value="old('password')"
                                    :label="trans('shop::app.customers.signup-form.password')"
                                    :placeholder="trans('shop::app.customers.signup-form.password')"
                                    ref="password"
                                    aria-label="@lang('shop::app.customers.signup-form.password')"
                                    aria-required="true"
                                />

                                <x-shop::form.control-group.error control-name="password" />
                            </x-shop::form.control-group>

                            {!! view_render_event('bagisto.shop.customers.signup_form.password.after') !!}

                            <x-shop::form.control-group>
                                <x-shop::form.control-group.label>
                                    @lang('shop::app.customers.signup-form.confirm-pass')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="password"
                                    name="password_confirmation"
                                    rules="confirmed:@password"
                                    value=""
                                    :label="trans('shop::app.customers.signup-form.password')"
                                    :placeholder="trans('shop::app.customers.signup-form.confirm-pass')"
                                    aria-label="@lang('shop::app.customers.signup-form.confirm-pass')"
                                    aria-required="true"
                                />

                                <x-shop::form.control-group.error control-name="password_confirmation" />
                            </x-shop::form.control-group>

                            {!! view_render_event('bagisto.shop.customers.signup_form.password_confirmation.after') !!}


                            @if (core()->getConfigData('customer.captcha.credentials.status'))
                                <div class="flex mb-5">
                                    {!! Captcha::render() !!}
                                </div>
                            @endif

                            @if (core()->getConfigData('customer.settings.newsletter.subscription'))
                                <div class="flex gap-1.5 items-center select-none">
                                    <input
                                        type="checkbox"
                                        name="is_subscribed"
                                        id="is-subscribed"
                                        class="hidden peer"
                                        onchange="switchVisibility()"
                                    />

                                    <label
                                        class="icon-uncheck text-2xl text-navyBlue peer-checked:icon-check-box peer-checked:text-navyBlue cursor-pointer"
                                        for="is-subscribed"
                                    ></label>

                                    <label
                                        class="ltr:pl-0 rtl:pr-0 text-base text-[#6E6E6E] max-sm:text-xs select-none cursor-pointer"
                                        for="is-subscribed"
                                    >
                                        @lang('shop::app.customers.signup-form.subscribe-to-newsletter')
                                    </label>
                                </div>
                            @endif

                            {!! view_render_event('bagisto.shop.customers.signup_form.newsletter_subscription.after') !!}

                            <div class="flex gap-9 flex-wrap items-center mt-4">
                                <button
                                    class="primary-button block w-full max-w-[374px] py-4 px-11 mx-auto m-0 ltr:ml-0 rtl:mr-0 rounded-2xl text-base text-center"
                                    type="submit"
                                >
                                    @lang('shop::app.customers.signup-form.button-title')
                                </button>
                            </div>

                            {!! view_render_event('bagisto.shop.customers.signup_form_controls.after') !!}

                        </x-shop::form>
                    </div>
                    <p class="mt-5 text-[#6E6E6E] font-medium">
                        @lang('shop::app.customers.signup-form.account-exists')

                        <a class="text-navyBlue"
                           href="{{ route('shop.customer.session.index') }}"
                        >
                            @lang('shop::app.customers.signup-form.sign-in-button')
                        </a>
                    </p>
                    <p class="mt-8 mb-4 text-center text-[#6E6E6E] text-xs">
                        @lang('shop::app.customers.signup-form.footer', ['current_year'=> date('Y') ])
                    </p>
                </div>
            </div>
            <div class="hidden lg:block relative w-0 flex-1">
                <img
                    class="absolute inset-0 h-full w-full object-cover"
                    src="https://images.unsplash.com/photo-1528276249722-d94942cdf372?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt=""
                />
            </div>
        </div>

    @push('scripts')
        {!! Captcha::renderJS() !!}
    @endpush
</x-shop::layouts>
