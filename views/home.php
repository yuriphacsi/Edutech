<style>
* { box-sizing: border-box; }
.carousel-section { width: 100%; margin: 0; padding: 0; margin-top: 70px; }
.carousel-wrapper { position: relative; width: 100%; overflow: hidden; }
.carousel-track { display: flex; transition: transform 0.5s ease; }
.carousel-slide {
    min-width: 100%;
    flex-shrink: 0;
    height: 600px;
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
}
.carousel-btn {
    position: absolute; top: 50%; transform: translateY(-50%);
    background: rgba(255,255,255,0.85); border: none;
    font-size: 2rem; padding: 0.3rem 0.9rem;
    cursor: pointer; border-radius: 6px; z-index: 10;
}
.carousel-btn.prev { left: 12px; }
.carousel-btn.next { right: 12px; }
</style>

<section class="carousel-section">
    <div class="carousel-wrapper" id="carouselWrapper">
        <div class="carousel-track" id="carouselTrack">
            <div class="carousel-slide" style="background-image: url('/Edutech/public/img/oratoria.png');"></div>
            <div class="carousel-slide" style="background-image: url('/Edutech/public/img/nutricion.png');"></div>
            <div class="carousel-slide" style="background-image: url('/Edutech/public/img/gastronomia.png');"></div>
            <div class="carousel-slide" style="background-image: url('/Edutech/public/img/electricidad.png');"></div>
            <div class="carousel-slide" style="background-image: url('/Edutech/public/img/economia.png');"></div>
            <div class="carousel-slide" style="background-image: url('/Edutech/public/img/cirugia_plastica.png');"></div>
            <div class="carousel-slide" style="background-image: url('/Edutech/public/img/anatomia.png');"></div>
            <div class="carousel-slide" style="background-image: url('/Edutech/public/img/agricultura.png');"></div>
            <div class="carousel-slide" style="background-image: url('/Edutech/public/img/administrador_chongos.png');"></div>
            <div class="carousel-slide" style="background-image: url('/Edutech/public/img/administracion_bancaria.png');"></div>
        </div>
        <button class="carousel-btn prev" onclick="carouselMove(-1)">&#8249;</button>
        <button class="carousel-btn next" onclick="carouselMove(1)">&#8250;</button>
    </div>
</section>

<script>
(function() {
    let cur = 0;
    const track = document.getElementById('carouselTrack');
    const wrapper = document.getElementById('carouselWrapper');
    const dots = document.querySelectorAll('.carousel-dots .dot');
    const total = 10;

    window.carouselGoTo = function(i) {
        cur = i;
        track.style.transform = 'translateX(-' + (cur * wrapper.offsetWidth) + 'px)';
        dots.forEach(function(d, j) { d.classList.toggle('active', j === cur); });
    };
    window.carouselMove = function(dir) {
        carouselGoTo((cur + dir + total) % total);
    };
    window.addEventListener('resize', function() { carouselGoTo(cur); });
    setInterval(function() { carouselMove(1); }, 10000);
})();
</script>
<section class="hero">

    <!-- BADGE -->
    <div class="hero-badge">
        ✨ Plataforma educativa moderna • EduTech 2.0
    </div>

    <div class="hero-grid">

        <!-- TEXTO -->
        <div class="hero-text">

            <h1>
                Gestión educativa moderna <br>
                para instituciones inteligentes
            </h1>

            <p>
                EduTech es un sistema SaaS educativo que conecta estudiantes,
                asesores y administradores en una plataforma rápida, escalable y visual.
            </p>

            <div class="hero-actions">
                <a href="/Edutech/login" class="btn-primary">🚀 Empezar ahora</a>
                <a href="#features" class="btn-secondary">Ver características</a>
            </div>

            <!-- MINI STATS -->
            <div class="hero-mini-stats">
                <div>
                    <strong>150+</strong>
                    <span>Usuarios</span>
                </div>
                <div>
                    <strong>35+</strong>
                    <span>Cursos</span>
                </div>
                <div>
                    <strong>99%</strong>
                    <span>Uptime</span>
                </div>
            </div>

        </div>

        <!-- MOCKUP -->
        <div class="hero-image">

            <div class="mockup-glow"></div>

            <img src="/Edutech/public/img/dashboard-preview.png" alt="EduTech Dashboard">

        </div>

    </div>

