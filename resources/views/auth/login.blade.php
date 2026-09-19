<x-layouts.guest title="Log in">
    <h1 class="text-2xl font-bold">Log in</h1>

    @if ($errors->any())
        <div class="mt-6 rounded bg-red-50 p-3 text-sm text-red-700" role="alert">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
        @csrf
        <div>
            <label for="email" class="mb-1 block font-medium">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="w-full rounded border px-3 py-2 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand">
        </div>
        <div>
            <label for="password" class="mb-1 block font-medium">Password</label>
            <input id="password" name="password" type="password" required autocomplete="current-password" class="w-full rounded border px-3 py-2 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand">
        </div>
        <label class="flex items-center gap-2 text-sm text-ink/70">
            <input name="remember" type="checkbox" value="1" class="rounded accent-brand">
            Remember me
        </label>
        <x-button class="w-full justify-center !py-2">Log in</x-button>
    </form>

    <p class="mt-6 text-center text-sm text-ink/70">Don't have an account? <a href="{{ route('register') }}" class="font-medium text-brand-dark underline">Register</a></p>
</x-layouts.guest>
