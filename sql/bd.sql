
CREATE DATABASE IF NOT EXISTS pof;
USE pof;

CREATE TABLE IF NOT EXISTS cliente
(
    id_cliente INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    apellido VARCHAR(255) NOT NULL,
    correo VARCHAR(255) NOT NULL,
    password LONGTEXT NOT NULL,
    RFC VARCHAR(13) DEFAULT '',
    telefono VARCHAR(8) NOT NULL,
    PRIMARY KEY (id_cliente)
);

CREATE TABLE IF NOT EXISTS solicitudes_restablecimiento
(
    clave TEXT(900) NOT NULL,
    id_cliente INT NOT NULL, 
    PRIMARY KEY (id_cliente)
);

CREATE TABLE IF NOT EXISTS direccion
(
    id INT NOT NULL AUTO_INCREMENT,
    cp VARCHAR(255) NOT NULL,
    calle LONGTEXT NOT NULL,
    numero VARCHAR(255) NOT NULL,
    estado LONGTEXT NOT NULL,
    municipio LONGTEXT NOT NULL,
    colonia LONGTEXT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS contacto
(
    id INT NOT NULL AUTO_INCREMENT,
    nombre LONGTEXT NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    email LONGTEXT DEFAULT '',
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS envio
(
    id INT NOT NULL AUTO_INCREMENT,
    id_cliente INT NOT NULL,
    origen INT NOT NULL,
    remitente INT NOT NULL,
    destino INT NOT NULL,
    destinatario INT NOT NULL,
    size LONGTEXT NOT NULL,
    peso LONGTEXT NOT NULL,
    recoleccion INT NOT NULL,
    costo LONGTEXT NOT NULL,
    fecha_llegada LONGTEXT NOT NULL,
    estado INT NOT NULL,
    creacion DATETIME DEFAULT NOW(),
    actualizacion DATETIME DEFAULT NOW(),
    PRIMARY KEY(id),
    FOREIGN KEY(id_cliente) REFERENCES cliente(id_cliente),
    FOREIGN KEY(origen) REFERENCES direccion(id),
    FOREIGN KEY(destino) REFERENCES direccion(id),
    FOREIGN KEY(remitente) REFERENCES direccion(id),
    FOREIGN KEY(destinatario) REFERENCES direccion(id)
);