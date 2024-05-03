CREATE DATABASE cis;

USE cis;

CREATE TABLE
    usuario (
        id INT NOT NULL AUTO_INCREMENT,
        clave VARCHAR(200) NOT NULL,
        usuario VARCHAR(50) NOT NULL,
        rol VARCHAR(10) NOT NULL,
        email VARCHAR(100) NOT NULL,
        PRIMARY KEY (id)
    );

INSERT INTO
    usuario (nombres, apellidos, clave, usuario, rol)
VALUES
    (
        "Willian Ernesto",
        "Arévalo Rodríguez",
        "123",
        "admin",
        "admin"
    );

INSERT INTO
    usuario (nombres, apellidos, clave, usuario, rol)
VALUES
    (
        "Willian Ernesto",
        "Arévalo Rodríguez",
        "123",
        "becado",
        "becado"
    );

CREATE TABLE
    comunidad (
        id INT NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(200) NOT NULL,
        PRIMARY KEY (id)
    );

CREATE TABLE
    proyecto (
        id INT NOT NULL AUTO_INCREMENT,
        nombre_proyecto VARCHAR(100) NOT NULL,
        id_comunidad INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (id_comunidad) REFERENCES comunidad (id)
    );

CREATE TABLE
    reporte_mensual (
        id INT NOT NULL AUTO_INCREMENT,
        id_proyecto INT NOT NULL,
        mes VARCHAR(10) NOT NULL,
        tema VARCHAR(100)NOT NULL,
        numero_participantes INT NOT NULL,
        descripcion TEXT NOT NULL,
        obstaculos TEXT NOT NULL,
        enviado_por VARCHAR(100) NOT NULL,
        fecha DATE,
        PRIMARY KEY (id),
        FOREIGN KEY (id_proyecto) REFERENCES proyecto (id)
    );

CREATE TABLE
    fotografia_reporte (
        id INT NOT NULL AUTO_INCREMENT,
        id_reporte INT NOT NULL,
        imagen VARCHAR(500) NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (id_reporte) REFERENCES reporte_mensual (id) ON DELETE CASCADE
    );
    

CREATE TABLE
    becado (
        id INT NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(150) NOT NULL,
        foto VARCHAR(50),
        id_comunidad INT NOT NULL,
        institucion VARCHAR(100) NOT NULL,
        nivel_academico VARCHAR(50) NOT NULL,
        carrera VARCHAR(100),
        nivel_estudio VARCHAR(20) NOT NULL,
        id_proyecto INT,
        id_usuario INT,
        PRIMARY KEY (id),
        FOREIGN KEY (id_comunidad) REFERENCES comunidad (id),
        FOREIGN KEY (id_proyecto) REFERENCES proyecto (id),
        FOREIGN KEY (id_usuario) REFERENCES usuario (id)
    );









