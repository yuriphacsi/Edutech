<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Certificado extends Model
{
    protected string $table = 'certificados';
    protected string $primaryKey = 'id_certificado';

    public function getAll(): array
    {
        $sql = "
            SELECT 
                c.id_certificado,
                c.codigo,
                c.descripcion,
                c.horas,
                c.fecha_emision,
                c.estado,

                u.nombres AS alumno_nombre,
                u.apellidos AS alumno_apellido,
                cu.nombre AS curso_nombre
            FROM certificados c
            INNER JOIN alumnos a ON a.id_alumno = c.id_alumno
            INNER JOIN usuarios u ON u.id_usuario = a.id_usuario
            INNER JOIN cursos cu ON cu.id_curso = c.id_curso
            ORDER BY c.id_certificado DESC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findOne(int $id): array|false
    {
        $sql = "
            SELECT 
                c.*,
                u.nombres AS alumno_nombre,
                u.apellidos AS alumno_apellido,
                cu.nombre AS curso_nombre
            FROM certificados c
            INNER JOIN alumnos a ON a.id_alumno = c.id_alumno
            INNER JOIN usuarios u ON u.id_usuario = a.id_usuario
            INNER JOIN cursos cu ON cu.id_curso = c.id_curso
            WHERE c.id_certificado = :id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function exists(int $id_alumno, int $id_curso): bool
    {
        $sql = "
            SELECT COUNT(*)
            FROM certificados
            WHERE id_alumno = :id_alumno
            AND id_curso = :id_curso
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id_alumno' => $id_alumno,
            ':id_curso' => $id_curso
        ]);

        return $stmt->fetchColumn() > 0;
    }
}