<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    //use HasFactory;
    protected $table = 'personales';
    public $timestamps = false;
    protected $primaryKey = 'id';
    
    public function personas(){
        return $this->belongsTo(Personas::class, 'idpersona', 'id');
    }
    
    
}
