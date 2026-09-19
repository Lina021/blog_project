<x-layouts.guest title="Register">
    <h1 class="text-2xl font-bold">Create an account</h1>

    @if ($errors->any())
        <div class="mt-6 rounded bg-red-50 p-3 text-sm text-red-700" role="alert">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-5">
        @csrf
        <div>
            <label for="name" class="mb-1 block font-medium">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name" class="w-full rounded border px-3 py-2 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand">
        </div>
        <div>
            <label for="email" class="mb-1 block font-medium">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" class="w-full rounded border px-3 py-2 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand">
        </div>
        <div>
            <label for="password" class="mb-1 block font-medium">Password</label>
            <input id="password" name="password" type="password" required autocomplete="new-password" class="w-full rounded border px-3 py-2 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand">
        </div>
        <div>
            <label for="password_confirmation" class="mb-1 block font-medium">Confirm password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="w-full rounded border px-3 py-2 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand">
        </div>
        <x-button class="w-full justify-center !py-2">Register</x-button>
    </form>

    <p class="mt-6 text-center text-sm text-ink/70">Already registered? <a href="{{ route('login') }}" class="font-medium text-brand-dark underline">Log in</a></p>
</x-layouts.guest>
