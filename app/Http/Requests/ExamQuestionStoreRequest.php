<?php

namespace App\Http\Requests;

use App\Models\ExamQuestion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class ExamQuestionStoreRequest extends FormRequest
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
            'question.title' => 'required',
            'question.type' => ['required',Rule::in(array_values(ExamQuestion::TYPES))],
            'question.options' => 'nullable',
            'question.scores' => 'nullable',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'question.title.required' => 'عنوان را وارد نمایید.',
            'question.title.max' => 'تعداد کاراکتر های عنوان بیش از حد مجاز است.',
        ];
    }
}
