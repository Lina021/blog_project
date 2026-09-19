<x-layouts.guest title="Log in">
    <h1 class="text-2xl font-semibold">Log in</h1>

    @if ($errors->any())
        <div class="mt-6 rounded-md bg-red-50 p-4 text-sm text-red-700" role="alert">
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
            <label for="email" class="block text-sm font-medium">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label for="password" class="block text-sm font-medium">Password</label>
            <input id="password" name="password" type="password" required autocomplete="current-password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <label class="flex items-center gap-2 text-sm text-gray-600">
            <input name="remember" type="checkbox" value="1" class="rounded border-gray-300">
            Remember me
        </label>
        <button type="submit" class="w-full rounded-md bg-gray-900 px-4 py-2 font-medium text-white hover:bg-gray-700">Log in</button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="font-medium underline">Register</a></p>
</x-layouts.guest>