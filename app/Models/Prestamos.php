<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamos extends Model
{
    //use HasFactory;
    protected $table = 'prestamos';
    public $timestamps = false;
    protected $primaryKey = 'id';

protected $fillable = ['EstadoP',/* otros campos permitidos */];


    public function personas(){
        return $this->belongsTo(Personas::class, 'idpersona', 'id');
    }
}
