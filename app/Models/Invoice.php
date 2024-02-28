<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model 
{
    use HasFactory;

    protected $fillable = ['patient_id', 'cumulative_clinic_time', 'seven_days_from_date_only', 'billing_code', 
    'clinic_time', 'date_time', 'time_in', 'time_out', 'date_time_as_string', 
    'date_only', 'mrn', 'name', 'billing_doctor_provider', 'status', 'billing_group_number'];

// From Video 27 (~1:40) using the Post belongsTo a User example: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34351482#overview
// MUST SEE Video 30: "A-HA" MOMENT AROUND MIN (10-11): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34400818?start=600#overview       
        
    // public function patientInvoice() {
    public function patient() {
        // belongsTo( 1- name of class it blongs to, 2- column name on NOTES table that is foreign key )
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
