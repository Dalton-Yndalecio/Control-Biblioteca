<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objetos extends Model
{
    protected $table = 'objetos';
    public $timestamps = false;
    protected $primaryKey = 'id';

protected $fillable = ['Estado', 'Cantidad' /* otros campos permitidos */];

}
