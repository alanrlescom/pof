
CREATE DATABASE IF NOT EXISTS pof;
USE pof;

CREATE TABLE IF NOT EXISTS cliente
(
    id_cliente INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    apellido VARCHAR(255) NOT NULL,
    correo VARCHAR(255) NOT NULL,
    password VARCHAR(30) NOT NULL,
    RFC VARCHAR(13) DEFAULT '',
    telefono VARCHAR(8) NOT NULL,
    PRIMARY KEY (id_cliente)
);

CREATE TABLE IF NOT EXISTS solicitudes_reestablecimiento
(
    clave TEXT(900) NOT NULL,
    id_cliente INT NOT NULL, 
    PRIMARY KEY (id_cliente)
);