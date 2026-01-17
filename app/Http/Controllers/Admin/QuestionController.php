<?php

// app/Http/Controllers/Admin/QuestionController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function create(Lesson $lesson)
    {
        return view('admin.questions.create', compact('lesson'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required',
            'question' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_answer' => 'required'
        ]);

        Question::create($request->all());

        return redirect()->back()->with('success', 'Soal berhasil ditambahkan');
    }


    public function index(Lesson $lesson)
    {
        $questions = $lesson->questions;
        return view('admin.questions.index', compact('lesson', 'questions'));
    }

    public function edit(Question $question)
    {
        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_answer' => 'required',
        ]);

        $question->update($request->all());

        return redirect()->back()->with('success', 'Soal berhasil diupdate');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->back()->with('success', 'Soal berhasil dihapus');
    }

}
