<x-splade-modal>
    <x-splade-form class="space-y-4" :default="$comment" method="PATCH" action="{{ route('comments.update', $comment) }}">
        <x-splade-textarea name="content" :label="__('Comment')" autosize />
        <div class="flex items-center justify-end">
            <x-splade-submit class="ml-4" :label="__('Update')" />
        </div>
    </x-splade-form>
</x-splade-modal>
