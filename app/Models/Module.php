<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- Tambahkan ini
use Illuminate\Database\Eloquent\Relations\HasMany;   // <-- Tambahkan ini

class Module extends Model
{
    use HasFactory;

    /**
     * Sebuah Module dimiliki oleh satu Course.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Sebuah Module memiliki banyak Lesson.
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }
}