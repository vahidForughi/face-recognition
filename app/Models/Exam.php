<?php

namespace App\Models;

use App\Helpers\General\Utils;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use HasFactory, AsSource, Filterable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'description',
        'notice',
        'results'
    ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'title',
        'created_at',
        'updated_at'
    ];


    public function questions()
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function participants()
    {
        return $this->hasMany(ExamParticipant::class);
    }

    protected function results(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? self::resultsToArray($value) : null,
            set: fn ($value) => $value ? self::resultsToString($value) : null,
        );
    }


    static public function resultsToString($results) : string {
        if ($results) {
            if (is_array($results))
                return Utils::keyValueToString($results, '|');
            else
                return $results;
        }
        else
            return '';
    }

    static public function resultsToArray($results) : array {
        if ($results){
            if (is_string($results))
                return Utils::stringToKeyValue($results, '|');
            else
                return $results;
        }
        else
            return [];
    }

    public function calResult($value) {
        $content = '';
        Utils::cal($this->results, $value, function ($result, $condition) use (&$content) {
            $content = $result;
        });
        return $content;
    }


    public function store($input) {
        $this->title = $input->input('exam.title');
        $this->slug = $input->input('exam.slug');
        $this->description = $input->input('exam.description');
        $this->notice = $input->input('exam.notice');
        $this->results = $input->input('exam.results');
        $this->thumbnail = $input->input('exam.thumbnail');
        return $this->save();
    }

    public function storeParticipant($input) {
        $participant = new ExamParticipant();
        $input->merge(['exam_id' => $this->id]);
        return $participant->store($input, $this);
    }

}
