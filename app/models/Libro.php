<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Libro extends Model
{
    protected string $table = 'biblioteca';
    protected string $primaryKey = 'id_biblioteca';

    // Listar libros
    public function listActivos(): array
    {
        $sql = "
            SELECT *
            FROM biblioteca
            WHERE estado = 1
            ORDER BY titulo ASC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar libros
    public function buscar(string $texto): array
    {
        $sql = "
            SELECT *
            FROM biblioteca
            WHERE estado = 1
            AND (
                titulo LIKE :texto
                OR autor LIKE :texto
                OR categoria LIKE :texto
            )
            ORDER BY titulo ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'texto' => "%{$texto}%"
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}