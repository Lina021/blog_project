@if ($errors->any())
    <div class="mb-4 bg-red-50 text-red-700 p-3 rounded">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-4">
    <label class="block font-medium mb-1">Title</label>
    <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}"
           class="w-full border rounded px-3 py-2 bg-white">
</div>

<div class="mb-4">
    <label class="block font-medium mb-1">Body</label>
    <textarea name="content" rows="8" class="w-full border rounded px-3 py-2 bg-white">{{ old('content', $post->content ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label class="block font-medium mb-1">Image</label>
    @if (isset($post) && $post->image)
        <img src="{{ asset('storage/' . $post->image) }}" alt="" class="h-32 rounded mb-2">
    @endif
    <input type="file" name="image" accept="image/*">
</div>

<div class="mb-4">
    <label class="block font-medium mb-1">Tags</label>
    <div class="flex flex-wrap gap-3">
        @foreach ($tags as $tag)
            <label class="flex items-center gap-1">
                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                    @checked(in_array($tag->id, old('tags', isset($post) ? $post->tags->pluck('id')->toArray() : [])))>
                {{ $tag->name }}
            </label>
        @endforeach
    </div>
</div>