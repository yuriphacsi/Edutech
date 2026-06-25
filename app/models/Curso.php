<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Curso extends Model
{
    protected string $table = 'cursos';
    protected string $primaryKey = 'id_curso';

    public function all(): array
    {
        $sql = "
            SELECT
                c.id_curso,
                c.nombre,
                c.descripcion,
                c.nivel,
                c.imagen,
                c.estado,
                c.id_asesor,
                c.cupo_maximo,

                u.nombres AS asesor_nombre,
                u.apellidos AS asesor_apellido,

                COALESCE(COUNT(i.id_inscripcion), 0) AS total_alumnos

            FROM cursos c

            LEFT JOIN asesores a
                ON a.id_asesor = c.id_asesor

            LEFT JOIN usuarios u
                ON u.id_usuario = a.id_usuario

            LEFT JOIN inscripciones i
                ON i.id_curso = c.id_curso

            GROUP BY
                c.id_curso,
                c.nombre,
                c.descripcion,
                c.nivel,
                c.imagen,
                c.estado,
                c.id_asesor,
                c.cupo_maximo,
                u.nombres,
                u.apellidos

            ORDER BY c.id_curso DESC
        ";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): array|false
    {
        return parent::find($id);
    }

    public function create(array $data): int
    {
        return parent::create($data);
    }

    public function update(int $id, array $data): bool
    {
        return parent::update($id, $data);
    }

    public function delete(int $id): bool
    {
        $sql = "
            UPDATE cursos
            SET estado = 0
            WHERE id_curso = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function countAll(): int
    {
        $stmt = $this->db->query("
            SELECT COUNT(*) AS total
            FROM cursos
        ");

        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getLatest(int $limit = 5): array
    {
        $stmt = $this->db->prepare("
            SELECT nombre, created_at
            FROM cursos
            ORDER BY id_curso DESC
            LIMIT ?
        ");

        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}