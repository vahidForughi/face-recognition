<?php

namespace App\Models;

use App\Helpers\General\Utils;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamQuestion extends Model
{
    use HasFactory, AsSource, Filterable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exam_id',
        'title',
        'media',
        'description',
        'type',
        'options',
        'scores',
        'rules'
    ];

//    /**
//     * The attributes that are cast.
//     *
//     * @var array
//     */
//    protected $casts = [
//        'options' => 'object'
//    ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'title',
        'type',
        'created_at',
        'updated_at'
    ];


    const TYPES = [
        1 => "text",
        2 => "textarea",
        3 => "number",
        4 => "email",
        5 => "radio",
        6 => "checkbox",
        7 => "url",
        8 => "password",
        9 => "color",
        10 => "date",
        11 => "datetime-local",
        12 => "time",
        13 => "month",
        14 => "week",
    ];


    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function globalOptions()
    {
        return $this->belongsTo(ExamOption::class, 'exam_option_id');
    }


    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? self::typeValue($value) : null,
            set: fn ($value) => $value ? self::typeKey($value) : null,
        );
    }

    protected function options(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? self::optionsToArray($value) : ($this->globalOptions ? $this->globalOptions->options : null) ,
            set: fn ($value) => $value ? self::optionsToString($value) : null
        );
    }

    protected function scores(): Attribute
    {
        return Attribute::make(
//            get: fn ($value) => $value ? json_decode($value, true) : ($this->globalOptions ? $this->globalOptions->scores : null),
//            set: fn ($value) => $value ? json_encode($value , JSON_UNESCAPED_UNICODE) : null,
            get: fn ($value) => $value ? self::scoresToArray($value) : ($this->globalOptions ? $this->globalOptions->scores : null),
            set: fn ($value) => $value ? self::scoresToString($value) : null,
        );
    }

    protected function rules(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? explode('|', $value) : null,
        );
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

    static public function optionsToString($options) : string {
        return $options ? (is_array($options) ? implode('|', $options): $options) : "";
    }

    static public function optionsToArray($options) : array {
        return $options ? (is_string($options) ? explode('|', $options): $options) : [];
    }

    public function typeValue($typeKey) {
        return $typeKey ? static::TYPES[$typeKey] : "";
    }


    static public function typeKey($value) {
        return array_search($value, static::TYPES);
    }

    public function calScore($value) {
        $amount = 0;
        Utils::cal($this->scores, $value, function ($score, $condition) use (&$amount) {
            $amount += $score;
        });
        return $amount;
    }

//    public function calScore($value) {
//        $operators = ['==', '!=', '>=', '<=', '>', '<'];
//
//        $amount = 0;
//        if ($this->scores && is_array($this->scores)) {
//            $result = false;
//            foreach ($this->scores as $key => $score) {
//                foreach ($operators as $operator) {
//                    $cast = is_numeric($value) ? 'intval' : '';
////                    dd($this->scores, $key, $score, "\$result = ( Str::contains(\$key, \$operator) && " ."\$value ". $operator." ".$cast."(Str::after(\$key, \$operator)) ); " );
////                    eval("\$result = ( Str::contains(\$key, \$operator) && Str::after(\$key, \$operator) ". $operator ." \$value );");
//                    eval("\$result = ( Str::contains(\$key, \$operator) && " .$cast."(\$value) ". $operator." ".$cast."(Str::after(\$key, \$operator)) ); " );
//                    if ($result) {
//                        break;
//                    }
//                }
//
//                if ($result === true || ($result === false && $key == $value))
//                    $amount += $score;
//            }
////            dd($this->scores, $key, $score, $value, $result, $amount);
//        }
//
//        return $amount;
//    }

    public function store($input) {
        if ($input->input('exam_id')) {
            $this->exam_id = $input->input('exam_id');
        }
        $this->title = $input->input('question.title');
        $this->type = $input->input('question.type');
        $this->options = $input->input('question.options');
        $this->scores = $input->input('question.scores');
//        $this->description = $input->input('question.description');
//        $this->rules = $input->input('question.rules');
//        $this->exam_option_id = $input->input('question.exam_option_id');
//
//        if ($input->hasFile('question.media')) {
//
//            $filename = time().'-'.uniqid().'.jpg';
//            $img = Image::make($input->file('question.media')->path());
//            Storage::disk('local')->put('uploads/questions/media/'.$filename, $img->encode('jpg', 100));
//
//            $this->media = $filename;
//        }
        return $this->save();
    }

}
