<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProgress extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_progress';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'course_id',
        'lesson_id',
        'completed_at',
        'is_completed',
        'quiz_score',
        'quiz_attempts',
        'xp_awarded',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Scope to get completed lessons only.
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('completed_at');
    }

    /**
     * Scope to get for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Check if XP has already been awarded for this progress record.
     */
    public function hasXPBeenAwarded(): bool
    {
        return $this->xp_awarded === true || $this->xp_awarded === 1;
    }

    /**
     * Mark XP as awarded.
     */
    public function markXPAsAwarded(): void
    {
        $this->update(['xp_awarded' => true]);
    }

    /**
     * Check if lesson has been completed before.
     */
    public static function hasUserCompletedLesson($userId, $lessonId): bool
    {
        return self::where('user_id', $userId)
            ->where('lesson_id', $lessonId)
            ->where('is_completed', true)
            ->exists();
    }
}
