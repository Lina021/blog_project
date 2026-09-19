<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gray-100 text-gray-900">
        <main class="mx-auto flex min-h-screen max-w-md items-center px-6 py-12">
            <section class="w-full rounded-lg bg-white p-8 shadow-sm">
                {{ $slot }}
            </section>
        </main>
    </body>
</html>