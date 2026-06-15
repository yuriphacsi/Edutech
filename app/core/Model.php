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
        $stmt = $this->db->query("SELECT * FROM {$this->table}");

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find(int $id): array|false
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE {$this->primaryKey} = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $fields = implode(',', array_keys($data));

        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$this->table}
                ({$fields})
                VALUES ({$placeholders})";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
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
}