<?php

namespace App\Models;

use App\Orchid\Presenters\ContactPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;

class Landing extends Model
{
    use HasFactory, AsSource, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'name'
    ];


    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

}
