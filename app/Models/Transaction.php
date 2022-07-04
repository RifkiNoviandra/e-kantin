<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    function detail(){
        return $this->hasMany(DetailTransaction::class , 'transaction_id' , 'id');

    }
}
