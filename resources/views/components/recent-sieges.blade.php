@props(['activeSiege' => null])
<?php
$siegeSession = app(\App\Support\SiegeSession::class);
$recentSieges = $siegeSession->getSieges()->reverse();
?>
@if($recentSieges->isNotEmpty())
    <div {{$attributes->merge(['class' => 'space-y-4'])}}>
        <h2 class="text-xl font-bold">{{__('Recent sieges')}}</h2>

        <x-ui.panel>
            <ul class="space-y-2">
                @foreach($recentSieges as $siege)
                    <li>
                        <a
                            @class(['underline text-primary-500 hover:text-primary-600', 'font-bold' => $siege->is($activeSiege)])
                            href="{{ route('sieges.details', $siege) }}">Siege #{{$siege->getKey()}}</a>
                    </li>
                @endforeach
            </ul>

        </x-ui.panel>

    </div>
@endif


