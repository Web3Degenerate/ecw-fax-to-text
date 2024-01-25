<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'mrn', 'dob', 'referring_provider', 'billing_index_start_date', 'billing_index_end_date', 
                            'billing_index_start_number', 'billing_index_end_number', 'fax_image_link', 'unique_days', 'status'];
}
