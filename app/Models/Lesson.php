<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'module_id',
        'title',
        'content',
        'type',
        'xp_reward',
    ];

    /**
     * Get the module that owns the lesson.
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Get all user progress for this lesson.
     */
    public function userProgresses(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }


     public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    
    /**
     * Check if a user has completed this lesson.
     */
    public function isCompletedByUser($userId): bool
    {
        return UserProgress::where('user_id', $userId)
            ->where('lesson_id', $this->id)
            ->where('completed_at', '!=', null)
            ->exists();
    }
}
