@props(['post' => null])

<header class="flex items-center justify-between">
  <h1 class="text-lg font-black">{{ $slot }}</h1>

  @if($post)
    <div class="flex items-center gap-6">
      <a href="{{ route('posts.edit', $post->slug) }}" class="hover:text-orange-500 transition-colors">
        <i class="fal fa-pen"></i>
      </a>

      <a class="hover:text-orange-500 transition-colors delete-btn cursor-pointer">
        <i class="fal fa-trash"></i>
      </a>
    </div>

    <div class="fixed hidden inset-0 bg-gray-600/80 overflow-y-auto h-screen w-full delete-modal">
      <div class="p-8 relative top-1/3 mx-auto border w-96 shadow-lg bg-white">
        <button class="absolute top-0 right-0 -translate-x-full close-del-btn cursor-pointer hover:text-orange-500 transition-colors">
            <i class="fal fa-times"></i>
        </button>

        <form action="{{ route('posts.destroy', $post->slug) }}" method="POST" class="mt-3 text-center">
          @csrf
          @method('DELETE')
          <h3 class="text-xl font-bold">Are you sure you want to delete the article?</h3>
          <div class="flex justify-center gap-4 text-lg mt-4">
            <x-submit-btn>Yes</x-submit-btn>
            <x-cancel-btn class="close-del-btn">No</x-cancel-btn>
          </div>
        </form>
      </div>
    </div>
  @endif
</header>