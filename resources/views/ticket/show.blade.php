<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ticket') }}
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

        <x-splade-form class="space-y-4" :default="[
            'title' => $ticket->title,
            'description' => $ticket->description,
            'label_id' => $ticket->checkLabels(),
            'category_id' => $ticket->checkCategories(),
            'priority_id' => $ticket->priority_id,
            'files' => $files,
        ]">
            <x-splade-input id="title" type="text" name="title" :label="__('Title')" disabled />
            <x-splade-textarea name="description" :label="__('Description')" autosize disabled />
            <x-splade-group name="tags" label="Pick one or more interests">
                @foreach ($labels as $key => $label)
                    <x-splade-checkbox id="label" name="label_id[]" value='{{ $key }}' :label="__($label)"
                        disabled relation />
                @endforeach
            </x-splade-group>
            <x-splade-group name="tags" label="Pick one or more interests">
                @foreach ($categories as $key => $category)
                    <x-splade-checkbox id="category" name="category_id[]" value='{{ $key }}' :label="__($category)"
                        disabled relation />
                @endforeach
            </x-splade-group>

            <x-splade-select id="priority" name="priority_id" :options="$priorities" :label="__('Priority')" required disabled />
            <x-splade-file name="files[]" multiple filepond server preview :label="__('Files')" max-size="5000Kb"
                disabled />
        </x-splade-form>




        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    @foreach ($comments as $comment)
                        <div class="flex pb-1 mt-4 justify-between">
                            <h2 class="font-semibold text-lg text-gray-600  leading-tight">
                                @if (auth()->id() == $comment->user_id)
                                    {{ __('Me') }}:
                                @else
                                    {{ $comment->name }}:
                                @endif

                            </h2>
                            <Link modal class="text-gray-500 text-sm "
                                href="{{ route('comments.edit', $comment->id) }}">
                            {{ __('edit') }}</Link>
                        </div>
                        <div class="p-4 bg-white border border-gray-200">
                            {{ $comment->content }}
                        </div>
                        <div class="text-sm text-right text-gray-400">
                            @if ($comment->created_at != $comment->updated_at)
                                ({{ __('edited') }})
                            @endif
                            {{ $comment->updated_at }}
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
        <x-splade-form class="space-y-4" action="{{ route('comments.store', $ticket) }}">
            <x-splade-textarea name="content" :label="__('Comment')" autosize />
            <div class="flex items-center justify-end">
                <x-splade-submit class="ml-4" :label="__('Add Comment')" />
            </div>
        </x-splade-form>
    </x-auth-card>

    <script src="{{ asset('resources/js/disabledCheckbox.js') }}" type="module"></script>
</x-app-layout>
