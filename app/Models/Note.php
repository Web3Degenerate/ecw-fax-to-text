<?php

namespace App\Models;

use App\Models\Patient; //Do I need to import patient class??

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['pt_mrn', 'fax_file_name', 'fax_details_id', 'note_body', 'clinic_time', 'time_in', 'time_out', 'date_time_as_string', 
                            'date_time', 'date_only', 'fax_image_link', 'get_fax_inbox_log', 'retrieve_fax_attempt_log', 'retrieve_fax_result_log',
                            'fax_status', 'billing_status', 'billing_number', 'patient_name', 'patient_dob', 'patient_account_number'];


    // From Video 27 (~1:40) using the Post belongsTo a User example: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34351482#overview
    public function patient() {
        // belongsTo( 1- name of class it blongs to, 2- column name on NOTES table that is foreign key )
        return $this->belongsTo(Patient::class, 'patient_id');
    }
                            
}
