CREATE DATABASE `JAGGERBEATS`;
USE `JAGGERBEATS`;
CREATE TABLE `clientes` (
    `fechaDeCreacion` DATE NOT NULL,
    `codigoConteo` INT NULL AUTO_INCREMENT PRIMARY KEY,
    `viable` BOOLEAN NULL DEFAULT TRUE,
    `nombre` VARCHAR(50) NOT NULL,
    `correo` VARCHAR(50) NULL,
    `celular` VARCHAR(50) NULL,
    `medioPublicitario` VARCHAR(50) NOT NULL,
    `zonaBusqueda` VARCHAR(50) NULL,
    `proyectoDeInteres` VARCHAR(50) NULL,
    `gestionDesdeSalaDeVentas` BOOLEAN NULL DEFAULT FALSE,
    `habeasData` BOOLEAN NULL DEFAULT FALSE,
    `fechaDeContacto` DATE NULL,
    `fechaDeContactoEfectivo` DATE NULL,
    `proyectoCalificado` VARCHAR(50) NULL,
    `fechaVisitaAgendada` DATE NULL,
    `fechaVisitaEfectiva` DATE NULL,
    `estado` VARCHAR(20) NULL,
    `fechaModificacionEstado` DATE NULL,
    `asignadoA` VARCHAR(50) NULL
) ENGINE = InnoDB CHARSET = utf8 COLLATE utf8_unicode_ci;
CREATE TABLE `proyectos`(
    `codigoConteo` INT NULL AUTO_INCREMENT PRIMARY KEY,
    `nombreProyecto` VARCHAR(50) NOT NULL,
    `mensajeWhatsApp` VARCHAR(50) NOT NULL,
    `mensajeCorreo` VARCHAR(50) NOT NULL
) ENGINE = InnoDB CHARSET = utf8 COLLATE utf8_unicode_ci;