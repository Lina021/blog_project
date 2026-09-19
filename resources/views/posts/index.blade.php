<x-layouts.layout title="All Posts">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Latest Posts</h1>
        @auth
            <x-button :href="route('posts.create')">New Post</x-button>
        @endauth
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        @forelse ($posts as $post)
            <article class="flex flex-col overflow-hidden rounded-lg bg-white shadow-sm">
                @if ($post->image)
                    <a href="{{ route('posts.show', $post) }}" class="block h-48 w-full bg-page">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="h-full w-full object-contain">
                    </a>
                @endif
                <div class="flex flex-1 flex-col p-5">
                    <a href="{{ route('posts.show', $post) }}" class="text-lg font-semibold hover:underline">{{ $post->title }}</a>
                    <p class="mt-1 text-sm text-ink/60">by {{ $post->user->name }} · {{ $post->created_at->diffForHumans() }}</p>
                    <p class="mt-2 flex-1">{{ Str::limit($post->content, $post->image ? 150 : 500) }}</p>

                    @if ($post->tags->isNotEmpty())
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach ($post->tags as $tag)
                                <span class="rounded bg-page px-2 py-1 text-xs">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </article>
        @empty
            <p>No posts yet.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $posts->links() }}</div>
</x-layouts.layout>
