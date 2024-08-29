<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResumeUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => ['sometimes', 'string', 'max:255'],
            'occupation' => ['sometimes', 'string', 'max:255'],
            'about' => ['sometimes', 'string'],
            'phone' => ['sometimes', 'string'],
            'email' => ['sometimes', 'string', 'email', 'max:255'],
            // 'socialLinks' => ['sometimes', 'json'],
            'age' => ['sometimes', 'integer'],
            'citizen' => ['sometimes', 'string'],
            'address' => ['sometimes', 'string'],
            'favorate_quote' => ['sometimes', 'string'],
            'expertise' => ['sometimes', 'string'],
            // 'whatIDo' => ['sometimes', 'json'],
            // 'skills' => ['sometimes', 'json'],
            // 'educations' => ['sometimes', 'json'],
            // 'experiences' => ['sometimes', 'json'],
            // 'projects' => ['sometimes', 'json'],
            // 'whatIDo.*.icon' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            // 'projects.*.image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }
}
