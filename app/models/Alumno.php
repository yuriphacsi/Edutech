<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Alumno extends Model
{
    protected string $table = 'alumnos';
    protected string $primaryKey = 'id_alumno';

    public function getAllAlumnos(): array
    {
        $sql = "
            SELECT 
                a.id_alumno,
                u.nombres,
                u.apellidos
            FROM alumnos a
            INNER JOIN usuarios u ON u.id_usuario = a.id_usuario
            ORDER BY a.id_alumno DESC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}