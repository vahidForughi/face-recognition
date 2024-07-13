<?php

namespace App\Http\Requests;

use App\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class ExamStoreRequest extends FormRequest
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
            'exam.title' => 'required|max:255',
            'exam.description' => 'nullable|max:5000',
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
            'exam.title.required' => 'عنوان را وارد نمایید.',
            'exam.title.max' => 'تعداد کاراکتر های عنوان بیش از حد مجاز است.',
            'exam.description.required' => 'شرح را وارد نمایید.',
            'exam.description.max' => 'تعداد کاراکتر های شرح بیش از حد مجاز است.',
        ];
    }
}
