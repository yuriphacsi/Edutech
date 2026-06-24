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

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    public function all(): array
    {
        $stmt = $this->db->query("SELECT * FROM usuarios");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function emailExists($correo): bool
    {
        $stmt = $this->db->prepare("SELECT id_usuario FROM usuarios WHERE correo = ?");
        $stmt->execute([$correo]);

        return (bool) $stmt->fetchColumn();
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
        $sql = "UPDATE usuarios SET estado = 0 WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }

    public function countAll(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM usuarios");
        return (int) $stmt->fetch(\PDO::FETCH_ASSOC)['total'];
    }

    public function countByStatus($status): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total 
            FROM usuarios 
            WHERE estado = ?
        ");

        $stmt->execute([$status]);

        return (int) $stmt->fetch(\PDO::FETCH_ASSOC)['total'];
    }

    public function getLatest(int $limit = 5): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                CONCAT(nombres, ' ', apellidos) AS nombre_completo,
                created_at
            FROM usuarios
            ORDER BY created_at DESC
            LIMIT ?
        ");

        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function usersByMonth(): array
    {
        $stmt = $this->db->query("
            SELECT 
                DATE_FORMAT(created_at,'%b') as mes,
                COUNT(*) as total
            FROM usuarios
            WHERE created_at IS NOT NULL
            GROUP BY mes
            ORDER BY mes ASC
        ");

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function usersLast12Months(): array
    {
        $stmt = $this->db->query("
            SELECT 
                DATE_FORMAT(created_at, '%Y-%m') as mes,
                COUNT(*) as total
            FROM usuarios
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
            GROUP BY DATE_FORMAT(created_at, '%Y-%m')
            ORDER BY DATE_FORMAT(created_at, '%Y-%m') ASC
        ");

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function updateLastLogin(int $id): bool
    {
        $stmt = $this->db->prepare("
            UPDATE usuarios
            SET last_login = NOW()
            WHERE id_usuario = ?
        ");

        return $stmt->execute([$id]);
    }

    public function getLastLogins(int $limit = 5): array
    {
        $stmt = $this->db->prepare("
            SELECT
                CONCAT(nombres, ' ', apellidos) AS nombre_completo,
                last_login
            FROM usuarios
            WHERE last_login IS NOT NULL
            ORDER BY last_login DESC
            LIMIT ?
        ");

        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}