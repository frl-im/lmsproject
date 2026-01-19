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
}