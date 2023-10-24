<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name' => ['required','sometimes', 'string', 'max:255'],
            'username' => ['required','sometimes', 'string', 'max:255', 'unique:users,username,' . $this->user()->id],
            'email' => ['required','sometimes', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user()->id],
            'country_id' => ['required', 'sometimes', 'exists:countries,id'],
            'city_id' => ['required','sometimes', 'exists:cities,id'],
            'media' => ['nullable','sometimes', 'image', 'max:1024'],
            'bio' => ['required','sometimes', 'string', 'max:255'],
            'number' => ['required','sometimes', 'string', 'max:255'],
            'favorite_color' => ['required','sometimes', 'string', 'max:255'],
            'favorite_food' => ['required','sometimes', 'string', 'max:255'],
            'favorite_country' => ['required','sometimes', 'string', 'max:255'],
            'want_to_visit' => ['required','sometimes', 'string', 'max:255'],
        ];
    }
}
