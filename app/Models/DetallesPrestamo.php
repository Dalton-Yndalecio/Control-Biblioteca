<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallesPrestamo extends Model
{
    //use HasFactory;
    protected $table = 'deatllesprestamo';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = ['OEstado','PEstado', 'FEntrega', 'Id_prestamo' /* otros campos permitidos */];


    public function prestamos(){
        return $this->belongsTo(Prestamos::class, 'Id_prestamo', 'id');
    }
    public function objeto(){
        return $this->belongsTo(Objetos::class, 'idobejeto', 'id');
    }
}
