<?php

// Added around (17:40): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34351476#overview


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id'];

    //(Video 27: 1:40) - Set relationship to User: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34351482#overview
    // public function user(){
    public function pizza(){
        //this is Post object as a whole
        // look inside '$this' and call method 'belongs to'
                        //(1) Class belongs to, (2) Column powered by. Column powers the lookup or join. 
        return $this->belongsTo(User::class, 'user_id');
    }
}
