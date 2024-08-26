<?php

namespace App\Http\Requests;


use App\Traits\CustomTrait ;
use Illuminate\Foundation\Http\FormRequest;

class CreateUser extends FormRequest
{

    use CustomTrait;
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
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'phone_number' => [
                'required',
                'string',
                'regex:/^\+?[1-9]\d{1,14}$/'
            ],
            'date_of_birth' => [
                'required',
                'date',
                'date_format:Y-m-d',
                function ($attribute, $value, $fail) {
                    if (!$this->isOlderThan($value, 18)) {
                        $fail('The age must be at least 18 years old.');
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'name is required',
            'name.string'=>'name must be string',
            'name.max'=>'max charachter 255',
            'email.required'=>'email is required',
            'email.email'=>'must be a email format',
            'email.unique'=>'email is already exists',
            'phone_number.required'=>'phone number is required',
            'phone_number.numeric'=>'number only',
            'phone_number.digits'=>'phone number must be 10 digits ',
            'date_of_birth.required' => 'The date of birth is required.',
            'date_of_birth.date' => 'The date of birth must be a valid date.',
        ];
    }


}
