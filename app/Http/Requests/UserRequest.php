<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $id = $this->route('user');
        return [
            //
            'name' => ["required"],
            'email' => ["required", "email", Rule::unique("users", "email")->ignore($id)],
            'roles' => ["required", "exists:roles,id"],
            "signature" => ["mimes:png", "max:2000", "file"]
            // 'password' => ["required"],
        ];
    }

    public function messages()
    {
        return [
            'signature.required' => "Signature is required",
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email already exists',
            'roles.required' => 'Role is required',
            'roles.exists' => 'Role does not exist'
        ];
    }
}
