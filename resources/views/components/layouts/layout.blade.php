<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'MyBlog' }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-page text-ink min-h-screen">
    <x-layouts.nav />

    <main class="max-w-5xl mx-auto px-4 py-8">
        @if (session('status'))
            <div class="mb-4 rounded bg-white px-4 py-2 text-brand-dark shadow-sm">{{ session('status') }}</div>
        @endif

        {{ $slot }}
    </main>
</body>
</html>
