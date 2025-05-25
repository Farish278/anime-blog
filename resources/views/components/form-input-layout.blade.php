<div class="grid sm:grid-cols-12">
    <label for="{{ $id ?? $name }}" class="font-semibold col-span-2 capitalize">{{ $label ?? $name }}</label>
    {{ $slot }}
</div>