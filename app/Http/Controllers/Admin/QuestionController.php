<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display all questions for a lesson
     */
    public function index(Lesson $lesson)
    {
        // Pastikan lesson tipe kuis
        if ($lesson->type !== 'kuis') {
            return redirect()->route('admin.lessons.show', $lesson)
                ->with('error', 'Lesson ini bukan tipe kuis');
        }

        $questions = $lesson->questions()->orderBy('created_at', 'desc')->get();
        return view('admin.questions.index', compact('lesson', 'questions'));
    }

    /**
     * Show form untuk create question
     */
    public function create(Lesson $lesson)
    {
        // Pastikan lesson tipe kuis
        if ($lesson->type !== 'kuis') {
            return redirect()->route('admin.lessons.show', $lesson)
                ->with('error', 'Lesson ini bukan tipe kuis');
        }

        return view('admin.questions.create', compact('lesson'));
    }

    /**
     * Store question ke database
     */
    public function store(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'question' => 'required|string|min:5',
            'option_a' => 'required|string|min:1',
            'option_b' => 'required|string|min:1',
            'option_c' => 'required|string|min:1',
            'option_d' => 'required|string|min:1',
            'correct_answer' => 'required|in:A,B,C,D',
            'point' => 'nullable|integer|min:1',
        ]);

        $validated['lesson_id'] = $lesson->id;
        $validated['point'] = $validated['point'] ?? 10;

        Question::create($validated);

        return redirect()->route('admin.quiz.index', $lesson)
            ->with('success', 'Soal berhasil ditambahkan!');
    }

    /**
     * Show form untuk edit question
     */
    public function edit(Question $question)
    {
        $lesson = $question->lesson;
        return view('admin.questions.edit', compact('question', 'lesson'));
    }

    /**
     * Update question
     */
    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question' => 'required|string|min:5',
            'option_a' => 'required|string|min:1',
            'option_b' => 'required|string|min:1',
            'option_c' => 'required|string|min:1',
            'option_d' => 'required|string|min:1',
            'correct_answer' => 'required|in:A,B,C,D',
            'point' => 'nullable|integer|min:1',
        ]);

        $validated['point'] = $validated['point'] ?? 10;
        $question->update($validated);

        return redirect()->route('admin.quiz.index', $question->lesson)
            ->with('success', 'Soal berhasil diupdate!');
    }

    /**
     * Delete question
     */
    public function destroy(Question $question)
    {
        $lesson = $question->lesson;
        $question->delete();

        return redirect()->route('admin.quiz.index', $lesson)
            ->with('success', 'Soal berhasil dihapus!');
    }
}
