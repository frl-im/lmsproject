<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
   
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'experience',
        'points',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
     public function projectSubmissions(): HasMany
    {
        return $this->hasMany(ProjectSubmission::class);
    }
    
    public function userProgresses(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    /**
     * The badges that belong to the user.
     */
    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class);
    }

    /**
     * The courses that a user is enrolled in.
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'user_progress')->withTimestamps()->distinct();
    }
    
}
