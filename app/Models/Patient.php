<?php

namespace App\Models;

use App\Models\Note; //Do I need to import Note class?

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'mrn', 'dob', 'referring_provider', 'billing_index_start_date', 'billing_index_end_date', 
                            'billing_index_start_number', 'billing_index_end_number', 'fax_image_link', 'unique_days', 'status',
                            'clinic_time_counter', 'em_date'];


// SEE (Video 30: 9:20) - https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34400818#overview
    // Using the User.php model 'hasMany' posts example:
    public function notes() {
        //A user Has MANY posts:
        // hasMany(target class, column powering this relationship)
        return $this->hasMany(Note::class, 'patient_id');
    }

}
