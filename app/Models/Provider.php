<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clinic;
use App\Models\Name;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = ['clinic_id', 'provider_name', 'provider_type', 'provider_email', 'provider_fax'];

    public function clinic(){
        //this is Post object as a whole
        // look inside '$this' and call method 'belongs to'
                        //(1) Class belongs to, (2) Column powered by. Column powers the lookup or join. 
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }


    public function names() {
        //A user Has MANY posts:
        // hasMany(target class, column powering this relationship)
        return $this->hasMany(Name::class, 'user_id');
    }

}
