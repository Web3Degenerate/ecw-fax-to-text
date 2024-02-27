<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Provider;

class Clinic extends Model
{
    use HasFactory;

    protected $fillable = ['clinic_name', 'clinic_type', 'clinic_email', 'clinic_fax'];


    public function providers() {
        //A user Has MANY posts:
        // hasMany(target class, column powering this relationship)
        return $this->hasMany(Provider::class, 'user_id');
    }
}
