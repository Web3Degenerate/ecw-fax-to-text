<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    //updated 'name' to 'username' in https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207604#content
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


// Added (~9:38) - https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34400818#overview
    public function posts() {
        //A user Has MANY posts:
        // hasMany(target class, column powering this relationship)
        return $this->hasMany(Post::class, 'user_id');
    }

// Added (1:29) relationship b/t a User and a Follow: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503228#notes
    public function followers() {
        //a user has many follows (think of rows in follows table).
        return $this->hasMany(Follows::class, 'followeduser');
    }

}
