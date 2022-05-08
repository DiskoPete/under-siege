@props(['siege' => null])
@php
/**
 * @var \App\Models\Siege|null $siege
 */
$initialDuration = $siege?->configuration->duration ?: 30;
$initialConcurrentUsers = $siege?->configuration->concurrent ?: 25;
@endphp
<form
    method="post" action="{{route('sieges.create')}}"
      class="space-y-4"
>
    @csrf

    <x-ui.field>
        @slot('label')
            Url
        @endslot

        <input type="url" name="target" required class="px-3 py-1 border border-gray-200 w-full" value="{{$siege?->configuration->target ?: null }}">

    </x-ui.field>

    <x-ui.field>
        @slot('label')
            Duration (Seconds)
        @endslot

        <div x-data="{value: {{$initialDuration}} }" class="flex gap-3">
            <input class="grow" type="range" name="duration" min="10" max="{{ config('siege.max_duration')}}" required
                   x-model="value" value="{{$initialDuration}}">
            <div class="flex gap-2" x-cloak>
                <div><span x-text="value"></span> Seconds</div>
            </div>
        </div>


    </x-ui.field>

    <x-ui.field>
        @slot('label')
            {{__('Concurrent users')}}
        @endslot

        <div x-data="{value: {{$initialConcurrentUsers}} }" class="flex gap-3">
            <input class="grow" type="range" name="concurrent" min="5" max="{{ config('siege.max_concurrent_users')}}" required x-model="value" value="{{$initialConcurrentUsers}}">
            <div class="flex gap-2" x-cloak>
                <div><span x-text="value"></span> Users</div>
            </div>
        </div>

    </x-ui.field>

    <div class="flex justify-end">
        <x-ui.button type="submit">
            {{__('Start siege')}}
        </x-ui.button>
    </div>



</form>
