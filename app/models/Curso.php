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
        $stmt = $this->db->query("
            SELECT *
            FROM cursos
            ORDER BY id_curso DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): array|false
    {
        $sql = "SELECT * FROM cursos WHERE id_curso = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $sql = "
            INSERT INTO cursos
            (
                nombre,
                descripcion,
                nivel,
                estado
            )
            VALUES
            (
                :nombre,
                :descripcion,
                :nivel,
                :estado
            )
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }

    public function update(int $id, array $data): bool
    {
        $sql = "
            UPDATE cursos
            SET
                nombre = :nombre,
                descripcion = :descripcion,
                nivel = :nivel,
                estado = :estado
            WHERE id_curso = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'nivel' => $data['nivel'],
            'estado' => $data['estado']
        ]);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM cursos WHERE id_curso = :id";

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

        return (int) $stmt->fetch()['total'];
    }
}