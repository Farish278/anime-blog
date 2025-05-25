<a href="{{ $href }}" {{ $attributes->merge(['class'=>"bg-orange-500 hover:bg-orange-400 transition-colors text-white px-4 py-2 capitalize self-start flex justify-center items-center gap-2"]) }}>
    {{ $slot }}
</a>