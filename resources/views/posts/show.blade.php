<x-layout>
    <article class="flex flex-col items-center justify-center gap-4 px-6 py-2">
        <div class="w-full">
            <x-header :post="$post">{{ $post->title }}</x-header>
            <p class="text-sm">{{ $post->published_at->format('d F Y') }}</p>
        </div> <!-- header wrap -->
        <img src="{{ asset($post->image) }}" class="w-full aspect-[2/0.8] object-cover">
        <div class="w-2/3">
            {!! nl2br(e($post->content)) !!}
        </div>
    </article>
</x-layout>
