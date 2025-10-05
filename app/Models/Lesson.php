<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'module_id',
        'title',
        'content',
        'type',
    ];

    /**
     * Sebuah Lesson dimiliki oleh satu Module.
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}