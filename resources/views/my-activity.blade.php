<x-layouts.layout title="My Activity">
    <div class="mb-6">
        <p class="text-sm text-ink/60">Signed in as {{ auth()->user()->email }}</p>
        <h1 class="text-2xl font-bold">My Activity</h1>
    </div>

    <section class="mb-10">
        <div class="mb-3 flex items-center justify-between">
            <h2 class="text-xl font-semibold">My Posts ({{ $posts->count() }})</h2>
            <x-button :href="route('posts.create')">New Post</x-button>
        </div>

        <div class="space-y-3">
            @forelse ($posts as $post)
                <div class="flex items-center gap-4 rounded-lg bg-white p-4 shadow-sm">
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="" class="h-16 w-24 shrink-0 rounded object-cover">
                    @else
                        <div class="h-16 w-24 shrink-0 rounded bg-brand/20"></div>
                    @endif
                    <div class="min-w-0 flex-1">
                        <a href="{{ route('posts.show', $post) }}" class="font-semibold hover:underline">{{ $post->title }}</a>
                        <p class="text-sm text-ink/60">{{ $post->isEdited() ? 'edited ' . $post->updated_at->diffForHumans() : $post->created_at->diffForHumans() }} · {{ $post->comments_count }} comments</p>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <x-button variant="secondary" :href="route('posts.edit', $post)">Edit</x-button>
                        <form method="POST" action="{{ route('posts.destroy', $post) }}" onsubmit="return confirm('Delete this post?')">
                            @csrf
                            @method('DELETE')
                            <x-button variant="danger">Delete</x-button>
                        </form>
                    </div>
                </div>
            @empty
                <p>You haven't written any posts yet.</p>
            @endforelse
        </div>
    </section>

    <section>
        <h2 class="mb-3 text-xl font-semibold">My Comments ({{ $comments->count() }})</h2>

        <div class="space-y-3">
            @forelse ($comments as $comment)
                <div class="rounded-lg bg-white p-4 shadow-sm">
                    <p>{{ $comment->comment }}</p>
                    <p class="mt-1 text-sm text-ink/60">
                        on <a href="{{ route('posts.show', $comment->post) }}" class="underline">{{ $comment->post->title }}</a>
                        · {{ $comment->created_at->diffForHumans() }}
                    </p>
                </div>
            @empty
                <p>You haven't commented yet.</p>
            @endforelse
        </div>
    </section>
</x-layouts.layout>
