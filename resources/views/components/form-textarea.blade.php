<x-form-input-layout :name="$name" :label="$label ?? $name" :id="$id ?? $name" :value="$value ?? ''">
    <textarea
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        {{ $attributes->class([
            'col-span-10 border border-gray-300 focus:outline-0 p-2 placeholder:capitalize resize-none'
        ]) }}
        placeholder="Start writing..."
    >{{ old($name, $post?->$name ?? '') }}</textarea>
</x-form-input-layout>