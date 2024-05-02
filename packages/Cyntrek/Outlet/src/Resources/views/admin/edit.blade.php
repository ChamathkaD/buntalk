@php
    $allLocales = app('Webkul\Core\Repositories\LocaleRepository')->all();
@endphp

<x-admin::layouts>
    <!-- Title of the page -->
    <x-slot:title>
        Edit Outlet
    </x-slot>

    <!-- Edit Attributes Vue Components -->
    <v-edit-attributes :all-locales="{{ $allLocales->toJson() }}"></v-edit-attributes>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-edit-attributes-template"
        >

            <!-- Input Form -->
            <x-admin::form
                :action="route('admin.outlet.update', $outlet->id)"
                method="PUT"
            >
                <div class="flex justify-between items-center">
                    <p class="text-xl text-gray-800 dark:text-white font-bold">
                        Edit Outlet
                    </p>

                    <div class="flex gap-x-2.5 items-center">
                        <!-- Back Button -->
                        <a
                            href="{{ route('admin.outlet.index') }}"
                            class="transparent-button hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-white"
                        >
                            Back
                        </a>

                        <!-- Save Button -->
                        <button
                            type="submit"
                            class="primary-button"
                        >
                            Save Outlet
                        </button>
                    </div>
                </div>

                <!-- body content -->
                <div class="flex gap-2.5 mt-3.5">
                    <!-- Left sub Component -->
                    <div class="flex flex-col flex-1 gap-2 overflow-auto">

                        <!-- Label -->
                        <div class="p-4 bg-white dark:bg-gray-900 box-shadow rounded">

                            <!-- name -->
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required">
                                    Name
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="text"
                                    name="name"
                                    rules="required"
                                    :value="old('name') ?: $outlet->name"
                                    label="Name"
                                    placeholder="Enter Name"
                                />

                                <x-admin::form.control-group.error control-name="name" />
                            </x-admin::form.control-group>

                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label>
                                    Address
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="text"
                                    name="address"
                                    :value="old('address') ?: $outlet->address"
                                    label="Address"
                                    placeholder="Enter Address"
                                />

                                <x-admin::form.control-group.error control-name="address" />
                            </x-admin::form.control-group>

                            <!-- Description -->
                            <x-admin::form.control-group class="!mb-0">
                                <x-admin::form.control-group.label>
                                    Description
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="textarea"
                                    id="description"
                                    name="description"
                                    :value="old('description') ?: $outlet->description"
                                    label="Description"
                                    placeholder="Description"
                                />

                                <x-admin::form.control-group.error control-name="description" />
                            </x-admin::form.control-group>
                        </div>
                    </div>
                </div>
            </x-admin::form>

        </script>

        <script type="module">
            app.component('v-edit-attributes', {
                template: '#v-edit-attributes-template',

                props: ['allLocales'],
            });
        </script>
    @endPushOnce
</x-admin::layouts>
