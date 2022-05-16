<x-ui.panel {{$attributes->merge(['class' => 'text-center'])}}>
    <h4 class="font-bold text-gray-500 uppercase text-xs">
        {{$title}}
    </h4>
    <div class="text-xl font-bold pt-4 pb-2">{{$slot}}</div>
</x-ui.panel>
