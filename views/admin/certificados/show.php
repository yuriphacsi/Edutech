<div class="certificado-container">

    <div class="certificado">

        <!-- MARCA DE AGUA -->
        <div class="watermark">EDUTECH</div>

        <!-- BANDA SUPERIOR -->
        <div class="top-bar"></div>

        <!-- HEADER -->
        <div class="header">

            <div class="logo">
                <img src="/Edutech/public/img/logo.png" alt="EduTech">
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