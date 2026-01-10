<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * Get the modules for the course.
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }

    /**
     * Get the lessons for the course through modules.
     */
    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Module::class);
    }

    /**
     * Get all user progress for this course.
     */
    public function userProgresses(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    /**
     * Check if a user has completed this course.
     */
    public function isCompletedByUser($userId): bool
    {
        $totalLessons = $this->lessons()->count();
        $completedLessons = UserProgress::where('user_id', $userId)
            ->whereIn('lesson_id', $this->lessons()->pluck('id'))
            ->where('completed_at', '!=', null)
            ->distinct('lesson_id')
            ->count();

        return $totalLessons > 0 && $totalLessons === $completedLessons;
    }

    /**
     * Get progress percentage for a user.
     */
    public function getProgressPercentage($userId): int
    {
        $totalLessons = $this->lessons()->count();
        if ($totalLessons === 0) return 0;

        $completedLessons = UserProgress::where('user_id', $userId)
            ->whereIn('lesson_id', $this->lessons()->pluck('id'))
            ->where('completed_at', '!=', null)
            ->distinct('lesson_id')
            ->count();

        return (int)($completedLessons / $totalLessons * 100);
    }
}