</section>

<section class="stats">
    <div class="stat">
        <h2>150+</h2>
        <p>Usuarios activos</p>
    </div>

    <div class="stat">
        <h2>35+</h2>
        <p>Cursos disponibles</p>
    </div>

    <div class="stat">
        <h2>3</h2>
        <p>Roles del sistema</p>
    </div>

    <div class="stat">
        <h2>24/7</h2>
        <p>Acceso disponible</p>
    </div>
</section>

<section class="info-section">

    <div class="info-text">
        <h2>Una plataforma diseñada para crecer contigo</h2>

        <p>
            EduTech no es solo un sistema académico. Es una solución completa
            para gestión educativa moderna, con roles, cursos, control de usuarios
            y una arquitectura escalable.
        </p>

        <ul>
            <li>✔ Gestión completa de usuarios</li>
            <li>✔ Control de roles (Admin, Asesor, Alumno)</li>
            <li>✔ Sistema de cursos dinámico</li>
            <li>✔ Arquitectura MVC propia</li>
        </ul>
    </div>

    <div class="info-image">
        <img src="/Edutech/public/img/dashboard-preview.png" alt="Vista EduTech">
    </div>

</section>

<section id="features" class="section features">

    <div class="section-header">
        <h2>⚡ Características del sistema</h2>
        <p>Todo lo que necesitas para gestionar una plataforma educativa moderna</p>
    </div>

    <div class="features-grid">

        <div class="feature-card">
            <div class="icon">🔐</div>
            <h3>Autenticación segura</h3>
            <p>Sistema de login con roles (Admin, Asesor, Alumno) y control de acceso.</p>
        </div>

        <div class="feature-card">
            <div class="icon">📚</div>
            <h3>Gestión de cursos</h3>
            <p>Crea, edita y organiza cursos con estructura escalable MVC.</p>
        </div>

        <div class="feature-card">
            <div class="icon">👨‍🏫</div>
            <h3>Panel de asesores</h3>
            <p>Control de estudiantes y seguimiento académico en tiempo real.</p>
        </div>

        <div class="feature-card">
            <div class="icon">👨‍🎓</div>
            <h3>Panel de estudiantes</h3>
            <p>Acceso a cursos, progreso y contenido personalizado.</p>
        </div>

        <div class="feature-card">
            <div class="icon">⚙️</div>
            <h3>Arquitectura MVC</h3>
            <p>Estructura limpia, escalable y mantenible desde cero.</p>
        </div>

        <div class="feature-card">
            <div class="icon">🚀</div>
            <h3>Alto rendimiento</h3>
            <p>Optimizado para crecer sin perder velocidad ni organización.</p>
        </div>

    </div>

</section>

<section id="mission-vision" class="mv-section">

    <div class="mv-header">
        <h2>Misión y Visión</h2>
        <p>La base de lo que construimos en EduTech</p>
    </div>

    <!-- TABS -->
    <div class="mv-tabs">
        <button class="tab active" onclick="showMV('mision')">🎯 Misión</button>
        <button class="tab" onclick="showMV('vision')">🌍 Visión</button>
    </div>

    <!-- CONTENT -->
    <div class="mv-container">

        <div id="mision" class="mv-box active">

            <div class="mv-card saas-card">
                <h3>🎯 Misión</h3>
                <p>
                    Brindar una plataforma educativa digital que simplifique la gestión de estudiantes,
                    cursos y asesores, ofreciendo una experiencia moderna, accesible y eficiente basada en tecnología web escalable.
                </p>

                <div class="mv-tags">
                    <span>Educación</span>
                    <span>Tecnología</span>
                    <span>Accesibilidad</span>
                </div>
            </div>

        </div>

        <div id="vision" class="mv-box">

            <div class="mv-card saas-card">
                <h3>🌍 Visión</h3>
                <p>
                    Ser una plataforma educativa líder en innovación digital, transformando la educación tradicional
                    hacia sistemas inteligentes, conectados y centrados en el estudiante.
                </p>

                <div class="mv-tags">
                    <span>Innovación</span>
                    <span>Escalabilidad</span>
                    <span>Futuro</span>
                </div>
            </div>

        </div>

    </div>

