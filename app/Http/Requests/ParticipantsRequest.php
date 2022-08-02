<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParticipantsRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|min:3',
            'phone' => 'required|string|min:11|max:11',
            'active' => 'nullable',
            'password' => [
                'required',
                'min:6',
                'max:12'
            ]
        ];

        if ($this->method('PUT'))
            $rules['password'][0] = 'nullable';

        return $rules;
    }
}
