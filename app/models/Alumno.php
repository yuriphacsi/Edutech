<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Alumno extends Model
{
    protected string $table = 'alumnos';
    protected string $primaryKey = 'id_alumno';

    public function getAllAlumnos(): array
    {
        $sql = "
            SELECT 
                a.id_alumno,
                u.nombres,
                u.apellidos
            FROM alumnos a
            INNER JOIN usuarios u ON u.id_usuario = a.id_usuario
            ORDER BY a.id_alumno DESC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCursosInscritos(int $id_usuario): array
    {
        $sql = "
            SELECT
                c.id_curso,
                c.nombre,
                c.descripcion,
                c.nivel,
                c.imagen,
                0 AS progreso,
                i.created_at AS fecha_inscripcion,
                u.nombres    AS asesor_nombres,
                u.apellidos  AS asesor_apellidos
            FROM inscripciones i
            INNER JOIN cursos c        ON c.id_curso  = i.id_curso
            LEFT  JOIN asesor_curso ac ON ac.id_curso = c.id_curso
            LEFT  JOIN asesores a      ON a.id_asesor = ac.id_asesor
            LEFT  JOIN usuarios u      ON u.id_usuario = a.id_usuario
            WHERE i.id_usuario = :id_usuario
              AND c.estado = 1
            ORDER BY i.created_at DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_usuario' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCursosDisponibles(int $id_usuario): array
    {
        $sql = "
            SELECT 
                c.id_curso,
                c.nombre,
                c.descripcion,
                c.nivel,
                c.imagen
            FROM cursos c
            WHERE c.estado = 1
            AND c.id_curso NOT IN (
                SELECT i.id_curso
                FROM inscripciones i
                WHERE i.id_usuario = :id_usuario
            )
            ORDER BY c.id_curso DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_usuario' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function inscribir(int $id_usuario, int $id_curso): bool
    {
        $check = $this->db->prepare("
            SELECT id_inscripcion 
            FROM inscripciones 
            WHERE id_usuario = :u AND id_curso = :c
        ");

        $check->execute([':u' => $id_usuario, ':c' => $id_curso]);

        if ($check->fetch()) return false;

        $stmt = $this->db->prepare("
            INSERT INTO inscripciones (id_usuario, id_curso, created_at)
            VALUES (:u, :c, NOW())
        ");

        return $stmt->execute([':u' => $id_usuario, ':c' => $id_curso]);
    }

    public function anular(int $id_usuario, int $id_curso): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM inscripciones
            WHERE id_usuario = :u AND id_curso = :c
        ");

        return $stmt->execute([':u' => $id_usuario, ':c' => $id_curso]);
    }

    public function getUsuarioByAlumno(int $id_alumno): ?int
    {
        $sql = "
            SELECT id_usuario
            FROM alumnos
            WHERE id_alumno = :id_alumno
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_alumno' => $id_alumno]);

        return $stmt->fetchColumn() ?: null;
    }

    public function getIdAlumnoPorUsuario(int $id_usuario): ?int
    {
        $stmt = $this->db->prepare("SELECT id_alumno FROM alumnos WHERE id_usuario = :u");
        $stmt->execute([':u' => $id_usuario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['id_alumno'] : null;
    }

    public function getNotasPorCurso(int $id_usuario): array
    {
        $sql = "
            SELECT
                n.id_nota,
                n.id_curso,
                c.nombre AS curso_nombre,
                c.nivel,
                c.imagen,
                n.tipo_evaluacion,
                n.nota,
                n.nota_maxima,
                n.comentario,
                n.fecha_evaluacion
            FROM notas n
            INNER JOIN cursos c ON c.id_curso = n.id_curso
            WHERE n.id_usuario = :id_usuario
            ORDER BY c.nombre ASC, n.fecha_evaluacion ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_usuario' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCalificacionesAsesorias(int $id_alumno): array
    {
        $sql = "
            SELECT
                cal.id_calificacion,
                cal.puntuacion,
                cal.comentario,
                cal.created_at,
                c.nombre AS curso_nombre,
                u.nombres   AS asesor_nombres,
                u.apellidos AS asesor_apellidos,
                ase.fecha AS fecha_asesoria
            FROM calificaciones cal
            INNER JOIN asesorias ase ON ase.id_asesoria = cal.id_asesoria
            INNER JOIN cursos c      ON c.id_curso = ase.id_curso
            INNER JOIN asesores a    ON a.id_asesor = cal.id_asesor
            INNER JOIN usuarios u    ON u.id_usuario = a.id_usuario
            WHERE cal.id_alumno = :id_alumno
            ORDER BY cal.created_at DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_alumno' => $id_alumno]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAsistenciaPorCurso(int $id_alumno): array
    {
        $sql = "
            SELECT
                ase.id_asesoria,
                ase.id_curso,
                c.nombre   AS curso_nombre,
                c.nivel,
                c.imagen,
                ase.fecha,
                ase.hora_inicio,
                ase.hora_fin,
                ase.estado,
                u.nombres   AS asesor_nombres,
                u.apellidos AS asesor_apellidos
            FROM asesorias ase
            INNER JOIN cursos c    ON c.id_curso  = ase.id_curso
            INNER JOIN asesores a  ON a.id_asesor = ase.id_asesor
            INNER JOIN usuarios u  ON u.id_usuario = a.id_usuario
            WHERE ase.id_alumno = :id_alumno
            ORDER BY ase.fecha DESC, ase.hora_inicio DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_alumno' => $id_alumno]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getResumenAsistencia(int $id_alumno): array
    {
        $registros = $this->getAsistenciaPorCurso($id_alumno);

        $resumen = [
            'total'      => count($registros),
            'asistio'    => 0,
            'programada' => 0,
            'falta'      => 0,
            'cancelada'  => 0,
        ];

        $hoy = date('Y-m-d');

        foreach ($registros as $r) {
            if ($r['estado'] === 'Finalizada') {
                $resumen['asistio']++;
            } elseif ($r['estado'] === 'Cancelada') {
                $resumen['cancelada']++;
            } elseif ($r['estado'] === 'Pendiente' && $r['fecha'] < $hoy) {
                $resumen['falta']++;
            } else {
                $resumen['programada']++;
            }
        }

        $base = $resumen['asistio'] + $resumen['falta'];
        $resumen['porcentaje'] = $base > 0
            ? round(($resumen['asistio'] / $base) * 100)
            : 0;

        return $resumen;
    }
}