<x-form-input-layout :name="$name" :label="$label ?? $name" :id="$id ?? $name" :value="$value ?? ''">
    <input
        type="{{ $type ?? 'text' }}"
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        {{ $attributes->class([
            'col-span-10 border border-gray-300 focus:outline-0 p-2 placeholder:capitalize'
        ]) }}
        placeholder="{{ $placeholder ?? $name }}"
        value="{{ old($name, $post?->$name ?? '') }}"
    >
</x-form-input-layout>