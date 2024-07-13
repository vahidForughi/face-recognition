<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamParticipantStoreRequest;
use App\Http\Requests\ExamStoreRequest;
use App\Models\Exam;
use App\Models\ExamParticipant;

class ExamsController extends Controller
{

    public function show(Exam $exam)
    {

        $exam->load('questions:id,exam_id,title,description,media,type,exam_option_id,options,rules,deleted_at');

        return response()->json([
            'success' => 'true',
            'status' => 200,
            'data' => $exam
        ]);
    }

    public function store(ExamStoreRequest $request)
    {
        $exam = new Exam();
        $exam->store($request);

        return response()->json([
            'success' => 'true',
            'status' => 200
        ]);
    }


    public function storeParticipant(ExamParticipantStoreRequest $request, Exam $exam)
    {
//        dd($request);

        $participant = $exam->storeParticipant($request);
        $result = $exam->calResult($participant->score);

        return response()->json([
            'status' => 200,
            'success' => 'true',
            'data' => [
                'score' => $participant->score,
                'content' => $result
            ]
        ]);
    }

}
