<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
