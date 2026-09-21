<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-page text-ink">
        <main class="mx-auto flex min-h-screen max-w-md flex-col justify-center px-6 py-12">
            <a href="{{ route('posts.index') }}" class="mb-6 text-center text-2xl font-bold">The Tech Blog</a>
            <section class="w-full rounded-lg bg-white p-8 shadow-sm">
                {{ $slot }}
            </section>
        </main>
    </body>
</html>
