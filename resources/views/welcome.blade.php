<x-layouts.app>
    <div>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad commodi delectus deleniti doloribus enim est excepturi exercitationem, fugiat laborum minus numquam optio possimus qui quod rem repellat saepe sapiente soluta.</p>

        <form method="post" action="{{route('sieges.create')}}"
            class="space-y-3"
        >
            @csrf

            <x-ui.field>
                @slot('label')
                    Url
                @endslot

                <input type="url" name="target" required class="px-3 py-1 border border-gray-200">

            </x-ui.field>

            <x-ui.field>
                @slot('label')
                    Duration (Seconds)
                @endslot

                <div x-data="{value: 30}" class="flex gap-3">
                    <input type="range" name="duration" min="10" max="60" required x-model="value">
                    <div class="flex gap-2">
                        <div><span x-text="value"></span> Seconds</div>
                    </div>
                </div>


            </x-ui.field>

            <x-ui.field>
                @slot('label')
                    {{__('Concurrent users')}}
                @endslot

                    <div x-data="{value: 25}" class="flex gap-3">
                        <input type="range" name="concurrent" min="5" max="50" required x-model="value">
                        <div class="flex gap-2">
                            <div><span x-text="value"></span> Users</div>
                        </div>
                    </div>

            </x-ui.field>

            <x-ui.button>
                {{__('Start siege')}}
            </x-ui.button>

        </form>
    </div>
</x-layouts.app>
