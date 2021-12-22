
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
    comentarios LONGTEXT NOT NULL,
    sucursal_origen INT,
    sucursal_destino INT,
    PRIMARY KEY(id),
    FOREIGN KEY(id_cliente) REFERENCES cliente(id_cliente),
    FOREIGN KEY(origen) REFERENCES direccion(id),
    FOREIGN KEY(destino) REFERENCES direccion(id),
    FOREIGN KEY(remitente) REFERENCES direccion(id),
    FOREIGN KEY(destinatario) REFERENCES direccion(id)
);

DROP TABLE sucursal;
CREATE TABLE IF NOT EXISTS sucursal
(
    id INT NOT NULL AUTO_INCREMENT,
    nombre LONGTEXT NOT NULL,
    lat VARCHAR(255) NOT NULL,
    lon VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
);

INSERT INTO sucursal(nombre, lat, lon) VALUES ('Benito Juarez','19.372036676365553','-99.1578376304078');
INSERT INTO sucursal(nombre, lat, lon) VALUES ('Cuauhtemoc','19.441455713368395','-99.15187587436');
INSERT INTO sucursal(nombre, lat, lon) VALUES ('Venustiano carranza','19.419223289461193','-99.1132507855663');
INSERT INTO sucursal(nombre, lat, lon) VALUES ('Gustavo A. Madero',' 19.482440327457457','-99.11316841627381');
INSERT INTO sucursal(nombre, lat, lon) VALUES ('Azcapotzalco','19.484083683020007','-99.18444944948669');
INSERT INTO sucursal(nombre, lat, lon) VALUES ('Coyoacán','19.350252379523628','-99.16225854066789');
INSERT INTO sucursal(nombre, lat, lon) VALUES ('Tlalpan','19.28786327017085','-99.1667960394867');
INSERT INTO sucursal(nombre, lat, lon) VALUES ('Miguel Hidalgo','19.407295845131067','-99.1909409642604');
INSERT INTO sucursal(nombre, lat, lon) VALUES ('Xochimilco','19.26339363095278','-99.10483238892205');
INSERT INTO sucursal(nombre, lat, lon) VALUES ('Milpa Alta','19.19130793608937','-99.02326058036691');
INSERT INTO sucursal(nombre, lat, lon) VALUES ('Cuajimalpa','19.35730781137589','-99.29978741076167');
INSERT INTO sucursal(nombre, lat, lon) VALUES ('álvaro Obregón','19.38951018842032','-99.19561277574837');
INSERT INTO sucursal(nombre, lat, lon) VALUES ('Iztapalapa','19.35879228593377','-99.09269190467073');
INSERT INTO sucursal(nombre, lat, lon) VALUES ('Tláhuac','19.27032868144917','-99.00412229832875');
INSERT INTO sucursal(nombre, lat, lon) VALUES ('Iztacalco','19.395596243999297','-99.09667162505788');
INSERT INTO sucursal(nombre, lat, lon) VALUES ('Magdalena Contreras','19.304694729553745','-99.2415455211505');
