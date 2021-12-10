CREATE DATABASE `jaggerbeats`;
USE `jaggerbeats`;
CREATE TABLE `clientes` (
    `fechaDeCreacion` DATE NOT NULL,
    `codigoConteo` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `cedula` INT(15) NOT NULL UNIQUE KEY,
    `nombres` VARCHAR(30) NOT NULL,
    `apellidos` VARCHAR(30) NOT NULL,
    `correo` VARCHAR(30) NULL,
    `celular` VARCHAR(20) NULL,
    `direccionDeResidencia` VARCHAR(60) NULL,
    `fechaDeNacimiento` DATE NULL,
    `lugarDeNacimiento` VARCHAR(50) NULL,
    `sexo` INT(1) NULL,
    `estatura` INT(5) NULL,
    `etnia` VARCHAR(20) NULL,
    `estadoCivil` VARCHAR(20) NULL,
    `escolaridad` VARCHAR(40) NULL,
    `colegioInstitucion` VARCHAR(40) NULL,
    `estudiaActualmente` BOOLEAN NULL DEFAULT TRUE,
    `universidadInstitucion` VARCHAR(40) NULL,
    `actividadEconomica` VARCHAR(20) NULL,
    `ingresoMensual` INT(8) NULL DEFAULT 0,
    `intereses` VARCHAR(100)
) ENGINE = InnoDB CHARSET = utf8 COLLATE utf8_unicode_ci;
CREATE TABLE `visitas`(
    `fechaDeCreacion` DATE NOT NULL,
    `codigoConteo` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `establecimiento` VARCHAR(20) NOT NULL,
    `tematica` VARCHAR(20) NULL,
    `cedula` INT(15) NOT NULL,
    `consumo` VARCHAR(30) NULL,
    `calificacion` INT(2) NULL DEFAULT 0,
    `horaDeIngreso` TIME NOT NULL,
    `horaDeSalida` TIME NULL
) ENGINE = InnoDB CHARSET = utf8 COLLATE utf8_unicode_ci;
CREATE TABLE `equipo`(
    `codigoConteo` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `cedula` INT(15) NOT NULL UNIQUE KEY,
    `nombres` VARCHAR(30) NOT NULL,
    `apellidos` VARCHAR(30) NOT NULL,
    `correo` VARCHAR(30) NULL,
    `celular` VARCHAR(20) NULL,
    `fechaDeNacimiento` DATE NULL,
    `permisos` VARCHAR(20) NULL,
    `usuario` VARCHAR(20) NOT NULL,
    `clave` VARCHAR(20) NULL
) ENGINE = InnoDB CHARSET = utf8 COLLATE utf8_unicode_ci;