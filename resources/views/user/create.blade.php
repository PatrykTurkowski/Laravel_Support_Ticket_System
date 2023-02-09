<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Creator') }}
        </h2>
    </x-slot>
    <x-auth-card>
        <x-splade-form action="{{ route('users.store') }}" class="space-y-4">
            <x-splade-input id="name" type="text" name="name" :label="__('Name')" required autofocus />
            <x-splade-input id="email" type="email" name="email" :label="__('Email')" required />
            <x-splade-select id="role" name="role" :options="$roles" :label="__('Role')" required />
            <x-splade-input id="password" type="password" name="password" :label="__('Password')" required
                autocomplete="new-password" />
            <x-splade-input id="password_confirmation" type="password" name="password_confirmation" :label="__('Confirm Password')"
                required />

            <div class="flex items-center justify-end">
                <x-splade-submit class="ml-4" :label="__('Create')" />
            </div>
        </x-splade-form>
    </x-auth-card>
</x-app-layout>
