<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Certificado;
use App\Helpers\Session;
use App\Middleware\AuthMiddleware;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\Asesor;
use App\Models\Inscripcion;
use Spatie\Browsershot\Browsershot;

class CertificadoController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::check();
        AuthMiddleware::role([1]);
    }

    public function index()
    {
        $certificado = new Certificado();

        $this->view('admin/certificados/index', [
            'module' => 'certificados',
            'certificados' => $certificado->getAll()
        ], 'layouts/main');
    }

    public function create()
    {
        $usuarioModel = new \App\Models\Usuario();
        $cursoModel = new Curso();
        $asesorModel = new Asesor();

        $inscripcionModel = new Inscripcion();

        $this->view('admin/certificados/create', [
            'alumnos' => $usuarioModel->getAlumnos(),
            'cursos' => $cursoModel->all(),
            'asesores' => $asesorModel->getAllAsesores(),
            'module' => 'certificados'
        ], 'layouts/main');
    }

    public function store()
    {
        Session::start();

        $cert = new \App\Models\Certificado();
        $inscripcion = new \App\Models\Inscripcion();
        $alumnoModel = new Alumno();
        
        $id_alumno = $_POST['id_alumno'] ?? null;
        $id_curso = $_POST['id_curso'] ?? null;
        $id_asesor = $_POST['id_asesor'] ?? null;

        $descripcion = $_POST['descripcion'] ?? '';
        $horas = $_POST['horas'] ?? 0;

        if (!$id_alumno || !$id_curso) {
            Session::set('error', 'Datos incompletos');
            header("Location: /Edutech/admin/certificados/create");
            exit;
        }

        // VALIDAR INSCRIPCIÓN (IMPORTANTE: alumno → usuario)
        $id_usuario = $alumnoModel->getUsuarioByAlumno($id_alumno);

        if (!$id_usuario) {
            Session::set('error', 'Alumno inválido');
            header("Location: /Edutech/admin/certificados/create");
            exit;
        }
        if (!$inscripcion->existsAlumnoCursoByAlumno($id_alumno, $id_curso)) {
            Session::set('error', 'El alumno no está inscrito en este curso');
            header("Location: /Edutech/admin/certificados/create");
            exit;
        }

        if ($cert->exists($id_alumno, $id_curso)) {
            Session::set('error', 'Ya existe un certificado para este curso');
            header("Location: /Edutech/admin/certificados/create");
            exit;
        }

        $codigo = 'CERT-' . date('Y') . '-' . rand(10000, 99999);

        $cert->create([
            'id_alumno' => $id_alumno,
            'id_curso' => $id_curso,
            'id_asesor' => $id_asesor,
            'codigo' => $codigo,
            'descripcion' => $descripcion,
            'horas' => $horas,
            'fecha_emision' => date('Y-m-d'),
            'estado' => 1
        ]);

        Session::set('success', 'Certificado emitido correctamente');

        header("Location: /Edutech/admin/certificados");
        exit;
    }

    public function edit(){}

    public function update(){}

    public function delete(){}

    public function show()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            Session::set('error', 'Certificado no encontrado');
            header("Location: /Edutech/admin/certificados");
            exit;
        }

        $cert = new \App\Models\Certificado();
        $data = $cert->findOne((int)$id);

        if (!$data) {
            Session::set('error', 'Certificado no existe');
            header("Location: /Edutech/admin/certificados");
            exit;
        }

        $this->view('admin/certificados/show', [
            'certificado' => $data,
            'module' => 'certificados'
        ], 'layouts/main');
    }

    public function download(){}

    public function cursos()
    {
        $id_alumno = (int)($_GET['id_alumno'] ?? 0);

        $alumno = new Alumno();
        $inscripcion = new Inscripcion();

        $id_usuario = $alumno->getUsuarioByAlumno($id_alumno);

        header('Content-Type: application/json');

        if (!$id_usuario) {
            echo json_encode([]);
            exit;
        }

        echo json_encode(
            $inscripcion->getCursosByAlumno($id_usuario)
        );

        exit;
    }

    public function pdf()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            die("ID no proporcionado");
        }

        $cert = new Certificado();
        $certificado = $cert->findOne((int)$id);

        if (!$certificado) {
            die("Certificado no encontrado");
        }

        // Generar el HTML
        ob_start();
        require __DIR__ . '/../../views/admin/certificados/pdf.php';
        $html = ob_get_clean();

        $tempPdf = tempnam(sys_get_temp_dir(), 'cert_') . '.pdf';

        Browsershot::html($html)
            ->setNodeBinary('C:\Program Files\nodejs\node.exe')
            ->setChromePath('C:\Program Files\Google\Chrome\Application\chrome.exe')
            ->showBackground()
            ->landscape()
            ->format('A4')
            ->margins(0, 0, 0, 0)
            ->save($tempPdf);

        while (ob_get_level()) {
            ob_end_clean();
        }
        
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="certificado.pdf"');

        readfile($tempPdf);

        unlink($tempPdf);

        exit;
    }
}