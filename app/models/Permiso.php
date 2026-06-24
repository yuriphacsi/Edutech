<?php

namespace App\Models;

use App\Core\Model;

class Permiso extends Model
{
    protected string $table = 'permisos';
    protected string $primaryKey = 'id_permiso';

    public function getByRole(int $idRol): array
    {
        $sql = "
            SELECT p.nombre
            FROM permisos p
            INNER JOIN rol_permisos rp ON rp.id_permiso = p.id_permiso
            WHERE rp.id_rol = ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idRol]);

        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
}