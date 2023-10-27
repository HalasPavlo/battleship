<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SetupGameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool)Auth::user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'ships' => 'required|array',
            'ships.*.type' => 'required|string|in:carrier,battleship,submarine',
            'ships.*.position' => 'required|array|min:1',
            'ships.*.position.*' => 'required|array',
            'ships.*.position.*.row' => 'required|integer|between:1,10',
            'ships.*.position.*.column' => 'required|integer|between:1,10',
        ];
    }
}