</section>

<section class="benefits">

    <div class="benefits-header">
        <h2>Todo lo que necesitas en un solo lugar</h2>
        <p>Una plataforma educativa moderna, pensada para escalar y simplificar la gestión académica</p>
    </div>

    <div class="benefits-grid">

        <div class="benefit-card">
            <div class="icon">🎓</div>
            <h3>Aprendizaje organizado</h3>
            <p>Gestiona cursos, módulos y progreso de estudiantes fácilmente desde un solo panel centralizado.</p>
        </div>

        <div class="benefit-card">
            <div class="icon">👨‍🏫</div>
            <h3>Control de asesores</h3>
            <p>Asigna, gestiona y monitorea asesores según cursos, rendimiento y carga académica.</p>
        </div>

        <div class="benefit-card">
            <div class="icon">⚡</div>
            <h3>Sistema rápido</h3>
            <p>Arquitectura MVC optimizada para rendimiento, escalabilidad y crecimiento futuro.</p>
        </div>

    </div>

</section>

<section class="showcase">

    <div class="showcase-container">

        <!-- TEXTO -->
        <div class="showcase-text">

            <span class="badge">🚀 Dashboard en tiempo real</span>

            <h2>
                Panel administrativo completo y escalable
            </h2>

            <p>
                Administra usuarios, cursos, asesores y roles desde un dashboard moderno,
                diseñado con arquitectura MVC y pensado para crecer con tu institución.
            </p>

            <ul class="showcase-list">
                <li>✔ Gestión centralizada de usuarios</li>
                <li>✔ Control de roles y permisos</li>
                <li>✔ Panel de cursos dinámico</li>
                <li>✔ Arquitectura lista para escalar</li>
            </ul>

            <a href="/Edutech/login" class="btn-primary">Ver panel</a>

        </div>

        <!-- IMAGEN -->
        <div class="showcase-image">

            <div class="image-glow"></div>

            <img src="/Edutech/public/img/admin-preview.png" alt="Dashboard Admin">

        </div>

    </div>

</section>

<section class="contact">

    <div class="contact-container">

        <!-- TEXTO -->
        <div class="contact-info">

            <span class="badge">📩 Soporte y contacto</span>

            <h2>Hablemos sobre tu institución</h2>

            <p>
                ¿Quieres implementar EduTech en tu colegio, instituto o empresa?
                Escríbenos y te ayudamos a digitalizar tu gestión educativa.
            </p>

            <div class="contact-details">
                <div>📍 Perú - Arequipa</div>
                <div>📧 soporte@edutech.com</div>
                <div>⚡ Respuesta en menos de 24h</div>
            </div>

        </div>

        <!-- FORM -->
        <div class="contact-card">

            <form>

                <input type="text" placeholder="Tu nombre" required>
                <input type="email" placeholder="Tu correo" required>

                <textarea placeholder="Cuéntanos tu proyecto..." rows="5" required></textarea>

                <button type="submit">Enviar mensaje</button>

            </form>

        </div>

    </div>

</section>

<section class="cta">

    <h2>¿Listo para modernizar tu institución?</h2>

    <p>Empieza a usar EduTech hoy mismo.</p>

    <a href="/Edutech/login" class="btn-primary">Acceder al sistema</a>

</section>

<footer class="footer">
    <p>© <?= date('Y') ?> EduTech - Plataforma Educativa. Todos los derechos reservados.</p>
</footer>

<script>
function showMV(type) {

    document.querySelectorAll('.mv-box').forEach(el => {
        el.classList.remove('active');
    });

    document.querySelectorAll('.tab').forEach(el => {
        el.classList.remove('active');
    });

    if (type === 'mision') {
        document.getElementById('mision').classList.add('active');
        document.querySelectorAll('.tab')[0].classList.add('active');
    }

    if (type === 'vision') {
        document.getElementById('vision').classList.add('active');
        document.querySelectorAll('.tab')[1].classList.add('active');
    }
}
</script>