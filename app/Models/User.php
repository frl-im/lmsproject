<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\TracksDailyMissions;
use App\Models\Payment;

class User extends Authenticatable
{
   
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TracksDailyMissions;

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
        'is_premium',
        'premium_expires_at',
        'subscription_status',
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
            'is_admin' => 'boolean',
            'is_premium' => 'boolean',
            'premium_expires_at' => 'datetime',
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

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function dailyMissions(): HasMany
    {
        return $this->hasMany(DailyMission::class);
    }

    public function quizResults(): HasMany
    {
        return $this->hasMany(QuizResult::class);
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

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->is_admin === true || $this->is_admin === 1;
    }

    /**
     * Check if user is premium.
     */
    public function isPremium(): bool
    {
        return $this->is_premium === true || $this->is_premium === 1;
    }

    /**
     * Upgrade user to premium.
     */
    public function upgradeToPremium(): bool
    {
        return $this->update(['is_premium' => true]);
    }

    /**
     * Add XP to user.
     */
    public function addXP($amount)
    {
        $this->experience = ($this->experience ?? 0) + $amount;
        $this->save();
        
        // Cek kenaikan level, dsb (opsional)
    }

    /**
     * Add points to user.
     */
    public function addPoints($amount = 5): void
    {
        $this->increment('points', $amount);
    }

    /**
     * Add payment to user.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'user_progress', 'user_id', 'lesson_id')
            ->withPivot('is_completed', 'completed_at', 'xp_awarded', 'quiz_score')
            ->withTimestamps();
    }

    /**
     * Get the certificates awarded to this user
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    //  public function lessons()
    //     {
    //         return $this->belongsToMany(Lesson::class, 'user_progress')
    //             ->withPivot('is_completed', 'completed_at', 'xp_awarded')
    //             ->withTimestamps();
    //     }
    // public function lessons()
    // {
    //     return $this->belongsToMany(Lesson::class, 'user_progress', 'user_id', 'lesson_id')
    //         ->withPivot('is_completed', 'xp_awarded', 'completed_at')
    //         ->withTimestamps();
    // }
}
