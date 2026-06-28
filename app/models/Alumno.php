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

    /**
     * Trae los cursos en los que el alumno está inscrito.
     * Progreso en 0 hasta que se implemente la lógica de avance.
     *
     * @param int $id_usuario  El id_usuario de la sesión ($_SESSION['user']['id'])
     */
    public function getCursosInscritos(int $id_usuario): array
    {
        $sql = "
            SELECT
                c.id_curso,
                c.nombre,
                c.descripcion,
                c.nivel,
                c.imagen,
                0 AS progreso
            FROM inscripciones i
            INNER JOIN cursos c ON c.id_curso = i.id_curso
            WHERE i.id_usuario = :id_usuario
              AND c.estado = 1
            ORDER BY i.created_at DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_usuario' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}