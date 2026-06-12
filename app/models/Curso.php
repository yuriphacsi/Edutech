<?php

namespace App\Models;

use App\Core\Model;

class Curso extends Model
{
    protected string $table = 'cursos';
    protected string $primaryKey = 'id_curso';

    public function countAll(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM cursos");
        return (int) $stmt->fetch()['total'];
    }
}