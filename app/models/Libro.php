<?php

namespace App\Models;

use App\Core\Model;

class Libro extends Model
{
    protected string $table = 'libros';
    protected string $primaryKey = 'id_libro';

    // 📄 Listar todos los libros activos
    public function listActivos(): array
    {
        $sql = "SELECT * FROM libros WHERE estado = 1 ORDER BY titulo ASC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // 🔎 Buscar libros por titulo, autor o categoria
    public function buscar(string $texto): array
    {
        $sql = "SELECT * FROM libros
                WHERE estado = 1
                AND (titulo LIKE :texto OR autor LIKE :texto OR categoria LIKE :texto)
                ORDER BY titulo ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['texto' => "%{$texto}%"]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
