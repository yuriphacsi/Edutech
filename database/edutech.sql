CREATE DATABASE IF NOT EXISTS edutech
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE edutech;

CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(255),
    estado TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    id_rol INT NOT NULL,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    correo VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    foto_perfil VARCHAR(255) DEFAULT NULL,
    telefono VARCHAR(20) DEFAULT NULL,
    estado TINYINT(1) DEFAULT 1,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_usuario_rol
        FOREIGN KEY (id_rol)
        REFERENCES roles(id_rol)
        ON DELETE RESTRICT
);

CREATE TABLE alumnos (
    id_alumno INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL UNIQUE,
    codigo_estudiante VARCHAR(50),
    institucion VARCHAR(150),
    carrera VARCHAR(150),
    ciclo VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_alumno_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id_usuario)
        ON DELETE CASCADE
);

CREATE TABLE asesores (
    id_asesor INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL UNIQUE,
    especialidad VARCHAR(150),
    biografia TEXT,
    experiencia_anios INT DEFAULT 0,
    linkedin VARCHAR(255),
    estado_verificacion TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_asesor_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id_usuario)
        ON DELETE CASCADE
);

CREATE TABLE cursos (
    id_curso INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    nivel ENUM('Basico','Intermedio','Avanzado') DEFAULT 'Basico',
    imagen VARCHAR(255),
    estado TINYINT(1) DEFAULT 1,
    id_asesor INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    cupo_maximo INT NOT NULL DEFAULT 30,
    CONSTRAINT fk_curso_asesor
        FOREIGN KEY (id_asesor)
        REFERENCES asesores(id_asesor)
        ON DELETE SET NULL
);

CREATE TABLE asesor_curso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_asesor INT NOT NULL,
    id_curso INT NOT NULL,
    CONSTRAINT fk_ac_asesor
        FOREIGN KEY (id_asesor)
        REFERENCES asesores(id_asesor)
        ON DELETE CASCADE,
    CONSTRAINT fk_ac_curso
        FOREIGN KEY (id_curso)
        REFERENCES cursos(id_curso)
        ON DELETE CASCADE,
    UNIQUE KEY unique_asesor_curso (id_asesor, id_curso)
);

CREATE TABLE horarios (
    id_horario INT AUTO_INCREMENT PRIMARY KEY,
    id_asesor INT NOT NULL,
    dia_semana ENUM('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo') NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    estado TINYINT(1) DEFAULT 1,
    CONSTRAINT fk_horario_asesor
        FOREIGN KEY (id_asesor)
        REFERENCES asesores(id_asesor)
        ON DELETE CASCADE
);

CREATE TABLE asesorias (
    id_asesoria INT AUTO_INCREMENT PRIMARY KEY,
    id_alumno INT NOT NULL,
    id_asesor INT NOT NULL,
    id_curso INT NOT NULL,
    fecha DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    estado ENUM('Pendiente', 'Confirmada', 'Finalizada', 'Cancelada') DEFAULT 'Pendiente',
    observaciones TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_asesoria_alumno FOREIGN KEY (id_alumno) REFERENCES alumnos(id_alumno),
    CONSTRAINT fk_asesoria_asesor FOREIGN KEY (id_asesor) REFERENCES asesores(id_asesor),
    CONSTRAINT fk_asesoria_curso FOREIGN KEY (id_curso) REFERENCES cursos(id_curso)
);

CREATE TABLE videoconferencias (
    id_videoconferencia INT AUTO_INCREMENT PRIMARY KEY,
    id_asesoria INT NOT NULL,
    plataforma ENUM('Google Meet', 'Zoom', 'Microsoft Teams') DEFAULT 'Google Meet',
    enlace VARCHAR(500) NOT NULL,
    codigo_sala VARCHAR(100),
    estado ENUM('Activa', 'Finalizada') DEFAULT 'Activa',
    CONSTRAINT fk_video_asesoria FOREIGN KEY (id_asesoria) REFERENCES asesorias(id_asesoria) ON DELETE CASCADE
);

CREATE TABLE calificaciones (
    id_calificacion INT AUTO_INCREMENT PRIMARY KEY,
    id_asesoria INT NOT NULL,
    id_alumno INT NOT NULL,
    id_asesor INT NOT NULL,
    puntuacion DECIMAL(3,1) NOT NULL,
    comentario TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_calificacion_asesoria FOREIGN KEY (id_asesoria) REFERENCES asesorias(id_asesoria),
    CONSTRAINT fk_calificacion_alumno FOREIGN KEY (id_alumno) REFERENCES alumnos(id_alumno),
    CONSTRAINT fk_calificacion_asesor FOREIGN KEY (id_asesor) REFERENCES asesores(id_asesor),
    CHECK (puntuacion >= 0.5 AND puntuacion <= 5.0)
);

CREATE TABLE notificaciones (
    id_notificacion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    mensaje TEXT NOT NULL,
    leida TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_notificacion_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
);

