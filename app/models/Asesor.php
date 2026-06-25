<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Asesor extends Model
{
    protected string $table = 'asesores';
    protected string $primaryKey = 'id_asesor';

    public function all(): array
    {
        $sql = "
            SELECT 
                a.id_asesor,
                u.nombres,
                u.apellidos
            FROM asesores a
            INNER JOIN usuarios u 
                ON u.id_usuario = a.id_usuario
            WHERE a.estado_verificacion = 1
              AND u.estado = 1
            ORDER BY a.id_asesor DESC
        ";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}