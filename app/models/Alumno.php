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

    public function getCursosDisponibles(int $id_usuario): array
    {
        $sql = "
            SELECT 
                c.id_curso,
                c.nombre,
                c.descripcion,
                c.nivel,
                c.imagen
            FROM cursos c
            WHERE c.estado = 1
            AND c.id_curso NOT IN (
                SELECT i.id_curso
                FROM inscripciones i
                WHERE i.id_usuario = :id_usuario
            )
            ORDER BY c.id_curso DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_usuario' => $id_usuario]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function inscribir(int $id_usuario, int $id_curso): bool
    {
        // evitar duplicados
        $check = $this->db->prepare("
            SELECT id_inscripcion 
            FROM inscripciones 
            WHERE id_usuario = :u AND id_curso = :c
        ");

        $check->execute([
            ':u' => $id_usuario,
            ':c' => $id_curso
        ]);

        if ($check->fetch()) {
            return false;
        }

        // insertar inscripción
        $stmt = $this->db->prepare("
            INSERT INTO inscripciones (id_usuario, id_curso, created_at)
            VALUES (:u, :c, NOW())
        ");

        return $stmt->execute([
            ':u' => $id_usuario,
            ':c' => $id_curso
        ]);
    }

    public function getUsuarioByAlumno(int $id_alumno): ?int
    {
        $sql = "
            SELECT id_usuario
            FROM alumnos
            WHERE id_alumno = :id_alumno
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_alumno' => $id_alumno]);

        return $stmt->fetchColumn() ?: null;
    }
}