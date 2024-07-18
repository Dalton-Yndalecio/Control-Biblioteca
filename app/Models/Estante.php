<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estante extends Model
{
    protected $table = 'estantes';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
