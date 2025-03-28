<?php

namespace App\Http\Requests\App;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return true;
    }

    //correct 2025-08-02T12:00 to 2025-08-02T12:00:00
    public function prepareForValidation()
    {
        if ($this->occurred_at && substr_count($this->occurred_at, ':') === 1) {
            $this->merge([
                'occurred_at' => $this->occurred_at . ':00'
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        $rules = [
            'scope_id' => 'required|exists:scopes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_featured' => 'boolean',
            'icon' => 'required|string',
            'prefix' => 'nullable|string',
            'occurred_at' => 'nullable|date_format:Y-m-d\TH:i:s',
        ];

        return $rules;
    }
}
