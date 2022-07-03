<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    function detail(){
        return $this->hasMany(DetailTransaction::class , 'id');
    }

    function detailUnique(){
        return $this->hasMany(DetailTransaction::class , 'unique_id');
    }
}
