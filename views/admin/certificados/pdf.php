<?php
$logoPath = __DIR__ . '/../../../public/img/logo.png';
$logoData = base64_encode(file_get_contents($logoPath));
$logoSrc = 'data:image/png;base64,' . $logoData;
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">

<style>
@page {
    size: A4 landscape;
    margin: 0;
}

html, body {
    margin: 0;
    padding: 0;
    overflow: hidden;
}

* {
    box-sizing: border-box;
}
.certificado-container {
    padding: 0;
    margin: 0;
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* CONTENEDOR PRINCIPAL CON PROFUNDIDAD */
.certificado{
    width: 100%;
    height: 100%;

    margin:auto;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    position:relative;
    overflow:hidden;

    padding:15mm;

    border:1px solid rgba(30,58,138,0.25);

    box-shadow:
        0 20px 50px rgba(0,0,0,0.15),
        inset 0 0 0 2px rgba(59,130,246,0.08);
    
    page-break-after: avoid;
    page-break-before: avoid;
    page-break-inside: avoid;
}

@media print {

    body{
        background:white;
    }

    .certificado-container{
        padding:0;
        background:white;
    }

    .certificado{
        width:297mm;
        height:210mm;
        margin:0;
        box-shadow:none;
        border:none;
    }
}

/* ESQUINAS DECORATIVAS SUTILES */
.certificado::before,
.certificado::after{
    content:"";
    position:absolute;
    width:180px;
    height:180px;
    border:2px solid rgba(30,58,138,0.12);
    pointer-events:none;
}

.certificado::before{
    top:20px;
    left:20px;
    border-right:none;
    border-bottom:none;
}

.certificado::after{
    bottom:20px;
    right:20px;
    border-left:none;
    border-top:none;
}

/* BANDA SUPERIOR MÁS ELEGANTE */
.top-bar{
    position:absolute;
    top:0;
    left:0;
    right:0;
    height:12px;
    background:linear-gradient(
        90deg,
        #1e3a8a,
        #3b82f6,
        #60a5fa,
        #1e3a8a
    );
    box-shadow:0 2px 10px rgba(30,58,138,0.3);
}

/* MARCA DE AGUA MÁS SOFISTICADA */
.watermark{
    position:absolute;
    top:52%;
    left:50%;
    transform:translate(-50%,-50%) rotate(-28deg);
    font-size:130px;
    font-weight:900;
    letter-spacing:10px;

    background:linear-gradient(90deg, rgba(30,58,138,0.05), rgba(59,130,246,0.05));
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;

    white-space:nowrap;
    filter:blur(0.2px);
}

/* HEADER MÁS LIMPIO Y MODERNO */
.header{
    display:flex;
    align-items:center;
    gap:20px;
    position:relative;
    z-index:2;
}

.logo img{
    width:78px;
    filter:drop-shadow(0 5px 10px rgba(0,0,0,0.15));
}

.header-text .small{
    font-size:11px;
    letter-spacing:3px;
    color:#64748b;
}

.header-text h1{
    margin:0;
    font-size:32px;
    color:#1e3a8a;
    letter-spacing:1px;
}

.header-text .line{
    width:110px;
    height:3px;
    background:linear-gradient(90deg,#1e3a8a,#60a5fa);
    margin-top:8px;
    border-radius:2px;
}

/* CUERPO MÁS “AIREADO” */
.body{
    margin-top:75px;
    position:relative;
    z-index:2;
}

.label{
    font-size:11px;
    letter-spacing:3px;
    color:#94a3b8;
}

.student{
    font-size:44px;
    font-weight:900;
    color:#0f172a;
    margin:18px 0;
    letter-spacing:2px;

    text-shadow:0 2px 10px rgba(0,0,0,0.05);
}

/* línea decorativa bajo el nombre */
.student::after{
    content:"";
    display:block;
    width:160px;
    height:2px;
    margin:18px auto 0;
    background:linear-gradient(90deg,#1e3a8a,#60a5fa);
    opacity:0.6;
}

.desc{
    font-size:15px;
    color:#475569;
    max-width:780px;
    line-height:1.7;
}

.course{
    margin-top:20px;
    font-size:28px;
    color:#1e3a8a;
    font-weight:700;
    letter-spacing:1px;
}

/* BLOQUE DE AUTENTICIDAD MÁS VISUAL */
.auth{
    display:flex;
    justify-content:space-between;
    margin-top:50px;
    padding-top:20px;

    border-top:1px solid rgba(148,163,184,0.4);
}

.auth-item{
    text-align:center;
    flex:1;
    position:relative;
}

.auth-item:not(:last-child)::after{
    content:"";
    position:absolute;
    right:0;
    top:20%;
    height:60%;
    width:1px;
    background:rgba(148,163,184,0.3);
}

.auth-item span{
    font-size:11px;
    color:#94a3b8;
    letter-spacing:1px;
}

.auth-item strong{
    font-size:14px;
    color:#0f172a;
}

.block-text {
    font-size: 12px;
    margin-top: 10px;
    line-height: 1.4;
    color: #475569;
}

/* FOOTER MÁS PREMIUM */
.footer{
    position:absolute;
    bottom:65px;
    left:65px;
    right:65px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

/* FIRMA MÁS REALISTA */
.signature{
    text-align:center;
}

.sig-line{
    width:170px;
    border-top:1px solid #0f172a;
    margin-bottom:6px;
    opacity:0.8;
}

/* SELLO CON EFECTO MÁS REAL */
.seal-inner{
    width:115px;
    height:115px;
    border-radius:50%;

    border:2px dashed #1e3a8a;

    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;

    font-weight:800;
    font-size:11px;
    color:#1e3a8a;

    box-shadow:
        inset 0 0 15px rgba(30,58,138,0.08),
        0 10px 20px rgba(0,0,0,0.08);
}

/* VERIFICACIÓN MÁS LIMPIA */
.verify{
    position:absolute;
    bottom:15px;
    left:65px;
    right:65px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    font-size:11px;
    color:#64748b;
}

.qr-box{
    width:70px;
    height:70px;
    border:1px solid #cbd5e1;
    display:flex;
    align-items:center;
    justify-content:center;

    font-size:9px;
    color:#94a3b8;

    background:#f8fafc;
}
</style>

</head>

<body>

<div class="certificado-container">

    <div class="certificado">

        <!-- MARCA DE AGUA -->
        <div class="watermark">EDUTECH</div>

        <!-- BANDA SUPERIOR -->
        <div class="top-bar"></div>

        <!-- HEADER -->
        <div class="header">

            <div class="logo">
                <img src="<?= $logoSrc ?>">
            </div>

            <div class="header-text">
                <span class="small">CERTIFICACIÓN ACADÉMICA OFICIAL</span>
                <h1>Certificado de Finalización</h1>
                <div class="line"></div>
            </div>

        </div>

        <!-- CUERPO -->
        <div class="body">

            <p class="label">SE CERTIFICA A</p>

            <div class="student">
                <?= strtoupper($certificado['alumno_nombre'] . ' ' . $certificado['alumno_apellido']) ?>
            </div>

            <div class="divider"></div>

            <p class="desc">
                ha culminado satisfactoriamente el curso de
            </p>

            <div class="course">
                <?= $certificado['curso_nombre'] ?>
            </div>

            <div class="block-text">
                <p>
                    El presente certificado acredita la participación del estudiante en el programa de asesoría académica de EduTech,
                    diseñado para fortalecer competencias, guiar el aprendizaje progresivo y consolidar habilidades académicas clave
                    dentro de su formación educativa.
                </p>
            </div>

        </div>

        <!-- DETALLES -->
        <div class="auth">

            <div class="auth-item">
                <span>Horas académicas</span>
                <strong><?= $certificado['horas'] ?></strong>
            </div>

            <div class="auth-item">
                <span>Fecha de emisión</span>
                <strong><?= $certificado['fecha_emision'] ?></strong>
            </div>

            <div class="auth-item">
                <span>Código de verificación</span>
                <strong><?= $certificado['codigo'] ?></strong>
            </div>

        </div>

        <!-- FOOTER -->
        <div class="footer">

            <div class="signature">
                <div class="sig-line"></div>
                <span>Asesor Académico</span>
            </div>

            <div class="seal">
                <div class="seal-inner">
                    CERTIFICADO<br>EDUTECH
                </div>
            </div>

            <div class="signature">
                <div class="sig-line"></div>
                <span>Dirección Académica</span>
            </div>

        </div>

        <!-- VERIFICACIÓN -->
        <div class="verify">

            <div class="verify-text">
                Validación en línea: <strong>EduTech Sistema de Certificación</strong><br>
                Código: <?= $certificado['codigo'] ?>
            </div>

            <div class="qr">
                <div class="qr-box">QR</div>
            </div>

        </div>

    </div>

</div>
</body>
</html>