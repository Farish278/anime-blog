<x-layout>
    <x-header>Edit Post</x-header>
    <x-errors />
    <form method="post" action="{{ route('posts.update', $post) }}" class="space-y-6" enctype="multipart/form-data">
        @method('PATCH')
        @csrf

        <x-posts.form :post="$post" />
    </form>
</x-layout>
