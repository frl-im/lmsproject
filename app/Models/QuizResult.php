<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    protected $fillable = [
        'user_id',
        'lesson_id',
        'total_questions',
        'correct_answers',
        'score',
        'xp_earned',
        'passed',
    ];

    protected $casts = [
        'passed' => 'boolean',
        'score' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function getScorePercentageAttribute()
    {
        return $this->total_questions > 0 
            ? round(($this->correct_answers / $this->total_questions) * 100)
            : 0;
    }
}
