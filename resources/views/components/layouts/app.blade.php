<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{config('app.name')}}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{mix('assets/css/app.css')}}">
    <script src="{{mix('assets/js/app.js')}}" defer></script>
    <livewire:styles />
</head>
<body class="antialiased bg-gray-100 h-screen">

    <div class="flex flex-col min-h-screen">

        <header class="
            bg-white border-b-2 border-b-primary-500 shadow-sm
            px-3 md:px-5 py-3
            flex justify-between items-center
            ">
            <a
                href="{{url(\App\Providers\RouteServiceProvider::HOME)}}"
                class="text-lg"
            >
                <span class="font-extrabold">{{config('app.name')}}</span> <span class="text-gray-500">Zero setup load testing</span>
            </a>

            <a href="{{config('vcs.url')}}">
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

            <div class="flex gap-4">
                <a href="{{config('vcs.roadmap_url')}}">Roadmap</a>
                <a href="{{config('support.buy_me_a_coffee_url')}}">{{__('Buy me a coffee')}}</a>
                <a href="{{route('imprint')}}">{{__('Imprint')}}</a>
            </div>
        </footer>
    </div>
    <livewire:scripts />
</body>
</html>
