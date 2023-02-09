<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ticket Creator') }}
        </h2>
    </x-slot>
    <x-auth-card>
        <x-splade-form action="{{ route('tickets.store') }}" class="space-y-4" :default="['files' => []]">
            <x-splade-input id="title" type="text" name="title" :label="__('Title')" required autofocus />
            <x-splade-textarea name="description" :label="__('Description')" autosize />
            <x-splade-checkboxes name="label_id" :label="__('Labels')" :options="$labels" />
            <x-splade-checkboxes name="category_id" :label="__('Categories')" :options="$categories" />
            <x-splade-select id="priority" name="priority_id" :options="$priorities" :label="__('Priority')" required />
            <x-splade-file name="files[]" multiple filepond server preview :label="__('Files')" max-size="5000Kb" />
            <div class="flex items-center justify-end">
                <x-splade-submit class="ml-4" :label="__('Create')" />
            </div>
        </x-splade-form>
    </x-auth-card>
    <span class="mt-6"> </span>
</x-app-layout>
