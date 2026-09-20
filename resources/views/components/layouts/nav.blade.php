@php
    $link = fn (bool $active) => $active ? 'font-bold' : 'hover:underline';
@endphp

<nav class="bg-white shadow text-ink">
    <div class="max-w-5xl mx-auto px-4 py-3 flex justify-between items-center">
        <a href="{{ route('posts.index') }}" class="font-bold text-lg">The Tech Blog</a>

        <div class="flex gap-4 items-center">
            <a href="{{ route('posts.index') }}" class="{{ $link(request()->routeIs('posts.index', 'posts.show')) }}">Posts</a>
            @auth
                <a href="{{ route('posts.create') }}" class="{{ $link(request()->routeIs('posts.create')) }}">New Post</a>
                <a href="{{ route('my-activity') }}" class="{{ $link(request()->routeIs('my-activity')) }}">My Activity</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="hover:underline">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="{{ $link(request()->routeIs('login')) }}">Login</a>
                <a href="{{ route('register') }}" class="{{ $link(request()->routeIs('register')) }}">Register</a>
            @endauth
        </div>
    </div>
</nav>
