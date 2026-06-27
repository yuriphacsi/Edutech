<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Asesor extends Model
{
    protected string $table = 'asesores';
    protected string $primaryKey = 'id_asesor';

    /**
     * Obtener todos los asesores activos y verificados
     */
    public function getAllAsesores(): array
    {
        $sql = "
            SELECT 
                a.id_asesor,
                a.id_usuario,
                u.nombres,
                u.apellidos,
                u.correo
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

    /**
     * Buscar asesores por nombre o apellido
     */
    public function search(string $q): array
    {
        $sql = "
            SELECT 
                a.id_asesor,
                a.id_usuario,
                u.nombres,
                u.apellidos,
                u.correo
            FROM asesores a
            INNER JOIN usuarios u 
                ON u.id_usuario = a.id_usuario
            WHERE a.estado_verificacion = 1
              AND u.estado = 1
              AND (u.nombres LIKE :q OR u.apellidos LIKE :q)
            ORDER BY a.id_asesor DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'q' => "%$q%"
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crear asesor vinculado a usuario
     */
    public function createAsesor(int $idUsuario): bool
    {
        $sql = "
            INSERT INTO asesores (id_usuario, estado_verificacion)
            VALUES (:id_usuario, 1)
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id_usuario' => $idUsuario
        ]);
    }
}