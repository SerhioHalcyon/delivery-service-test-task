<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryRequest extends FormRequest
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
            'parcel' => ['required', 'array'],
            'parcel.title' => ['nullable', 'string'],
            'parcel.length' => ['required', 'numeric'],
            'parcel.width' => ['required', 'numeric'],
            'parcel.height' => ['required', 'numeric'],
            'parcel.weight' => ['required', 'numeric'],
            'user' => ['required', 'array'],
            'user.name' => ['required', 'string'],
            'user.phone' => ['required', 'string'],
            'user.email' => ['required', 'email'],
            'user.address' => ['required', 'string'],
        ];
    }
}
