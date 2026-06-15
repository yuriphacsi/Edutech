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

    ultimo_acceso DATETIME NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_usuario_rol
        FOREIGN KEY (id_rol)
        REFERENCES roles(id_rol)
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

    nivel ENUM(
        'Basico',
        'Intermedio',
        'Avanzado'
    ) DEFAULT 'Basico',

    imagen VARCHAR(255),

    estado TINYINT(1) DEFAULT 1,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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

    UNIQUE KEY unique_asesor_curso (
        id_asesor,
        id_curso
    )
);

CREATE TABLE horarios (
    id_horario INT AUTO_INCREMENT PRIMARY KEY,

    id_asesor INT NOT NULL,

    dia_semana ENUM(
        'Lunes',
        'Martes',
        'Miercoles',
        'Jueves',
        'Viernes',
        'Sabado',
        'Domingo'
    ) NOT NULL,

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

    estado ENUM(
        'Pendiente',
        'Confirmada',
        'Finalizada',
        'Cancelada'
    ) DEFAULT 'Pendiente',

    observaciones TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_asesoria_alumno
        FOREIGN KEY (id_alumno)
        REFERENCES alumnos(id_alumno),

    CONSTRAINT fk_asesoria_asesor
        FOREIGN KEY (id_asesor)
        REFERENCES asesores(id_asesor),

    CONSTRAINT fk_asesoria_curso
        FOREIGN KEY (id_curso)
        REFERENCES cursos(id_curso)
);

CREATE TABLE videoconferencias (
    id_videoconferencia INT AUTO_INCREMENT PRIMARY KEY,

    id_asesoria INT NOT NULL,

    plataforma ENUM(
        'Google Meet',
        'Zoom',
        'Microsoft Teams'
    ) DEFAULT 'Google Meet',

    enlace VARCHAR(500) NOT NULL,

    codigo_sala VARCHAR(100),

    estado ENUM(
        'Activa',
        'Finalizada'
    ) DEFAULT 'Activa',

    CONSTRAINT fk_video_asesoria
        FOREIGN KEY (id_asesoria)
        REFERENCES asesorias(id_asesoria)
        ON DELETE CASCADE
);

CREATE TABLE calificaciones (
    id_calificacion INT AUTO_INCREMENT PRIMARY KEY,

    id_asesoria INT NOT NULL,
    id_alumno INT NOT NULL,
    id_asesor INT NOT NULL,

    puntuacion DECIMAL(3,1) NOT NULL,

    comentario TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_calificacion_asesoria
        FOREIGN KEY (id_asesoria)
        REFERENCES asesorias(id_asesoria),

    CONSTRAINT fk_calificacion_alumno
        FOREIGN KEY (id_alumno)
        REFERENCES alumnos(id_alumno),

    CONSTRAINT fk_calificacion_asesor
        FOREIGN KEY (id_asesor)
        REFERENCES asesores(id_asesor),

    CHECK (puntuacion >= 0.5 AND puntuacion <= 5.0)
);

CREATE TABLE notificaciones (
    id_notificacion INT AUTO_INCREMENT PRIMARY KEY,

    id_usuario INT NOT NULL,

    titulo VARCHAR(150) NOT NULL,
    mensaje TEXT NOT NULL,

    leida TINYINT(1) DEFAULT 0,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_notificacion_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id_usuario)
        ON DELETE CASCADE
);

INSERT INTO roles (nombre, descripcion)
VALUES
('Administrador', 'Control total del sistema'),
('Asesor', 'Brinda asesorias academicas'),
('Alumno', 'Solicita asesorias academicas');