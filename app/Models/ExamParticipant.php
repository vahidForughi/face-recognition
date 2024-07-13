<?php

namespace App\Models;

use App\Orchid\Presenters\ParticipantPresenter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;

class ExamParticipant extends Model
{
    use HasFactory, AsSource, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exam_id',
        'user_id',
        'fullname',
        'mobile',
        'gender',
        'city',
        'responses',
        'score'
    ];

    /**
     * The attributes that are cast.
     *
     * @var array
     */
    protected $casts = [
        'responses' => 'object'
    ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'user_id',
        'fullname',
        'gender',
        'mobile',
        'city',
        'score',
        'created_at',
        'updated_at'
    ];


    const GENDERS = [
        0 => "Male",
        1 => "Female",
    ];


    public function genderValue() {
        return isset($this->gender) ? static::GENDERS[$this->gender] : "";
    }


    static public function genderKey($value) {
        return array_search($value, static::GENDERS);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }


    public function presenter(): ParticipantPresenter
    {
        return new ParticipantPresenter($this);
    }

    protected function responses(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? json_decode($value, true) : null,
            set: fn ($value) => $value ? json_encode($value, JSON_UNESCAPED_UNICODE) : null,
//            set: function($value) {
//                return array_map(function ($v) {
//                    return json_encode($v, JSON_UNESCAPED_UNICODE);
//                }, $value);
//            }
        );
    }


    public function store($input, $exam) {
        $this->exam_id = $input->input('exam_id');
        $this->fullname = $input->input('fullname');
        $this->mobile = $input->input('mobile');
        $this->gender = ExamParticipant::genderKey($input->input('gender'));
        $this->city = $input->input('city');
        $this->responses = $input->input('responses');

        $score = 0;
        foreach ($exam->questions as $question) {
            $response_key = array_search($question->id, array_column($this->responses, 'q_id'));
            $response = !is_bool($response_key) ? $this->responses[$response_key]['value'] : null;
            if (is_array($response)) {
                foreach ($response as $value) {
                    $score += $question->calScore($value);
                }
            }else {
                $score += $question->calScore($response);
            }
        }
        $this->score = $score;

        $this->save();
        return $this;
    }

}
