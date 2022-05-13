<?php
/**
 * @var \App\Models\Siege $siege
 */
?>
<div
    class="space-y-3"
    x-data="{showForm: false}"
>

    <x-ui.panel class="flex justify-between items-center">
        <h1 class="text-3xl font-bold">{{__('Siege #:id', ['id' => $siege->getKey()])}}</h1>

        <div class="flex items-center gap-2">
            {{$siege->status->name}}
            <x-dynamic-component class="w-6 aspect-square" :component="$siege->status->getIconComponent()" />
        </div>

    </x-ui.panel>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <x-ui.panel>
            <h2 class="font-bold text-xl mb-3">Configuration</h2>

            <div class="space-y-3">
                <div class="grid grid-cols-[auto_1fr] gap-x-3 gap-y-1">
                    <div>{{__('Target')}}</div>
                    <div class="overflow-hidden text-ellipsis"><a href="{{$siege->configuration->target}}" target="_blank"
                                                                  class="text-secondary-500">{{$siege->configuration->target}}</a>
                    </div>
                    <div>{{__('Duration')}}</div>
                    <div>{{$siege->configuration->duration}} s</div>
                    <div>{{__('Concurrent Users')}}</div>
                    <div>{{$siege->configuration->concurrent}} Users</div>
                </div>

                @if($siege->configuration->headers)
                    <div class="space-y-2">
                        <h3 class="font-bold">Headers</h3>
                        <div class="grid grid-cols-[auto_1fr] gap-2">
                            @foreach($siege->configuration->headers as $name => $value)
                                <input value="{{$name}}" class="text-input grow-0 w-min" readonly>
                                <input value="{{$value}}" class="text-input" readonly>
                            @endforeach
                        </div>
                    </div>


                @endif
            </div>



        </x-ui.panel>

        <x-ui.panel class="flex flex-col">
            <h3 class="font-bold text-xl mb-3">Results</h3>

            @if($siege->results)
                <div class="grid grid-cols-2 gap-y-1">
                    <div class="col-span-2 font-bold">{{__('Requests')}}</div>
                    <div>{{__('Requests/Second')}}</div>
                    <div>{{$siege->results->transaction_rate}}</div>
                    <div>{{__('Successful Requests')}}</div>
                    <div>{{$siege->results->successful_transactions}}</div>
                    <div>{{__('Availability')}}</div>
                    <div>{{$siege->results->availability}}</div>
                    <div>{{__('Failed Requests')}}</div>
                    <div>{{$siege->results->failed_transactions}}</div>

                    <div class="col-span-2 font-bold mt-3">{{__('Durations')}}</div>
                    <div>{{__('Average response time')}}</div>
                    <div>{{$siege->results->response_time * 1000}} ms</div>
                    <div>{{__('Shortest response time')}}</div>
                    <div>{{$siege->results->shortest_transaction * 1000}} ms</div>
                    <div>{{__('Longest response time')}}</div>
                    <div>{{$siege->results->longest_transaction * 1000}} ms</div>
                    <div>{{__('Concurrency')}}</div>
                    <div>{{$siege->results->concurrency}}</div>

                </div>
            @else
                <div class="grow flex flex-col items-center justify-center gap-2">

                    @if($siege->status == \App\Enums\SiegeStatus::InProgress)

                        <div class="flex flex-col items-center space-y-4">
                            <div>
                                <x-dynamic-component :component="$siege->status->getIconComponent()" class="fill-secondary-500 w-14 aspect-square animate-spin" />
                            </div>

                            @if($timeLeft)
                                <div x-data="countdown(@js($timeLeft))">
                                    About <span x-text="timeLeft"></span> seconds left
                                </div>
                            @endif
                        </div>
                    @else
                        <div>
                            {{__('Pending')}} ...
                        </div>
                    @endif
                        <p class="text-center">If this tool servers your purpose,<br>please do consider to <a href="{{config('support.buy_me_a_coffee_url')}}" target="_blank" class="text-secondary-500">buy me a coffee</a>! ☕️</p>
                </div>

            @endif


        </x-ui.panel>
    </div>

    <x-ui.panel class="flex items-center justify-between">

        <a href="{{config('support.buy_me_a_coffee_url')}}" target="_blank" class="underline underline-offset-1">{{__('Buy me a coffee')}}</a>


    @if($siege->isComplete())
            <x-ui.button type="button" @click="showForm = true">{{__('Rerun siege')}}</x-ui.button>
        @endif
    </x-ui.panel>

    @if($siege->isComplete())
        <x-ui.panel x-cloak x-show="showForm">
            <x-sieges.create-form :siege="$siege" />
        </x-ui.panel>

    @endif

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('countdown', (timeLeft) => ({
                timeLeft,

                init() {
                    const id = setInterval(() => {
                        this.timeLeft--;

                        if (this.timeLeft === 0) {
                            clearInterval(id);
                        }
                    }, 1000);
                },
            }))
        })
    </script>


</div>
