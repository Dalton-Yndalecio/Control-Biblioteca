<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libros extends Model
{
    //use HasFactory;
    protected $table = 'libros';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function objeto(){
        return $this->belongsTo(Objetos::class, 'idobjeto', 'id');
    }
}
