<x-layouts.app>

    <div class="space-y-3">
        <x-ui.panel>

            <h1 class="font-extrabold text-xl md:text-3xl mb-3">{{__('Statistics')}}</h1>
        </x-ui.panel>

        <div class="grid md:grid-cols-3 gap-3">
            <x-ui.result-panel>
                @slot('title')
                    {{__('Total sieges')}}
                @endslot
                {{\App\Models\Siege::all()->count()}}
            </x-ui.result-panel>

            <x-ui.result-panel>
                @slot('title')
                    {{__('Complete sieges')}}
                @endslot
                {{\App\Models\Siege::query()->where('status', \App\Enums\SiegeStatus::Complete)->count()}}
            </x-ui.result-panel>

            <x-ui.result-panel>
                @slot('title')
                    {{__('Failed sieges')}}
                @endslot
                {{\App\Models\Siege::query()->where('status', \App\Enums\SiegeStatus::Failed)->count()}}
            </x-ui.result-panel>
        </div>


    </div>
</x-layouts.app>
