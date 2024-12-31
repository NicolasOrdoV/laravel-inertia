<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class Put extends FormRequest
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
        return [
            "title" => "required|min:5|max:255",
            "slug" => "required|min:5|max:255|unique:posts,id," . $this->route('post')->id,
            "date" => "required",
            "description" => "required|min:5",
            "posted" => "required",
            "category_id" => "required",
            "type" => "required",
        ];
    }

    public function prepareForValidation()
    {
        if (str($this->slug)->trim() == '') {
            $this->merge([
                "slug" => str($this->title)->slug(),
            ]);
        }
    }
}
