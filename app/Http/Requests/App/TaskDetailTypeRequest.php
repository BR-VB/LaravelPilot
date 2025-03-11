<?php

namespace App\Http\Requests\App;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class TaskDetailTypeRequest extends FormRequest
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

        $rules = [
            'label' => 'required|string|max:255',
        ];

        if ($this->isMethod('post')) {
            $rules['title'] = 'required|string|max:255|unique:task_detail_types,title';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['title'] = 'required|string|max:255|unique:task_detail_types,title,'.$this->route('task_detail_type');
        }

        return $rules;
    }
}