CREATE TABLE permisos (
    id_permiso INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE rol_permisos (
    id_rol INT NOT NULL,
    id_permiso INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_rp_rol FOREIGN KEY (id_rol) REFERENCES roles(id_rol) ON DELETE CASCADE,
    CONSTRAINT fk_rp_permiso FOREIGN KEY (id_permiso) REFERENCES permisos(id_permiso) ON DELETE CASCADE,
    PRIMARY KEY (id_rol, id_permiso)
);

CREATE TABLE inscripciones (
    id_inscripcion INT AUTO_INCREMENT PRIMARY KEY,
    id_curso INT NOT NULL,
    id_usuario INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_insc_curso FOREIGN KEY (id_curso) REFERENCES cursos(id_curso) ON DELETE CASCADE,
    CONSTRAINT fk_insc_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
);

CREATE TABLE logs_usuarios (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    accion VARCHAR(100) NOT NULL,
    data TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================================================
-- AGREGADO: NUEVA TABLA DE PAGOS (EDUPAY)
-- =========================================================
CREATE TABLE pagos (
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,               -- Alumno comprador (usuarios.id_usuario)
    id_curso INT NOT NULL,                 -- Curso comprado (cursos.id_curso)
    monto DECIMAL(10,2) NOT NULL,
    metodo_pago VARCHAR(50) NOT NULL,      -- 'Tarjeta', 'Transferencia', etc.
    referencia VARCHAR(100) NULL,          -- ID o código de transacción bancaria
    estado ENUM('Pendiente', 'Aprobado', 'Rechazado') DEFAULT 'Pendiente',
    fecha_pago TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pago_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    CONSTRAINT fk_pago_curso FOREIGN KEY (id_curso) REFERENCES cursos(id_curso) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- INSERTS DE CONFIGURACIÓN INICIAL
-- =========================================================
INSERT INTO roles (nombre, descripcion, estado) VALUES 
('Administrador', 'Control total del sistema', 1),
('Asesor', 'Brinda asesorías académicas', 1),
('Alumno', 'Solicita asesorías académicas', 1);

INSERT INTO usuarios (id_usuario, id_rol, nombres, apellidos, correo, password, foto_perfil, telefono, estado, created_at, updated_at, last_login) VALUES 
(1, 1, 'Chistian', 'Dominguez', 'admin@edutech.com', '$2y$10$gVzMZYpAnhrP8l2GIbnH7.rPOdqpIFncTPpEnFzUHm1WQvu7M9mZW', NULL, NULL, 1, NOW(), NOW(), '2026-06-22 15:45:44');

INSERT INTO permisos (id_permiso, nombre) VALUES
(1, 'ver_dashboard'),
(2, 'gestionar_usuarios'),
(3, 'gestionar_cursos'),
(4, 'ver_reportes');

INSERT INTO rol_permisos (id_rol, id_permiso) VALUES
(1, 1), (1, 2), (1, 3), (1, 4),
(2, 1), (2, 3),
(3, 1);

-- =========================================================
-- AGREGADO: AUTOMATIZACIONES Y DISPARADORES DE NEGOCIO
-- =========================================================
DELIMITER //

-- Procedimiento para registrar de forma segura un intento de pago desde PHP
CREATE PROCEDURE sp_registrar_intento_pago(
    IN p_id_usuario INT,
    IN p_id_curso INT,
    IN p_monto DECIMAL(10,2),
    IN p_metodo VARCHAR(50),
    IN p_referencia VARCHAR(100)
)
BEGIN
    INSERT INTO pagos (id_usuario, id_curso, monto, metodo_pago, referencia, estado)
    VALUES (p_id_usuario, p_id_curso, p_monto, p_metodo, p_referencia, 'Pendiente');
    
    INSERT INTO logs_usuarios (id_usuario, accion, data)
    VALUES (p_id_usuario, 'INTENTO_PAGO', CONCAT('Curso ID: ', p_id_curso, ' | Monto: ', p_monto));
END //

-- Trigger para automatizar inscripciones al cambiar el estado del pago
CREATE TRIGGER tg_automatizar_inscripcion_pago
AFTER UPDATE ON pagos
FOR EACH ROW
BEGIN
    -- Si el administrador cambia el estado de 'Pendiente' a 'Aprobado'
    IF OLD.estado = 'Pendiente' AND NEW.estado = 'Aprobado' THEN
        -- Comprobación para evitar duplicados en inscripciones
        IF NOT EXISTS (
            SELECT 1 FROM inscripciones 
            WHERE id_curso = NEW.id_curso AND id_usuario = NEW.id_usuario
        ) THEN
            INSERT INTO inscripciones (id_curso, id_usuario, created_at)
            VALUES (NEW.id_curso, NEW.id_usuario, NOW());
            
            INSERT INTO logs_usuarios (id_usuario, accion, data)
            VALUES (NEW.id_usuario, 'INSCRIPCION_AUTOMATICA_PAGO', CONCAT('Inscrito al curso ID: ', NEW.id_curso, ' mediante pago ID: ', NEW.id_pago));
        END IF;
        
    -- Si el administrador decide rechazar la transacción
    ELSEIF OLD.estado = 'Pendiente' AND NEW.estado = 'Rechazado' THEN
        INSERT INTO logs_usuarios (id_usuario, accion, data)
        VALUES (NEW.id_usuario, 'PAGO_RECHAZADO', CONCAT('Pago ID: ', NEW.id_pago, ' fue rechazado por el administrador.'));
    END IF;
END //

DELIMITER ;
