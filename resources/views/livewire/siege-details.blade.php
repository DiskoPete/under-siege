<?php
/**
 * @var \App\Models\Siege $siege
 */
?>
<div
    class="space-y-6"
    x-data="{showForm: false}"
>
    <x-ui.panel class="flex justify-between items-center">
        <h1 class="text-3xl font-bold">{{__('Siege #:id', ['id' => $siege->getKey()])}}</h1>

        <div class="flex items-center gap-2">
            <div class="font-bold text-sm text-gray-500">{{$siege->status->getDisplayName()}}</div>
            <div class="bg-black rounded-full p-2">
                <x-dynamic-component class="fill-white w-5 aspect-square" :component="$siege->status->getIconComponent()"/>
            </div>
        </div>

    </x-ui.panel>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-5 md:gap-8">
        <x-ui.panel class="md:col-span-2">
            <h2 class="font-bold text-xl mb-3">Configuration</h2>

            <div class="space-y-3">
                <div class="grid grid-cols-[auto_1fr] gap-x-3 gap-y-1">
                    <div>{{__('Target')}}</div>
                    <div class="overflow-hidden text-ellipsis"><a href="{{$siege->configuration->target}}"
                                                                  target="_blank"
                                                                  class="text-primary-500">{{$siege->configuration->target}}</a>
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

        <div class="md:col-span-3  space-y-3">
            <h3 class="font-bold text-2xl">Results</h3>


        @if($siege->results)
                <div class="grid grid-cols-6 gap-4">

                    <x-ui.result-panel class="col-span-full">
                        @slot('title')
                            {{__('Availability')}}
                        @endslot
                        {{$siege->results->availability}} %
                    </x-ui.result-panel>

                    <x-ui.result-panel class="col-span-3">
                        @slot('title')
                            {{__('Successful Requests')}}
                        @endslot
                        {{$siege->results->successful_transactions}}
                    </x-ui.result-panel>

                    <x-ui.result-panel class="col-span-3">
                        @slot('title')
                            {{__('Failed Requests')}}
                        @endslot
                        {{$siege->results->failed_transactions}}
                    </x-ui.result-panel>

                    <x-ui.result-panel class="col-span-2">
                        @slot('title')
                            {{__('Total Requests')}}
                        @endslot
                        {{$siege->results->transactions + $siege->results->failed_transactions}}
                    </x-ui.result-panel>

                    <x-ui.result-panel class="col-span-2">
                        @slot('title')
                            {{__('Requests/Second')}}
                        @endslot
                        {{$siege->results->transaction_rate}}
                    </x-ui.result-panel>

                    <x-ui.result-panel class="col-span-2">
                        @slot('title')
                            {{__('Concurrency')}}
                        @endslot
                        {{$siege->results->concurrency}}
                    </x-ui.result-panel>

                    <x-ui.result-panel class="col-span-full">
                        @slot('title')
                            {{__('Average response time')}}
                        @endslot
                        {{$siege->results->response_time * 1000}} ms
                    </x-ui.result-panel>

                    <x-ui.result-panel class="col-span-3">
                        @slot('title')
                            {{__('Shortest response time')}}
                        @endslot
                        {{$siege->results->shortest_transaction * 1000}} ms
                    </x-ui.result-panel>

                    <x-ui.result-panel class="col-span-3">
                        @slot('title')
                            {{__('Longest response time')}}
                        @endslot
                        {{$siege->results->longest_transaction * 1000}} ms
                    </x-ui.result-panel>
                </div>
            @else
                <x-ui.panel class="grow flex flex-col items-center justify-center gap-2">

                    @if($siege->status == \App\Enums\SiegeStatus::InProgress)

                        <div class="flex flex-col items-center space-y-4">
                            <div>
                                <x-dynamic-component :component="$siege->status->getIconComponent()"
                                                     class="fill-primary-500 w-14 aspect-square animate-spin"/>
                            </div>

                            @if($timeLeft)
                                <div x-data="countdown(@js($timeLeft))">
                                    About <span x-text="timeLeft"></span> seconds left
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="font-bold text-gray-600">
                            {{$siege->status->getDisplayName()}} ...
                        </div>
                    @endif
                    <p class="text-center">If this tool servers your purpose,<br>please do consider to <a
                            href="{{config('support.buy_me_a_coffee_url')}}" target="_blank"
                            class="text-primary-500">buy me a coffee</a>! ☕️</p>
                </x-ui.panel>

            @endif
        </div>
    </div>

    <x-ui.panel class="flex items-center justify-between">

        <a href="{{config('support.buy_me_a_coffee_url')}}" target="_blank"
           class="underline underline-offset-1">{{__('Buy me a coffee')}}</a>


        @if($siege->isComplete() || $siege->status == \App\Enums\SiegeStatus::Failed)
            <x-ui.button type="button" @click="showForm = true">{{__('Rerun siege')}}</x-ui.button>
        @endif
    </x-ui.panel>

    @if($siege->isComplete())
        <x-ui.panel x-cloak x-show="showForm" x-effect="showForm && $nextTick(() => $el.scrollIntoView({behavior: 'smooth', block: 'end'}))">
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
