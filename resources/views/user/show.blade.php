<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section>

                        <x-splade-form :default="$user" class="mt-6 space-y-6">
                            <x-splade-input id="name" name="name" type="text" :label="__('Name')" disabled
                                autocomplete="name" />
                            <x-splade-input id="email" name="email" type="email" :label="__('Email')" disabled
                                autocomplete="email" />
                            <x-splade-input id="role" name="role" :label="__('Role')" disabled />


                        </x-splade-form>
                    </section>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
