<?php

namespace App\Models;

use App\Models\Patient; //x

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'em_date', 'provider_id', 'provider_name', 'clinic_id'];

    //(Video 27: 1:40) - Set relationship to User: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34351482#overview
    // public function user(){
    public function visit(){
        //this is Post object as a whole
        // look inside '$this' and call method 'belongs to'
                        //(1) Class belongs to, (2) Column powered by. Column powers the lookup or join. 
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
