<x-layouts.layout title="New Post">
    <h1 class="text-2xl font-bold mb-6">New Post</h1>

    <form method="POST" enctype="multipart/form-data" action="{{ route('posts.store') }}">
        @csrf
        @include('posts._form')
        <x-button>Publish</x-button>
    </form>
</x-layouts.layout>