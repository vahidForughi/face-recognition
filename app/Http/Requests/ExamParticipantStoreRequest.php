<?php

namespace App\Http\Requests;

use App\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class ExamParticipantStoreRequest extends FormRequest
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
            'fullname' => 'required|max:255',
            'mobile' => 'required|max:11|regex:/^(09)[0-9]{9}$/',
            'responses' => 'nullable',
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
            'fullname.required' => 'نام خود را وارد نمایید.',
            'fullname.max' => 'تعداد کاراکتر های نام بیش از حد مجاز است.',
            'mobile.required' => 'شماره موبایل خود را وارد نمایید.',
            'mobile.max' => 'شماره موبایل نا معتبر است.',
            'mobile.regex' => 'شماره موبایل نا معتبر است.',
        ];
    }
}
