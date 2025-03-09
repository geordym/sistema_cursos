<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hour_load',
        'collaborator_id', // Asegúrate de incluir este campo
    ];

    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class, 'collaborator_id');
    }

    public function template()
    {
        return $this->belongsTo(Template::class, 'template_id');
    }
}
