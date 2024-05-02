<x-admin::layouts>

    <!-- Title of the page -->
    <x-slot:title>
        Contacts
    </x-slot>

        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
            <!-- Title -->
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                Contacts
            </p>
        </div>

        <x-admin::datagrid :src="route('admin.contact.index')" />

</x-admin::layouts>
