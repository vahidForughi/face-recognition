<?php

namespace App\Models;

use App\Helpers\General\Utils;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamOption extends Model
{
    use HasFactory, AsSource, Filterable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'options',
        'scores',
        'media',
        'description'
    ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'created_at',
        'updated_at'
    ];


    public function exams()
    {
        return $this->belongsToMany(Exam::class);
    }


    protected function options(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? self::optionsToArray($value) : null,
            set: fn ($value) => $value ? self::optionsToString($value) : null
        );
    }

    protected function scores(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? self::scoresToArray($value) : null,
            set: fn ($value) => $value ? self::scoresToString($value) : null,
        );
    }


    static public function optionsToString($options) : string {
        return $options ? (is_array($options) ? implode('|', $options): $options) : "";
    }

    static public function optionsToArray($options) : array {
        return $options ? (is_string($options) ? explode('|', $options): $options) : [];
    }

    static public function scoresToString($scores) : string {
        if ($scores) {
            if (is_array($scores))
                return Utils::keyValueToString($scores, '|');
            else
                return $scores;
        }
        else
            return '';
    }

    static public function scoresToArray($scores) : array {
        if ($scores){
            if (is_string($scores))
                return Utils::stringToKeyValue($scores, '|');
            else
                return $scores;
        }
        else
            return [];
    }
//
//    public function getScoresAttributes($scores)
//    {
//        return explode('|', $scores);
//    }
//
//    public function setScoresAttributes()
//    {
//        return implode('|', $scores);
//    }

}
