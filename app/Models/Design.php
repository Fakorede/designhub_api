<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'image', 'title', 'description', 'slug', 'close_to_comment', 'is_live',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
