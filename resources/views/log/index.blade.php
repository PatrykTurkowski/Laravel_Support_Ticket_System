<x-app-layout>
    <x-slot name="header" class="flex justify-between">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Log List') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-splade-table :for="$logs">


                        @cell('action', $log)
                            <Link href="{{ route('logs.show', $log->id) }}">
                            <i
                                class="fa-solid fa-eye text-green-500 text-lg hover:text-green-700 transition duration-150 ease-in-out pl-1"></i>
                            </Link>
                        @endcell

                    </x-splade-table>





                </div>
            </div>
        </div>
    </div>
</x-app-layout>
