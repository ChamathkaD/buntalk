<!-- SEO Meta Content -->
@push('meta')
    <meta name="description" content="@lang('shop::app.customers.reset-password.title')"/>

    <meta name="keywords" content="@lang('shop::app.customers.reset-password.title')"/>
@endPush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.reset-password.title')
    </x-slot>

    <div class="min-h-screen flex">
            <div
                class="flex-1 flex flex-col justify-center py-2 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24"
            >
                <div class="mx-auto w-full max-w-sm lg:w-96">
                    <div>
                        {!! view_render_event('bagisto.shop.customers.reset_password.logo.before') !!}
                        <a href="{{ route('shop.home.index') }}"  class="m-[0_auto_20px_auto]"  aria-label="@lang('shop::app.customers.login-form.bagisto')">
                            <img
                                class="h-12 w-auto"
                                src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                                alt="{{ config('app.name') }}"
                            />
                        </a>
                        {!! view_render_event('bagisto.shop.customers.reset_password.logo.after') !!}
                        <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                            @lang('shop::app.customers.reset-password.title')
                        </h2>
                    </div>

                    <div class="mt-8">
                        {!! view_render_event('bagisto.shop.customers.reset_password.before') !!}
                        <x-shop::form :action="route('shop.customers.reset_password.store')" >
                            <x-shop::form.control-group.control
                                type="hidden"
                                name="token"
                                :value="$token"
                            />

                            {!! view_render_event('bagisto.shop.customers.reset_password_form_controls.before') !!}

                            <x-shop::form.control-group>
                                <x-shop::form.control-group.label class="required">
                                    @lang('shop::app.customers.reset-password.email')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="email"
                                    id="email"
                                    name="email"
                                    rules="required|email"
                                    :value="old('email')"
                                    :label="trans('shop::app.customers.reset-password.email')"
                                    placeholder="email@example.com"
                                    aria-label="@lang('shop::app.customers.reset-password.email')"
                                    aria-required="true"
                                />

                                <x-shop::form.control-group.error control-name="email" />
                            </x-shop::form.control-group>

                            <x-shop::form.control-group class="mb-6">
                                <x-shop::form.control-group.label class="required">
                                    @lang('shop::app.customers.reset-password.password')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="password"
                                    name="password"
                                    rules="required|min:6"
                                    value=""
                                    :label="trans('shop::app.customers.reset-password.password')"
                                    :placeholder="trans('shop::app.customers.reset-password.password')"
                                    ref="password"
                                    aria-label="@lang('shop::app.customers.reset-password.password')"
                                    aria-required="true"
                                />

                                <x-shop::form.control-group.error control-name="password" />
                            </x-shop::form.control-group>

                            <x-shop::form.control-group class="mb-6">
                                <x-shop::form.control-group.label>
                                    @lang('shop::app.customers.reset-password.confirm-password')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="password"
                                    name="password_confirmation"
                                    rules="confirmed:@password"
                                    value=""
                                    :label="trans('shop::app.customers.reset-password.confirm-password')"
                                    :placeholder="trans('shop::app.customers.reset-password.confirm-password')"
                                    aria-label="@lang('shop::app.customers.reset-password.confirm-password')"
                                    aria-required="true"
                                />

                                <x-shop::form.control-group.error control-name="password" />
                            </x-shop::form.control-group>

                            {!! view_render_event('bagisto.shop.customers.reset_password_form_controls.after') !!}

                            {!! view_render_event('bagisto.shop.customers.reset_password.submit_button.before') !!}

                            <div class="flex gap-9 flex-wrap mt-8 items-center">
                                <button
                                    class="primary-button block w-full max-w-[374px] py-4 px-11 m-0 ltr:ml-0 rtl:mr-0 mx-auto rounded-2xl text-base text-center"
                                    type="submit"
                                >
                                    @lang('shop::app.customers.reset-password.submit-btn-title')
                                </button>
                            </div>

                            {!! view_render_event('bagisto.shop.customers.reset_password.submit_button.after') !!}
                        </x-shop::form>
                        {!! view_render_event('bagisto.shop.customers.reset_password.after') !!}
                    </div>
                    <p class="mt-8 mb-4 text-center text-[#6E6E6E] text-xs">
                        @lang('shop::app.customers.login-form.footer', ['current_year'=> date('Y') ])
                    </p>
                </div>
            </div>
            <div class="hidden lg:block relative w-0 flex-1">
                <img
                    class="absolute inset-0 h-full w-full object-cover"
                    src="https://images.unsplash.com/photo-1606755962773-d324e0a13086?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt=""
                />
            </div>
        </div>
</x-shop::layouts>
