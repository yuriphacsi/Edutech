<?php
class PagoController extends Controller {
    private $pagoModel;

    public function __construct() {
        $this->pagoModel = $this->model('Pago');
        Middleware::auth(); // Asegurar que esté logueado
    }

    public function realizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $alumno_id = $_SESSION['user_id'];
            $curso_id = $_POST['curso_id'];
            $monto = $_POST['monto'];
            $metodo = $_POST['metodo_pago'];
            $referencia = $_POST['referencia'] ?? '';

            if ($this->pagoModel->registrarPago($alumno_id, $curso_id, $monto, $metodo, $referencia)) {
                header('Location: /alumno/pagos?status=success');
            } else {
                header('Location: /alumno/pagos?status=error');
            }
            exit;
        }
    }

    public function historialAlumno() {
        $alumno_id = $_SESSION['user_id'];
        $pagos = $this->pagoModel->obtenerPagosPorAlumno($alumno_id);
        $this->view('alumno/pagos', ['pagos' => $pagos]);
    }

    public function adminPagos() {
        Middleware::admin(); // Verificar que sea administrador
        $pagos = $this->pagoModel->obtenerTodosLosPagos();
        $this->view('admin/pagos/index', ['pagos' => $pagos]);
    }

    public function validar() {
        Middleware::admin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pago_id = $_POST['pago_id'];
            $estado = $_POST['estado']; // 'aprobado' o 'rechazado'
            $this->pagoModel->actualizarEstado($pago_id, $estado);
            header('Location: /admin/pagos');
            exit;
        }
    }
}
