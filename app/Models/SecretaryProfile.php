<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecretaryProfile extends Model
{
    protected $table= 'secretaries';
    protected $fillable= ['user_id','app'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function section(){
return $this->belongsTo(Section::class);    }
}
