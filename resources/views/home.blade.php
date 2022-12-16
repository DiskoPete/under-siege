<x-layouts.app>


    <div class="flex flex-col md:flex-row gap-5">

        <div class="flex-grow">
            <h1 class="text-xl md:text-3xl font-extrabold my-3 md:my-6 border-b-2 pb-1 md:pb-3">{{__('Configure your load test')}}</h1>

            <x-ui.panel>
                <x-sieges.create-form />
            </x-ui.panel>
        </div>


        <x-recent-sieges class="md:w-1/4" />
    </div>

</x-layouts.app>
