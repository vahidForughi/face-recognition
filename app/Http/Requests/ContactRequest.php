<?php

namespace App\Http\Requests;

use App\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class ContactRequest extends FormRequest
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
            'contact.sender_name' => 'required|max:255',
            'contact.sender_email' => 'nullable|max:255|email',
            'contact.sender_mobile' => 'required|max:11|regex:/^(09)[0-9]{9}$/',
            'contact.sender_image' => [
                'nullable',
                'image',
                'mimes:jpg,bmp,png,jpeg,jfif'
//                File::types(['png', 'jpg', 'jpeg', 'jfif']) // 'heic', 'heif'
//                    ->max('500kb')
            ],
            'contact.landing_id' => ['nullable','numeric','exists:landings,id'],
            'contact.subject' => ['nullable','max:12',Rule::in(array_values(Contact::SUBJECTS))]
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
            'contact.sender_name.required' => 'نام خود را وارد نمایید.',
            'contact.sender_name.max' => 'تعداد کاراکتر های نام بیش از حد مجاز است.',
            'contact.sender_email.email' => 'آدرس ایمیل نا معتبر است.',
            'contact.sender_mobile.required' => 'شماره تماس خود را وارد نمایید.',
            'contact.sender_mobile.max' => 'شماره تماس نا معتبر است.',
            'contact.sender_mobile.regex' => 'شماره تماس نا معتبر است.',
            'contact.sender_mobile.regex' => 'شماره تماس نا معتبر است.',
//            'contact.sender_image.file' => 'فایل نا معتبر است.',
//            'contact.sender_image.image' => 'فایل نا معتبر است.',
//            'contact.sender_image.mimes' => 'فایل نا معتبر است.',
//            'contact.sender_image.between' => 'حجم فایل مجاز نیست.',
//            'contact.subject' => 'فایل نا معتبر است.'
        ];
    }
}
