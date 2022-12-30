<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseApiRequest as FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'author' => 'required|string',
            'isbn' => 'required|string',
            'publisher' => 'required|string',
            'published_at' => 'required|date',
            'description' => 'string',
            'image' => 'required|image|mimes:jpg,png,jpeg,svg|max:4096',
        ];
    }
}
