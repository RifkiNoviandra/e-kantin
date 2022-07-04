<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    function menu(){
        return $this->belongsTo(Menu::class , 'menu_id' , 'id');
    }

}
