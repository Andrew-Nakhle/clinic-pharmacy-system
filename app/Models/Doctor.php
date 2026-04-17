<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table='doctors';
    protected $fillable=['user_id','specialization','qualification','experience_years','bio'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
