<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Provider;

class Name extends Model
{
    use HasFactory;

    protected $fillable = ['provider_id', 'provider_name', 'clinic_id'];

    public function provider(){
        //this is Post object as a whole
        // look inside '$this' and call method 'belongs to'
                        //(1) Class belongs to, (2) Column powered by. Column powers the lookup or join. 
        return $this->belongsTo(Provider::class, 'clinic_id');
    }
}
