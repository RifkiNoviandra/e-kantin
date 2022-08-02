<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['password'];
    public $timestamps = false;

    function detail(){
        return $this->hasMany(DetailTransaction::class , 'store_id' , 'id');
    }
}
