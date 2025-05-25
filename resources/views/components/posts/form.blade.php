<x-form-group :post="isset($post) ? $post : null" name="title" />
<x-form-group :post="isset($post) ? $post : null" name="slug"/>
<x-form-textarea :post="isset($post) ? $post : null" name="content" class="h-50"/>
<x-form-textarea :post="isset($post) ? $post : null" name="excerpt" class="h-30"/>
<x-form-group :post="isset($post) ? $post : null" name="image" accept=".jpeg,.png,.jpg,.gif,.svg" type="file" class="bg-orange-500 text-white" />
<x-form-group :post="isset($post) ? $post : null" type="date" label="Published Date" placeholder="Published Date" name="published_at" class="date-picker"/>
<div class="grid sm:grid-cols-12 items-center gap-2">
    <div class="col-span-2"></div>
    <x-submit-btn>Save</x-submit-btn>
    <x-cancel-btn onclick="location.href='{{ route('posts.index') }}'">Cancel</x-cancel-btn>
</div>