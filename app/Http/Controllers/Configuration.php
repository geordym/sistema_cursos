<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;

    protected $table = "configuration";

    protected $fillable = ['key', 'value']; // Asegúrate de que estas columnas sean asignables
}
