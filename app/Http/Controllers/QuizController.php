<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\QuizResult;

class QuizController extends Controller
{
    public function submit(Request $request, $questionId)
    {
        $question = Question::findOrFail($questionId);
        $isCorrect = $request->answer == $question->correct_answer;

        QuizResult::create([
            'user_id' => auth()->id(),
            'question_id' => $question->id,
            'answer' => $request->answer,
            'is_correct' => $isCorrect,
            'point' => $isCorrect ? 10 : 0,
        ]);

        return back()->with('success', 'Jawaban disimpan');
    }
}
