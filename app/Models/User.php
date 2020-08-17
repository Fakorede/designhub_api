<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use Notifiable, SpatialTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'tagline', 'about', 'username', 'formatted_address', 'available_to_hire',
    ];

    /**
     * The attributes that are spatial fields.
     *
     * @var array
     */
    protected $spatialFields = [
        'location',
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

    public function designs()
    {
        return $this->hasMany(Design::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // teams user belongs to
    public function teams()
    {
        return $this->belongsToMany(Team::class)
            ->withTimestamps();
    }

    // teams user created
    public function ownedTeams()
    {
        return $this->teams()
            ->where('owner_id', $this->id);
    }

    // check if user owns team
    public function isOwnerOfTeam($team)
    {
        return (bool) $this->teams()
            ->where('id', $team->id)
            ->where('owner_id', $this->id)
            ->count();
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
