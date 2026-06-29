<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Curso extends Model
{
    protected string $table = 'cursos';
    protected string $primaryKey = 'id_curso';

    public function list(): array
    {
        $sql = "
            SELECT 
                c.id_curso,
                c.nombre,
                c.nivel,
                c.cupo_maximo,
                c.estado,

                u.nombres AS asesor_nombre,
                u.apellidos AS asesor_apellido

            FROM cursos c

            LEFT JOIN asesores a 
                ON a.id_asesor = c.id_asesor

            LEFT JOIN usuarios u 
                ON u.id_usuario = a.id_usuario

            ORDER BY c.id_curso DESC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete(int $id): bool
    {
        $sql = "
            UPDATE cursos
            SET estado = 0,
                updated_at = NOW()
            WHERE id_curso = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function countAll(int $estado = 1): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) AS total
            FROM cursos
            WHERE estado = :estado
        ");

        $stmt->execute(['estado' => $estado]);

        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getLatest(int $limit = 5): array
    {
        $stmt = $this->db->prepare("
            SELECT nombre, created_at
            FROM cursos
            WHERE estado = 1
            ORDER BY id_curso DESC
            LIMIT :limit
        ");

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listWithAlumnos()
    {
        $sql = "
            SELECT 
                c.id_curso,
                c.nombre,
                c.nivel,
                c.cupo_maximo,
                c.estado,
                COUNT(i.id_inscripcion) AS total_alumnos
            FROM cursos c
            LEFT JOIN inscripciones i 
                ON i.id_curso = c.id_curso
            GROUP BY 
                c.id_curso,
                c.nombre,
                c.nivel,
                c.cupo_maximo,
                c.estado
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAlumnosByCurso(int $idCurso): array
    {
        $sql = "
            SELECT 
                i.id_inscripcion,
                i.created_at,
                u.nombres,
                u.apellidos
            FROM inscripciones i
            INNER JOIN usuarios u 
                ON u.id_usuario = i.id_usuario
            WHERE i.id_curso = :id
            ORDER BY i.created_at DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $idCurso]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}