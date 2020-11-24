<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

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

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function getUrlAttribute()
    {
        // return route('questions.show', $this->slug);

        return '#';
    }

    public function getAvatarAttribute()
    {
        // using gravatar
        // $email = $this->email;
        // $size = 40;

        // return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;

        // using avatar ui
        $background = '0D8ABC';
        $color = 'ffffff';
        $name = $this->name;
        $size = 40;
        $rounded = true;
        return "https://ui-avatars.com/api/?background=$background&name=$name&size=$size&color=$color&rounded=$rounded&font-size=0.35";
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

}
