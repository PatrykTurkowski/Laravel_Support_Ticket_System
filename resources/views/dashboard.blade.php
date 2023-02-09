<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white flex flex-wrap overflow-hidden shadow-sm sm:rounded-lg ">


                            <div class=" pb-1 m-4 ">
                                <h2 class="font-semibold text-lg text-gray-600 my-4 text-center leading-tight">
                                    Tickets

                                </h2>
                                <div class="p-4 bg-white text-center border border-gray-200 ">
                                    {{ $countTicket }}
                                </div>
                            </div>
                            <div class=" pb-1 m-4 ">
                                <h2 class="font-semibold text-lg text-gray-600 my-4 text-center leading-tight">
                                    Open Tickets

                                </h2>
                                <div class="p-4 bg-white text-center border border-gray-200 ">
                                    {{ $open }}
                                </div>
                            </div>
                            <div class=" pb-1 m-4 ">
                                <h2 class="font-semibold text-lg text-gray-600 my-4 text-center leading-tight">
                                    tickets suspended

                                </h2>
                                <div class="p-4 bg-white text-center border border-gray-200 ">
                                    {{ $suspended }}
                                </div>
                            </div>
                            <div class=" pb-1 m-4 ">
                                <h2 class="font-semibold text-lg text-gray-600 my-4 text-center leading-tight">
                                    tickets closed

                                </h2>
                                <div class="p-4 bg-white text-center border border-gray-200 ">
                                    {{ $closed }}
                                </div>
                            </div>
                            <div class=" pb-1 m-4 ">
                                <h2 class="font-semibold text-lg text-gray-600 my-4 text-center leading-tight">
                                    Users

                                </h2>
                                <div class="p-4 bg-white text-center border border-gray-200 ">
                                    {{ $user }}
                                </div>
                            </div>
                            <div class=" pb-1 m-4 ">
                                <h2 class="font-semibold text-lg text-gray-600 my-4 text-center leading-tight">
                                    agent

                                </h2>
                                <div class="p-4 bg-white text-center border border-gray-200 ">
                                    {{ $agent }}
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
