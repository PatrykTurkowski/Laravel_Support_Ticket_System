<x-app-layout>
    <x-slot name="header" class="flex justify-between">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Categories List') }}
            </h2>
            <Link
                href="{{ route('categories.create') }}"class="rounded-full p-1 bg-gray-100 hover:bg-gray-300 transition duration-150 ease-in-out ">
            {{ __('Create Category') }}</Link>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-splade-table :for="$categories">


                        @cell('action', $category)
                            @if (is_null($category->deleted_at))
                                <x-splade-link href="{{ route('categories.destroy', $category) }}"
                                    confirm="Do you want delete category?" confirm-text="Are you sure?"
                                    confirm-button="Yes, take me there!" cancel-button="No, keep me save!" method="delete">
                                    <i
                                        class="fa-solid fa-trash text-red-500 text-lg hover:text-red-700 transition duration-150 ease-in-out"></i>
                                </x-splade-link>
                            @else
                                <x-splade-link href="{{ route('categories.restore', $category) }}"
                                    confirm="Do you want restore category?" confirm-text="Are you sure?"
                                    confirm-button="Yes, restore it!" cancel-button="No, don't do that!" method="GET">
                                    <i
                                        class="fa-solid fa-trash-arrow-up text-yellow-300 text-lg hover:text-yellow-500 transition duration-150 ease-in-out"></i>
                                </x-splade-link>
                            @endif
                            <Link href="{{ route('categories.show', $category->id) }}">
                            <i
                                class="fa-solid fa-eye text-green-500 text-lg hover:text-green-700 transition duration-150 ease-in-out pl-1"></i>
                            </Link>
                            <Link href="{{ route('categories.edit', $category->id) }}">
                            <i
                                class="fa-solid fa-pen-to-square text-blue-500 text-lg hover:text-blue-700 transition duration-150 ease-in-out pl-2"></i>
                            </Link>
                        @endcell

                    </x-splade-table>





                </div>
            </div>
        </div>
    </div>
</x-app-layout>
