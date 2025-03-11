<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class ProjectRequest extends FormRequest
{
    private string $classPrefix = "api/";

    //react to validation errors with json response
    public function expectsJson(): bool
    {
        return true;
    }

    //determine if the user is authorized to make this request.
    public function authorize(): bool
    {
        Log::info($this->classPrefix . class_basename(self::class), [__FUNCTION__]);

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        Log::info($this->classPrefix . class_basename(self::class), [__FUNCTION__]);

        if ($this->isMethod('get') && $this->route()->named('api.projects.search')) {
            return [
                'title' => 'required|string|min:3|max:30',
                'description' => 'nullable|string|min:5|max:30',
            ];
        } else {
            return [
                'title' => 'required|string|max:65',
                'description' => 'nullable|string',
                'is_featured' => 'boolean',
            ];
        }
    }
}
