<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $postId = $this->post ? $this->post->id : null;
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:post,slug,' . $postId,
            'content' => 'required|string',
            'excerpt' => 'required|string|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'published_at' => 'nullable|date',
        ];
    }
}
