<x-layouts.layout :title="$post->title">
    <article class="mx-auto max-w-3xl overflow-hidden rounded-lg bg-white shadow-sm">
        @if ($post->image)
            <div class="aspect-video w-full bg-white">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="h-full w-full object-contain">
            </div>
        @endif

        <div class="p-6 sm:p-8">
            <h1 class="text-3xl font-bold mb-2">{{ $post->title }}</h1>
            <p class="text-sm text-ink/60 mb-6">
                by {{ $post->user->name }} ·
                @if ($post->isEdited())
                    Edited {{ $post->updated_at->format('M j, Y') }}
                @else
                    {{ $post->created_at->format('M j, Y') }}
                @endif
            </p>

            <div class="mb-6 whitespace-pre-line">{{ $post->content }}</div>

            @if ($post->tags->isNotEmpty())
                <div class="mb-6 flex flex-wrap gap-2">
                    @foreach ($post->tags as $tag)
                        <span class="rounded bg-page px-2 py-1 text-xs">{{ $tag->name }}</span>
                    @endforeach
                </div>
            @endif

            <div class="flex gap-3 mb-8">
                @can('update', $post)
                    <x-button variant="secondary" :href="route('posts.edit', $post)">Edit</x-button>
                @endcan
                @can('delete', $post)
                    <form method="POST" action="{{ route('posts.destroy', $post) }}"
                          onsubmit="return confirm('Delete this post?')">
                        @csrf
                        @method('DELETE')
                        <x-button variant="danger">Delete</x-button>
                    </form>
                @endcan
            </div>

            <hr class="mb-6 border-ink/10">

        <h2 class="text-xl font-semibold mb-4">Comments ({{ $post->comments->count() }})</h2>
        <div class="space-y-4 mb-8">
    @forelse ($post->comments as $comment)
        <div class="border-b pb-3">
            <p class="text-sm font-medium">{{ $comment->user->name }}
                <span class="text-ink/50 font-normal">· {{ $comment->created_at->diffForHumans() }}</span>
            </p>
            <p class="">{{ $comment->comment }}</p>

            @can('delete', $comment)
                <form method="POST" action="{{ route('comments.destroy', $comment) }}"
                      onsubmit="return confirm('Delete this comment?')">
                    @csrf
                    @method('DELETE')
                    <x-button variant="danger" class="!px-2 !py-1 !text-xs">Delete</x-button>
                </form>
            @endcan
        </div>
    @empty
        <p class="text-ink/60">No comments yet.</p>
    @endforelse
</div>

@auth
    <form method="POST" action="{{ route('comments.store', $post) }}">
        @csrf
        <textarea name="comment" rows="3" class="w-full border rounded px-3 py-2 mb-2"
                  placeholder="Write a comment...">{{ old('comment') }}</textarea>
        @error('comment') <p class="text-red-600 text-sm mb-2">{{ $message }}</p> @enderror
        <x-button>Submit Comment</x-button>
    </form>
@else
    <p><a href="{{ route('login') }}" class="text-brand-dark underline">Log in</a> to leave a comment.</p>
@endauth
        </div>
    </article>
</x-layouts.layout>