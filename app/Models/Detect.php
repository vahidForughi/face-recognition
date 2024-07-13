<?php

namespace App\Models;

use App\Orchid\Presenters\ContactPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;

class Detect extends Model
{
    use HasFactory, AsSource, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'token',
        'payload',
        'status',
    ];

    const STATUSES = [
        0 => "Waiting",
        1 => "Success",
        2 => "Failed",
    ];


    public function statusValue() {
        return isset($this->status) ? static::STATUSES[$this->status] : "";
    }


    static public function statusKey($value) {
        return array_search($value, static::STATUSES);
    }


    public function store($input) {
        $this->token =  time().uniqid().Str::random(5);

        if ($input->hasFile('file')) {
            $filename = $this->token.'.jpg';
            $img = Image::make($input->file('file')->path());
            Storage::disk('local')->put('uploads/detects/'.$filename, $img->encode('jpg', 100));
            $this->image = $filename;
        }

        $this->status = $this->statusKey("Waiting");

        return $this->save();
    }


}
