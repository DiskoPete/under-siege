@php
    /**
    * @see \App\View\Components\Ui\HeadersInput
    */
@endphp
<div x-data="headerInput(@js($getHeadersCollection()))" class="grid grid-cols-[repeat(2,1fr)_auto] gap-x-2 gap-y-3">

    <template x-for="(header, index) in headers">
        <div class="contents" :key="index">
            <input
                type="text"
                class="text-input"
                placeholder="{{__('Name')}}"
                required
                x-on:input="onInput($event, index, 0)"
                x-bind:value="header[0] || ''"
            >
            <input
                type="text"
                class="text-input"
                placeholder="{{__('Value')}}"
                x-on:input="onInput($event, index, 1)"
                x-bind:name="`headers[${header[0]}]`"
                x-bind:value="header[1] || ''"
            >
            <button
                type="button"
                @click="remove(index)"
                class="border border-black rounded px-2"
                title="{{__('Remove header')}}"
            >
                <x-fas-minus class="w-5 aspect-square"/>
            </button>
        </div>

    </template>


    <div class="col-span-3">

        <button type="button" @click="add" class="flex items-center gap-3 border border-black rounded p-2">
            {{__('Add Header')}}
            <x-fas-plus class="w-5 aspect-square"/>
        </button>
    </div>
</div>

@once
    <script>
        (() => {

            function registerComponent() {
                window.Alpine.data('headerInput', (headers = []) => ({
                    headers,
                    add() {
                        this.headers.push([]);
                    },
                    remove(index) {
                        this.headers.splice(index, 1);
                    },
                    onInput(event, index, updateIndex) {
                        this.headers[index][updateIndex] = event.target.value;
                    }
                }));
            }

            if (window.Alpine) {
                registerComponent();
                return;
            }

            document.addEventListener('alpine:init', registerComponent);
        })();

    </script>
@endonce
