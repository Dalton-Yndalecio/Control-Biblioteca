<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moviliarios extends Model
{
    //use HasFactory;
    protected $table = 'moviliarios';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function objeto(){
        return $this->belongsTo(Objetos::class, 'idobjeto', 'id');
    }
}
