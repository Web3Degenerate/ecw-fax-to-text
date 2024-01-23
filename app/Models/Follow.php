<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Follow extends Model
{
    use HasFactory;

    // (Video 43. 7:40) => Set up reciprocal relationship to show username and avatar of a User's followers: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503228#notes
    public function userDoingTheFollowing(){
        //give us the user object in question from user_id stored in Follow table
        return $this->belongsTo(User::class, 'user_id', 'id'); 
    }

    public function userBeingFollowed(){
        return $this->belongsTo(User::class, 'followeduser', 'id'); 
    }
}
