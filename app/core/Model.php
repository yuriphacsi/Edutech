<?php

namespace App\Core;

use PDO;

class Model
{
    protected PDO $db;
    protected string $table = '';
    protected string $primaryKey = 'id';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function all(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY {$this->primaryKey} DESC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find(int $id): array|false
    {
        if (empty($this->table) || empty($this->primaryKey)) {
            throw new \Exception("Table or primaryKey not defined in model");
        }

        $sql = "SELECT * FROM {$this->table}
                WHERE {$this->primaryKey} = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create(array $data): int
    {
        $columns = array_keys($data);
        $fields = implode(',', $columns);
        $placeholders = ':' . implode(', :', $columns);

        $sql = "INSERT INTO {$this->table} ($fields) VALUES ($placeholders)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];

        foreach ($data as $key => $value) {
            $fields[] = "{$key} = :{$key}";
        }

        $sql = "UPDATE {$this->table}
                SET " . implode(', ', $fields) . "
                WHERE {$this->primaryKey} = :id";

        $data['id'] = $id;

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table}
                WHERE {$this->primaryKey} = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function getConnection()
    {
        return $this->db;
    }
}