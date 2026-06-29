<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Inscripcion extends Model
{
    protected string $table = 'inscripciones';
    protected string $primaryKey = 'id_inscripcion';

    /**
     * Verifica si usuario está inscrito en curso
     */

    /**
     * Obtener cursos de un usuario
     */
    public function getCursosByAlumno(int $idUsuario): array
    {
        $sql = "
            SELECT c.id_curso, c.nombre
            FROM inscripciones i
            INNER JOIN cursos c ON c.id_curso = i.id_curso
            WHERE i.id_usuario = :id_usuario
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_usuario' => $idUsuario]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cursos disponibles para usuario
     */
    public function getCursosDisponibles(int $idUsuario): array
    {
        $sql = "
            SELECT c.*
            FROM cursos c
            WHERE c.estado = 1
            AND c.id_curso NOT IN (
                SELECT i.id_curso
                FROM inscripciones i
                WHERE i.id_usuario = :id_usuario
            )
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id_usuario' => $idUsuario
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Inscribir usuario en curso
     */
    public function inscribir(int $idUsuario, int $idCurso): bool
    {
        $sql = "
            INSERT INTO inscripciones (id_usuario, id_curso, created_at)
            VALUES (:id_usuario, :id_curso, NOW())
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id_usuario' => $idUsuario,
            'id_curso'   => $idCurso
        ]);
    }

    public function getAllUsuariosConCursos(): array
    {
        $sql = "
            SELECT DISTINCT
                u.id_usuario,
                u.nombres,
                u.apellidos
            FROM inscripciones i
            INNER JOIN usuarios u ON u.id_usuario = i.id_usuario
            ORDER BY u.nombres
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function existsAlumnoCursoByAlumno(int $id_alumno, int $id_curso): bool
    {
        $sql = "
            SELECT COUNT(*)
            FROM inscripciones i
            INNER JOIN alumnos a ON a.id_usuario = i.id_usuario
            WHERE a.id_alumno = :id_alumno
            AND i.id_curso = :id_curso
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_alumno' => $id_alumno,
            ':id_curso' => $id_curso
        ]);

        return $stmt->fetchColumn() > 0;
    }
}