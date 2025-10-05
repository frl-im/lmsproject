<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- Tambahkan ini
use Illuminate\Database\Eloquent\Relations\HasMany;   // <-- Tambahkan ini

class Lesson extends Model
{
    use HasFactory;

    /**
     * Sebuah Lesson dimiliki oleh satu Module.
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Sebuah Lesson (jika tipe kuis) memiliki banyak Question.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}