<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class FaceDetectRequest extends FormRequest
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
            'file' => [
                'required',
                File::types(['png', 'jpg', 'jpeg', 'jfif']) // 'heic', 'heif'
                    ->max('500kb')
            ]
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
            'file.required' => 'یه عکس انتخاب کن',
            'file.file' => 'یه عکس انتخاب کن',
            'file.image' => 'فایل نا معتبر است.',
            'file.mimes' => 'فایل نا معتبر است.',
            'file.between' => 'حجم فایل مجاز نیست.',
        ];
    }



}
