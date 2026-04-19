<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    protected $table='doctors';
    protected $fillable=['user_id','specialization','qualification','experience_years','bio'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function section(){
        return $this->belongsTo(Section::class);
    }
}
