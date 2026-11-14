<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Coursa</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100 text-gray-900">
        <div class="min-h-screen flex items-center justify-center px-6">
            <div class="text-center">
                <h1 class="font-bright-retro text-7xl text-teal-950">
                    Coursa
                </h1>
                <p class="text-gray-500 mt-4">
                    Manage your courses, notes, tasks and study schedule.
                </p>

                <div class="flex items-center justify-center gap-3 mt-8">
                    <a href="{{ route('login') }}" class="px-5 py-2.5 bg-teal-950 text-white rounded-lg
                     hover:bg-teal-900 transition">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-teal-950 text-white rounded-lg
                     hover:bg-teal-900 transition">
                        Register
                    </a>


                </div>

            </div>
        </div>
    </body>
</html>
