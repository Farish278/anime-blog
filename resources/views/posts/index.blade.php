<x-layout>
    <x-main-buttons href="{{ route('posts.create') }}">
        <i class="fal fa-plus"></i> New Post
    </x-main-buttons>
    @foreach ($posts as $post)
        <article class="flex flex-col sm:flex-row items-center shadow-md shadow-gray-500/10">
            <img src="{{ asset($post->image) }}" class="sm:w-1/4 sm:aspect-square object-cover">
            <div class="flex w-full flex-col justify-between gap-4 p-8">
                <x-header :post="$post">{{ $post->title }}</x-header>
                <p class="leading-7">{{$post->excerpt}}</p>
                <x-main-buttons href="{{ route('posts.show', $post->slug) }}" class="mt-auto">
                    Read More <i class="fal fa-arrow-right"></i>
                </x-main-buttons>
            </div>
        </article>
    @endforeach
</x-layout>