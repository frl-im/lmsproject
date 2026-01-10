<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'title',
    ];

    /**
     * Get the course that owns the module.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the lessons for the module.
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     * Check if a user has completed this module.
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
