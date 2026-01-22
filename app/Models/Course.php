<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'price', 
        'thumbnail', 'is_published', 'level'
    ];

    // Relasi ke Module
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }

    // Relasi ke Lesson (PENTING: Pakai HasManyThrough)
    public function lessons(): HasManyThrough
    {
        return $this->hasManyThrough(Lesson::class, Module::class);
    }

    // Relasi ke UserProgress
    public function userProgress(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    /**
     * Cek apakah course sudah selesai oleh user tertentu
     */
    public function isCompletedByUser($user)
    {
        // Course dianggap selesai jika semua lesson pada course ini sudah completed oleh user
        $lessonIds = $this->lessons()->pluck('lessons.id');
        if ($lessonIds->isEmpty()) return false;
        $completedCount = $user->lessons()->whereIn('lesson_id', $lessonIds)->wherePivot('is_completed', true)->count();
        return $completedCount === $lessonIds->count();
    }
}