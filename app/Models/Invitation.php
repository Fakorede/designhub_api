<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recepient_email', 'sender_id', 'team_id', 'token',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function recipient()
    {
        $this->hasOne(User::class, 'email', 'recipient_email');
    }

    public function sender()
    {
        $this->hasOne(User::class, 'id', 'sender_id');
    }

}
