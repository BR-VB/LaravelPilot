<?php

namespace App\Http\Requests\App;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class ScopeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return [
            'title' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'is_featured' => 'boolean',
            'column' => 'required|integer|int:1,2',
            'sortorder' => 'required|integer|gt:0',
            'bgcolor' => 'nullable|string|regex:/^#([A-Fa-f0-9]{6})$/',
        ];
    }
}
