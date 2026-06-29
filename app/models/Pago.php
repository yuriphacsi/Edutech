<?php
class Pago extends Model {
    public function registrarPago($alumno_id, $curso_id, $monto, $metodo, $referencia) {
        $sql = "INSERT INTO pagos (alumno_id, curso_id, monto, metodo_pago, referencia, estado, fecha_pago) 
                VALUES (:alumno_id, :curso_id, :monto, :metodo, :referencia, 'pendiente', NOW())";
        return $this->db->query($sql, [
            'alumno_id' => $alumno_id,
            'curso_id' => $curso_id,
            'monto' => $monto,
            'metodo' => $metodo,
            'referencia' => $referencia
        ]);
    }

    public function obtenerPagosPorAlumno($alumno_id) {
        $sql = "SELECT p.*, c.nombre as curso_nombre FROM pagos p 
                JOIN cursos c ON p.curso_id = c.id 
                WHERE p.alumno_id = :alumno_id ORDER BY p.fecha_pago DESC";
        return $this->db->selectAll($sql, ['alumno_id' => $alumno_id]);
    }

    public function obtenerTodosLosPagos() {
        $sql = "SELECT p.*, u.nombre as alumno_nombre, c.nombre as curso_nombre FROM pagos p 
                JOIN usuarios u ON p.alumno_id = u.id 
                JOIN cursos c ON p.curso_id = c.id ORDER BY p.fecha_pago DESC";
        return $this->db->selectAll($sql);
    }

    public function actualizarEstado($pago_id, $estado) {
        $sql = "UPDATE pagos SET estado = :estado WHERE id = :id";
        return $this->db->query($sql, ['estado' => $estado, 'id' => $pago_id]);
    }
}
