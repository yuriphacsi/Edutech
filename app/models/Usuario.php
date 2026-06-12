<?php

namespace App\Models;

use App\Core\Model;

class Usuario extends Model
{
    protected string $table = 'usuarios';
    protected string $primaryKey = 'id_usuario';

    public function findByEmail($correo)
    {
        $sql = "SELECT usuarios.*, roles.nombre as rol_nombre
                FROM usuarios
                INNER JOIN roles ON usuarios.id_rol = roles.id_rol
                WHERE correo = :correo
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function all(): array
    {
        $stmt = $this->db->query("SELECT * FROM usuarios");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO usuarios 
            (id_rol, nombres, apellidos, correo, password, estado)
            VALUES 
            (:id_rol, :nombres, :apellidos, :correo, :password, :estado)";

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM usuarios WHERE id_usuario = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }

    public function countAll(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM usuarios");
        return (int) $stmt->fetch()['total'];
    }
}