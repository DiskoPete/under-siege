<?php
/**
 * @var \App\Models\Siege $siege
 */
?>
<div class="space-y-3">

    <x-ui.panel class="flex justify-between items-center">
        <h1 class="text-3xl font-bold">{{__('Siege #:id', ['id' => $siege->getKey()])}}</h1>

        <div>
            {{__('Status: :status', ['status' => $siege->status->name])}}
        </div>

    </x-ui.panel>

    <div class="grid grid-cols-2 gap-3">
        <x-ui.panel>
            <h2 class="font-bold text-xl mb-3">Configuration</h2>
            <div class="grid grid-cols-2">
                <div class="font-bold">{{__('Target')}}</div><div><a href="{{$siege->configuration->target}}" target="_blank" class="text-secondary-500">{{$siege->configuration->target}}</a></div>
                <div class="font-bold">{{__('Duration')}}</div><div>{{$siege->configuration->duration}} s</div>
                <div class="font-bold">{{__('Concurrent Users')}}</div><div>{{$siege->configuration->concurrent}} Users</div>
            </div>
        </x-ui.panel>

        <x-ui.panel class="flex flex-col">
            <h3 class="font-bold text-xl mb-3">Results</h3>

            @if($siege->results)
                <div class="grid grid-cols-2">
                    <div class="col-span-2 font-bold">{{__('Requests')}}</div>
                    <div>{{__('Requests/Second')}}</div><div>{{$siege->results->transaction_rate}}</div>
                    <div>{{__('Successful Requests')}}</div><div>{{$siege->results->successful_transactions}}</div>
                    <div>{{__('Availability')}}</div><div>{{$siege->results->availability}}</div>
                    <div>{{__('Failed Requests')}}</div><div>{{$siege->results->failed_transactions}}</div>

                    <div class="col-span-2 font-bold mt-3">{{__('Durations')}}</div>
                    <div>{{__('Average response time')}}</div><div>{{$siege->results->response_time * 1000}} ms</div>
                    <div>{{__('Shortest response time')}}</div><div>{{$siege->results->shortest_transaction * 1000}} ms</div>
                    <div>{{__('Longest response time')}}</div><div>{{$siege->results->longest_transaction * 1000}} ms</div>
                    <div>{{__('Concurrency')}}</div><div>{{$siege->results->concurrency}}</div>

                </div>
            @else
                <div class="grow flex items-center justify-center">

                    @if($siege->status == \App\Enums\SiegeStatus::InProgress)
                        <div x-data="countdown({{$siege->configuration->duration}})">
                            <span x-text="timeLeft"></span> Seconds
                        </div>
                    @else
                        {{__('Pending')}}
                    @endif

                </div>

            @endif


        </x-ui.panel>
    </div>

    <x-ui.panel>Actions</x-ui.panel>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('countdown', (timeLeft) => ({
                timeLeft,

                init() {
                    const id =  setInterval(() => {
                        this.timeLeft --;

                        if (this.timeLeft === 0) {
                            clearInterval(id);
                        }
                    }, 1000);
                },
            }))
        })
    </script>


</div>
