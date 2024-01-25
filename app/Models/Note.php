<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['patient_mrn', 'fax_file_name', 'fax_details_id', 'note_body', 'clinic_time', 'time_in', 'time_out', 'date_time_as_string', 
                            'date_time', 'date_only', 'fax_image_link', 'get_fax_inbox_log', 'retrieve_fax_attempt_log', 'retrieve_fax_result_log',
                            'fax_status', 'billing_status', 'billing_number', 'patient_name', 'patient_dob', 'patient_account_number'];
}
