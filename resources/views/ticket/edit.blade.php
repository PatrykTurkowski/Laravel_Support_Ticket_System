<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ticket Creator') }}
        </h2>
    </x-slot>
    <x-auth-card>
        @can(auth()->user()->role != App\Enums\RoleEnum::USER->value)
            <x-splade-form class="space-y-4" :default="$ticket" action="{{ route('ticketStatus', $ticket) }}" method="PATCH">
                <x-splade-select id="status" name="status_id" :options="$statuses" :label="__('Status')" required />

                <div class="flex items-center justify-end">
                    <x-splade-submit class="ml-4" :label="__('Change Status')" />
                </div>
            </x-splade-form>
        @endcan

        <x-splade-form class="space-y-4" method="PATCH" action="{{ route('tickets.update', $ticket) }}" :default="[
            'title' => $ticket->title,
            'description' => $ticket->description,
            'label_id' => $ticket->checkLabels(),
            'category_id' => $ticket->checkCategories(),
            'priority_id' => $ticket->priority_id,
            'files' => $files,
        ]">
            <x-splade-input id="title" type="text" name="title" :label="__('Title')" />
            <x-splade-textarea name="description" :label="__('Description')" autosize />
            <x-splade-group name="tags" label="Pick one or more interests">
                @foreach ($labels as $key => $label)
                    <x-splade-checkbox id="label" name="label_id[]" value='{{ $key }}' :label="__($label)"
                        relation />
                @endforeach
            </x-splade-group>
            <x-splade-group name="tags" label="Pick one or more interests">
                @foreach ($categories as $key => $category)
                    <x-splade-checkbox id="category" name="category_id[]" value='{{ $key }}' :label="__($category)"
                        relation />
                @endforeach
            </x-splade-group>

            <x-splade-select id="priority" name="priority_id" :options="$priorities" :label="__('Priority')" required />
            <x-splade-file name="files[]" multiple filepond server preview :label="__('Files')" max-size="5000Kb" />

            <div class="flex items-center justify-end">
                <x-splade-submit class="ml-4" :label="__('Update')" />
            </div>
        </x-splade-form>
    </x-auth-card>
    <span class="mt-6"> </span>
</x-app-layout>
