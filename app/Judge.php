<?php

namespace App;

use App\Notifications\JudgeResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Judge extends Authenticatable
{
    use Notifiable;

    protected $guard = 'judge';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new JudgeResetPasswordNotification($token));
    }

    public function industryCategories()
    {
        return $this->belongsToMany('App\IndustryCategory')->withTimestamps();
    }

    public function blockedEntries()
    {
        return $this->hasMany('App\BlockedEntry');
    }

    public function brands()
    {
        return $this->belongsToMany('App\Brand')->as('score')
            ->withPivot('intent', 'content', 'process', 'health', 'performance', 'total',
                'good', 'bad', 'improvement', 'round')->withTimestamps();
    }

    public function panels()
    {
        return $this->belongsToMany('App\Panel');
    }
}
