<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Inscripcion extends Model
{
    protected string $table = 'inscripciones';
    protected string $primaryKey = 'id_inscripcion';

    /**
     * Verifica si un alumno está inscrito en un curso
     */
    public function existsAlumnoCurso(int $idAlumno, int $idCurso): bool
    {
        $sql = "
            SELECT COUNT(*) as total
            FROM inscripciones
            WHERE id_alumno = :alumno
            AND id_curso = :curso
            AND estado = 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'alumno' => $idAlumno,
            'curso' => $idCurso
        ]);

        return (int)$stmt->fetch()['total'] > 0;
    }

    /**
     * Obtener cursos de un alumno
     */
    public function getCursosByAlumno(int $idAlumno): array
    {
        $sql = "
            SELECT c.id_curso, c.nombre
            FROM inscripciones i
            INNER JOIN cursos c ON c.id_curso = i.id_curso
            WHERE i.id_alumno = :id_alumno
              AND i.estado = 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id_alumno' => $idAlumno
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Inscribir alumno en curso
     */
    public function inscribir(int $idAlumno, int $idCurso): bool
    {
        $sql = "
            INSERT INTO inscripciones (id_alumno, id_curso, estado)
            VALUES (:id_alumno, :id_curso, 1)
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id_alumno' => $idAlumno,
            'id_curso' => $idCurso
        ]);
    }
}