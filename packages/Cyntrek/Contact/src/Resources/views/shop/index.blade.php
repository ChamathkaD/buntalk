<x-shop::layouts>

    <!-- Title of the page -->
    <x-slot:title>
        Contact
    </x-slot>

    <div class="main">
        <div class="relative bg-white">
            <div class="lg:absolute lg:inset-0">
                <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
                    <iframe width="100%"
                            height="100%" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7936.0180567217085!2d80.29869105342986!3d5.993491335688357!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae16d8acb9dcc4f%3A0x282855d3e8d9573d!2sBun%20Talk!5e0!3m2!1sen!2slk!4v1709228383344!5m2!1sen!2slk" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="relative py-16 px-4 sm:py-24 sm:px-6 lg:px-8 lg:max-w-7xl lg:mx-auto lg:py-32 lg:grid lg:grid-cols-2">
                <div class="lg:pr-8">
                    <div class="max-w-md mx-auto sm:max-w-lg lg:mx-0">
                        <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">Contact with us</h2>
                        <p class="mt-4 text-lg text-gray-500 sm:mt-3">We’d love to hear from you! Send us a message using the form opposite, or email us. We’d love to hear from you! Send us a message using the form opposite, or email us.</p>
                        <ul class="my-4 text-gray-500 mt-8">
                            <li class="flex space-x-3 mt-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                                </svg>
                                <span>
                                    Katukurunda, Habaraduwa, Sri Lanka
                                </span>
                            </li>

                            <li class="flex space-x-3 mt-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                </svg>
                                <span>
                                    +94 123 456 7890
                                </span>
                            </li>

                            <li class="flex space-x-3 mt-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                                <span>
                                    info@buntalk.lk
                                </span>
                            </li>
                        </ul>
                        <form action="{{ route('shop.contact.store') }}" method="POST" class="mt-9 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                            @csrf
                            <div>
                                <label for="first-name" class="block text-sm font-medium text-gray-700">First name</label>
                                <div class="mt-1">
                                    <input type="text" name="first_name" id="first-name" class="form-input block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" value="{{ old('first_name') }}">
                                </div>
                                @error('first_name')
                                <div class="text-red-500 text-xs">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="last-name" class="block text-sm font-medium text-gray-700">Last name</label>
                                <div class="mt-1">
                                    <input type="text" name="last_name" id="last-name" class="form-input block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" value="{{ old('last_name') }}">
                                </div>
                                @error('last_name')
                                <div class="text-red-500 text-xs">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <div class="mt-1">
                                    <input id="email" name="email" type="email" class="form-input block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" value="{{ old('email') }}">
                                </div>
                                @error('email')
                                <div class="text-red-500 text-xs">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <div class="flex justify-between">
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                    <span id="phone-description" class="text-sm text-gray-500">Optional</span>
                                </div>
                                <div class="mt-1">
                                    <input type="text" name="phone" id="phone" aria-describedby="phone-description" class="form-input block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" value="{{ old('phone') }}">
                                    @error('phone')
                                    <div class="text-red-500 text-xs">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <div class="flex justify-between">
                                    <label for="message" class="block text-sm font-medium text-gray-700">How can we help you?</label>
                                    <span id="message-description" class="text-sm text-gray-500">Max. 500 characters</span>
                                </div>
                                <div class="mt-1">
                                    <textarea id="message" name="message" aria-describedby="message" rows="4" class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border border-gray-300 rounded-md">{{old('message')}}</textarea>
                                    @error('message')
                                    <div class="text-red-500 text-xs">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @if (core()->getConfigData('customer.captcha.credentials.status'))
                                <div class="flex mt-5">
                                    {!! Captcha::render() !!}
                                </div>
                            @endif
                            <div class="text-right sm:col-span-2">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-shop::layouts>
