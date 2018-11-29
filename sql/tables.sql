CREATE TABLE `Taller` (
    `TallerID` int  NOT NULL ,
    `Nombre` VARCHAR(255)  NOT NULL ,
    `Fecha` DATE  NOT NULL ,
    `Descripcion` TEXT  NOT NULL ,
    `Foto` BLOB  NOT NULL ,
    `Disponibilidad` BOOLEAN  NOT NULL ,
    `Capacidad` int  NOT NULL ,
    `Precio` int  NOT NULL ,
    PRIMARY KEY (
        `TallerID`
    )
);

CREATE TABLE `Inscrito` (
    `Correo` VARCHAR(255)  NOT NULL ,
    `Nombre` VARCHAR(255)  NOT NULL ,
    `Telefono` int  NOT NULL ,
    PRIMARY KEY (
        `Correo`
    )
);

CREATE TABLE `Taller_Inscrito` (
    `TallerID` int  NOT NULL ,
    `Correo` VARCHAR(255)  NOT NULL ,
    `FechaInscripcion` DATE  NOT NULL ,
    PRIMARY KEY (
        `TallerID`,`Correo`
    )
);

ALTER TABLE `Taller_Inscrito` ADD CONSTRAINT `fk_Taller_Inscrito_TallerID` FOREIGN KEY(`TallerID`)
REFERENCES `Taller` (`TallerID`);

ALTER TABLE `Taller_Inscrito` ADD CONSTRAINT `fk_Taller_Inscrito_Correo` FOREIGN KEY(`Correo`)
REFERENCES `Inscrito` (`Correo`);

