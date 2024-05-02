<x-admin::layouts>

    <x-slot:title>
        Create Outlet
        </x-slot>

        <v-outlets>
            <div class="flex  gap-4 justify-between items-center max-sm:flex-wrap">
                <p class="text-xl text-gray-800 dark:text-white font-bold">
                    Create Outlet
                </p>

                <div class="flex gap-x-2.5 items-center">
                    <!-- Create currency Button -->
                    @if (bouncer()->hasPermission('settings.outlets.create'))
                        <button
                            type="button"
                            class="primary-button"
                        >
                            Outlets
                        </button>
                    @endif
                </div>
            </div>

            <!-- DataGrid Shimmer -->
            <x-admin::shimmer.datagrid />
        </v-outlets>

        @pushOnce('scripts')
            <script
                type="text/x-template"
                id="v-outlets-template"
            >
                <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
                    <p class="text-xl text-gray-800 dark:text-white font-bold">
                        Outlets
                    </p>

                    <div class="flex gap-x-2.5 items-center">
                        <!-- Create currency Button -->
                        @if (bouncer()->hasPermission('settings.outlets.create'))
                            <button
                                type="button"
                                class="primary-button"
                                @click="selectedOutlets=0; selectedOutlet={}; $refs.outletUpdateOrCreateModal.toggle()"
                            >
                                Create Outlet
                            </button>
                        @endif
                    </div>
                </div>

                <x-admin::datagrid
                    :src="route('admin.outlet.index')"
                    ref="datagrid"
                />

                <!-- Modal Form -->
                <x-admin::form
                    v-slot="{ meta, errors, handleSubmit }"
                    as="div"
                    ref="modalForm"
                >
                    <form
                        @submit="handleSubmit($event, updateOrCreate)"
                        ref="outletCreateForm"
                    >
                        <x-admin::modal ref="outletUpdateOrCreateModal">
                            <!-- Modal Header -->
                            <x-slot:header>
                                <p
                                    class="text-lg text-gray-800 dark:text-white font-bold"
                                    v-if="selectedOutlets"
                                >
                                    Edit Outlet
                                </p>

                                <p
                                    class="text-lg text-gray-800 dark:text-white font-bold"
                                    v-else
                                >
                                    Create New Outlet
                                </p>
                                </x-slot>

                                <!-- Modal Content -->
                                <x-slot:content>

                                    <x-admin::form.control-group.control
                                        type="hidden"
                                        name="id"
                                        v-model="selectedOutlet.id"
                                    />

                                    <!-- Name -->
                                    <x-admin::form.control-group>
                                        <x-admin::form.control-group.label class="required">
                                            Name
                                        </x-admin::form.control-group.label>

                                        <x-admin::form.control-group.control
                                            type="text"
                                            name="name"
                                            rules="required"
                                            :value="old('name')"
                                            v-model="selectedOutlet.name"
                                            label="Outlet Name"
                                            placeholder="Enter Outlet Name"
                                        />

                                        <x-admin::form.control-group.error control-name="name" />
                                    </x-admin::form.control-group>

                                    <!-- Address -->
                                    <x-admin::form.control-group>
                                        <x-admin::form.control-group.label>
                                           Address
                                        </x-admin::form.control-group.label>

                                        <x-admin::form.control-group.control
                                            type="text"
                                            name="address"
                                            :value="old('address')"
                                            v-model="selectedOutlet.address"
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
                                            v-model="selectedOutlet.description"
                                            label="Description"
                                            placeholder="Description"
                                        />

                                        <x-admin::form.control-group.error control-name="description" />
                                    </x-admin::form.control-group>

                                    </x-slot>

                                    <!-- Modal Footer -->
                                    <x-slot:footer>
                                        <div class="flex gap-x-2.5 items-center">
                                            <button
                                                type="submit"
                                                class="primary-button"
                                            >
                                                Save
                                            </button>
                                        </div>
                                        </x-slot>
                        </x-admin::modal>
                    </form>
                </x-admin::form>
            </script>

            <script type="module">
                app.component('v-outlets', {
                    template: '#v-outlets-template',

                    data() {
                        return {
                            selectedOutlet: {},

                            selectedOutlets: 0,
                        }
                    },

                    computed: {
                        gridsCount() {
                            let count = this.$refs.datagrid.available.columns.length;

                            if (this.$refs.datagrid.available.actions.length) {
                                ++count;
                            }

                            if (this.$refs.datagrid.available.massActions.length) {
                                ++count;
                            }

                            return count;
                        },
                    },

                    methods: {
                        updateOrCreate(params, { resetForm, setErrors  }) {
                            let formData = new FormData(this.$refs.outletCreateForm);

                            if (params.id) {
                                formData.append('_method', 'put');
                            }

                            this.$axios.post("{{ route('admin.outlet.store') }}", formData)
                                .then((response) => {
                                    this.$refs.outletUpdateOrCreateModal.close();

                                    this.$refs.datagrid.get();

                                    this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                    resetForm();
                                })
                                .catch(error => {
                                    if (error.response.status == 422) {
                                        setErrors(error.response.data.errors);
                                    }
                                });
                        },

                        editModal(url) {
                            this.$axios.get(url)
                                .then((response) => {
                                    this.selectedOutlet = response.data;

                                    this.$refs.outletUpdateOrCreateModal.toggle();
                                })
                                .catch(error => {
                                    this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message })
                                });
                        },
                    }
                })
            </script>
    @endPushOnce

</x-admin::layouts>
