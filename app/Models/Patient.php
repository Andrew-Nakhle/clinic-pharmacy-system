<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
   use HasFactory;
   protected $table = 'patients';
   protected $fillable = [
       'user_id',
       'blood_group',
       'weight',
       'tall',
   ];
   public function user()
   {
       return $this->belongsTo(User::class);
   }
}
