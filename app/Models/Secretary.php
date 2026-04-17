<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Secretary extends Model
{
    protected $table= 'secretaries';
    protected $fillable= ['user_id','app'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
