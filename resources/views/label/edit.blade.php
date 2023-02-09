<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Label Update') }}
        </h2>
    </x-slot>
    <x-auth-card>
        <x-splade-form :default="$label" action="{{ route('labels.update', $label) }}" method="PATCH" class="space-y-4">
            <x-splade-input id="name" type="text" name="name" :label="__('Name')" required autofocus />

            <div class="flex items-center justify-end">
                <x-splade-submit class="ml-4" :label="__('Update')" />
            </div>
        </x-splade-form>
    </x-auth-card>
</x-app-layout>
