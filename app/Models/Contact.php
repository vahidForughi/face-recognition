<?php

namespace App\Models;

use App\Orchid\Presenters\ContactPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;

class Contact extends Model
{
    use HasFactory, AsSource, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_name',
        'sender_email',
        'sender_mobile',
        'sender_image',
        'landing_id',
        'subject'
    ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'name',
        'mobile',
        'email',
        'created_at',
        'updated_at'
    ];


    const SUBJECTS = [
        1 => "Lead"
    ];


    public function landing()
    {
        return $this->belongsTo(Landing::class);
    }


    public function presenter(): ContactPresenter
    {
        return new ContactPresenter($this);
    }


    public function subjectValue() {
        return isset($this->subject) && $this->subject ? static::SUBJECTS[$this->subject] : "";
    }


    static public function subjectKey($value) {
        return array_search($value, static::SUBJECTS);
    }


    public function store($input) {
        $this->sender_name = $input->input('contact.sender_name');
        $this->sender_email = $input->input('contact.sender_email');
        $this->sender_mobile = $input->input('contact.sender_mobile');
        $this->landing_id = $input->input('contact.landing_id');
        $this->subject = Contact::subjectKey($input->input('contact.subject'));

        if ($input->hasFile('contact.sender_image')) {

            $filename = time().'-'.uniqid().'.jpg';
            $img = Image::make($input->file('contact.sender_image')->path());
            Storage::disk('local')->put('uploads/contact/'.$filename, $img->encode('jpg', 100));

            $this->sender_image = $filename;
        }

        return $this->save();
    }

}
