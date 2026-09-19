<x-layouts.layout title="Edit Post">
    <h1 class="text-2xl font-bold mb-6">Edit Post</h1>

    <form method="POST" enctype="multipart/form-data" action="{{ route('posts.update', $post) }}">
        @csrf
        @method('PUT')
        @include('posts._form')
        <x-button>Update</x-button>
    </form>
</x-layouts.layout>