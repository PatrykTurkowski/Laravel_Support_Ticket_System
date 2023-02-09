<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Log Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section>

                        <x-splade-form :default="$log" class="mt-6 space-y-6">
                            <x-splade-input id="log_name" name="log_name" type="text" :label="__('logName')" disabled />
                            <x-splade-input id="description" name="description" type="text" :label="__('description')"
                                disabled />
                            <x-splade-input id="subject_type" name="subject_type" type="text" :label="__('subject_type')"
                                disabled />
                            <x-splade-input id="event" name="event" type="text" :label="__('event')" disabled />
                            <x-splade-input id="subject_id" name="subject_id" type="text" :label="__('subject_id')"
                                disabled />
                            <x-splade-input id="causer_type" name="causer_type" type="text" :label="__('causer_type')"
                                disabled />
                            <x-splade-input id="causer_id" name="causer_id" type="text" :label="__('causer_id')" disabled />
                            {{--  --}}

                            @foreach ($log->properties as $key => $property)
                                <h4>{{ $key }}</h4>
                                <ul>
                                    @foreach ($property as $key => $item)
                                        <li>{{ $key . ': ' . $item }}</li>
                                    @endforeach
                                </ul>
                            @endforeach
                            <x-splade-input id="description" name="description" type="text" :label="__('description')"
                                disabled />
                            {{--  --}}
                            <x-splade-input id="batch_uuid" name="batch_uuid" type="text" :label="__('batch_uuid')"
                                disabled />
                            <x-splade-input id="created_at" name="created_at" type="text" :label="__('created_at')"
                                disabled />



                        </x-splade-form>
                    </section>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
