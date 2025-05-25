<x-layout>
    <x-header>New Post</x-header>
    <x-errors />
    <form method="post" action="{{ route('posts.store') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf

        <x-posts.form />
    </form>
</x-layout>
