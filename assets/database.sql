-- Crear la base de datos 'cuponerasv' si no existe
CREATE DATABASE IF NOT EXISTS cuponerasv;

-- Cambiar a la base de datos 'cuponerasv'
USE cuponerasv;

-- Tabla Empresas
CREATE TABLE Empresas (
    idEmpresa INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    NIT VARCHAR(20),
    direccion VARCHAR(255),
    telefono VARCHAR(20),
    correo VARCHAR(100),
    usuario VARCHAR(50),
    contrasena VARCHAR(50),
    aprobada BOOLEAN,
    comision DECIMAL(5,2)
);

-- Tabla Ofertas
CREATE TABLE Ofertas (
    idOferta INT AUTO_INCREMENT PRIMARY KEY,
    idEmpresa INT,
    FOREIGN KEY (idEmpresa) REFERENCES Empresas(idEmpresa),
    titulo VARCHAR(255),
    precio_regular DECIMAL(10,2),
    precio_oferta DECIMAL(10,2),
    fecha_inicio DATE,
    fecha_fin DATE,
    fecha_limite_canje DATE,
    cantidad_cupones INT,
    descripcion TEXT,
    estado ENUM('disponible', 'no disponible')
);

-- Tabla Clientes
CREATE TABLE Clientes (
    idCliente INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50),
    correo VARCHAR(100),
    contrasena VARCHAR(50),
    nombre VARCHAR(100),
    apellidos VARCHAR(100),
    DUI VARCHAR(20),
    fecha_nacimiento DATE
);

-- Tabla CuponesComprados
CREATE TABLE CuponesComprados (
    idCuponComprado INT AUTO_INCREMENT PRIMARY KEY,
    idCliente INT,
    FOREIGN KEY (idCliente) REFERENCES Clientes(idCliente),
    idOferta INT,
    FOREIGN KEY (idOferta) REFERENCES Ofertas(idOferta),
    numero_tarjeta VARCHAR(20),
    fecha_vencimiento DATE,
    cvv VARCHAR(10),
    fecha_compra DATE,
    codigo_cupon VARCHAR(20) UNIQUE
);
