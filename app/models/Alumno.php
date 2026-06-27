<?php

namespace App\Models;

use App\Core\Model;

class Alumno extends Model
{
    protected string $table = 'alumnos';
    protected string $primaryKey = 'id_alumno';
}