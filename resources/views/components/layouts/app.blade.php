<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{config('app.name')}}</title>

    <link rel="stylesheet" href="{{mix('assets/css/app.css')}}">
    <script src="{{mix('assets/js/app.js')}}" defer></script>
    <livewire:styles />
</head>
<body class="antialiased bg-gray-100 h-screen">

    <div class="flex flex-col min-h-screen">

        <header class="
            text-secondary-500 bg-white border-b border-b-gray-100 shadow-sm
            px-3 md:px-5 py-3
            flex justify-between items-center
            ">
            <a href="{{url(\App\Providers\RouteServiceProvider::HOME)}}"
               class="font-bold text-2xl"
            >
                {{config('app.name')}}
            </a>

            <a href="https://github.com/DiskoPete/under-siege">
                <x-fab-github class="w-8 aspect-square fill-black" />
            </a>

        </header>

        <main class="max-w-screen-xl mx-auto p-3 md:p-5 w-full">
            {{$slot}}
        </main>

        <footer class="p-2 text-sm w-full mt-auto flex justify-between items-center">
            <div>
                &copy; {{date('Y')}} Peter Schwab
            </div>

            <a href="{{route('imprint')}}">{{__('Imprint')}}</a>
        </footer>
    </div>
    <livewire:scripts />
</body>
</html>
