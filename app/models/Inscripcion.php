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
            SELECT COUNT(*)
            FROM inscripciones i
            INNER JOIN alumnos a
                ON a.id_usuario = i.id_usuario
            WHERE a.id_alumno = :id_alumno
            AND i.id_curso = :id_curso
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'id_alumno' => $idAlumno,
            'id_curso' => $idCurso
        ]);

        return $stmt->fetchColumn() > 0;
    }

    /**
     * Obtener cursos de un alumno
     */
    public function getCursosByAlumno(int $idAlumno): array
    {
        $sql = "
            SELECT
                c.id_curso,
                c.nombre
            FROM inscripciones i
            INNER JOIN alumnos a
                ON a.id_usuario = i.id_usuario
            INNER JOIN cursos c
                ON c.id_curso = i.id_curso
            WHERE a.id_alumno = :id_alumno
            ORDER BY c.nombre
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id_alumno' => $idAlumno
        ]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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