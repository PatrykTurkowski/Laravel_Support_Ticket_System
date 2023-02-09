<x-app-layout>
    <x-slot name="header" class="flex justify-between">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ticket List') }}
            </h2>

            @can('create', App\Model\Ticket::class)
                <Link
                    href="{{ route('tickets.create') }}"class="rounded-full p-1 bg-gray-100 hover:bg-gray-300 transition duration-150 ease-in-out ">
                {{ __('Create ticket') }}</Link>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-splade-table :for="$tickets">
                        @cell('action', $ticket)
                            @can(false)
                                @if (is_null($ticket->deleted_at))
                                    <x-splade-link href="{{ route('tickets.destroy', $ticket) }}"
                                        confirm="Do you want delete ticket?" confirm-text="Are you sure?"
                                        confirm-button="Yes, take me there!" cancel-button="No, keep me save!" method="delete">
                                        <i
                                            class="fa-solid fa-trash text-red-500 text-lg hover:text-red-700 transition duration-150 ease-in-out"></i>
                                    </x-splade-link>
                                @else
                                    <x-splade-link href="{{ route('tickets.restore', $ticket) }}"
                                        confirm="Do you want restore ticket?" confirm-text="Are you sure?"
                                        confirm-button="Yes, restore it!" cancel-button="No, don't do that!" method="GET">
                                        <i
                                            class="fa-solid fa-trash-arrow-up text-yellow-300 text-lg hover:text-yellow-500 transition duration-150 ease-in-out"></i>
                                    </x-splade-link>
                                @endif
                            @endcan
                            <Link href="{{ route('tickets.show', $ticket->id) }}">
                            <i
                                class="fa-solid fa-eye text-green-500 text-lg hover:text-green-700 transition duration-150 ease-in-out pl-1"></i>
                            </Link>
                            @can(false)
                                <Link href="{{ route('tickets.edit', $ticket->id) }}">
                                <i
                                    class="fa-solid fa-pen-to-square text-blue-500 text-lg hover:text-blue-700 transition duration-150 ease-in-out pl-2"></i>
                                </Link>
                            @endcan
                        @endcell

                    </x-splade-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
