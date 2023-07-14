SET GLOBAL innodb_file_format=Barracuda; 
SET GLOBAL innodb_file_per_table=ON; 
ALTER TABLE proyecto
    ENGINE=InnoDB
    ROW_FORMAT=COMPRESSED 
    KEY_BLOCK_SIZE=8;

ALTER TABLE `estadoproyecto`
	ENGINE=InnoDB;
	
ALTER TABLE `estadointegrante`
	ENGINE=InnoDB;
	
ALTER TABLE `tipoacreditacion`
	ENGINE=InnoDB;



	INSERT INTO cdt_function VALUES (NULL, 'Listar proyectos');
	INSERT INTO cdt_function VALUES (NULL, 'Agregar proyecto');
	INSERT INTO cdt_function VALUES (NULL, 'Modificar proyecto');
	INSERT INTO cdt_function VALUES (NULL, 'Eliminar proyecto');
	INSERT INTO cdt_function VALUES (NULL, 'Ver proyecto');
	
	INSERT INTO cdt_menuoption VALUES (NULL, 'Proyectos', 'doAction?action=list_proyectos', 54, 2, 9, 'tiposTitulo', '');
	
	INSERT INTO cdt_action_function VALUES (NULL, 54, 'list_proyectos');
	INSERT INTO cdt_action_function VALUES (NULL, 55, 'add_proyecto_init');
	INSERT INTO cdt_action_function VALUES (NULL, 55, 'add_proyecto');
	INSERT INTO cdt_action_function VALUES (NULL, 56, 'update_proyecto_init');
	INSERT INTO cdt_action_function VALUES (NULL, 56, 'update_proyecto');
	INSERT INTO cdt_action_function VALUES (NULL, 57, 'delete_proyecto');
	INSERT INTO cdt_action_function VALUES (NULL, 58, 'view_proyecto');
	
	
	INSERT INTO `cargo` (`cd_cargo`, `ds_cargo`, `cd_cargosipi`, `nu_orden`) VALUES (12, 'Adscripto', 0, 12);

ALTER TABLE `integrante`
	ADD COLUMN `oid` INT(11) NOT NULL AUTO_INCREMENT FIRST,
	DROP PRIMARY KEY,
	ADD PRIMARY KEY (`oid`);

ALTER TABLE `integrante`
	ADD UNIQUE INDEX `cd_docente_cd_proyecto` (`cd_docente`, `cd_proyecto`);


ALTER TABLE `integrante`
	ADD COLUMN `ds_mail` varchar(255) NULL,
	ADD COLUMN `cd_categoria` INT(11) NULL,
	ADD COLUMN `cd_deddoc` INT(11) NULL DEFAULT NULL,
	ADD COLUMN `cd_cargo` INT(11) NULL DEFAULT NULL,
	ADD COLUMN `dt_cargo` date NULL DEFAULT NULL,
	ADD COLUMN `cd_facultad` INT(11) NULL DEFAULT NULL,
	ADD COLUMN `cd_unidad` INT(11) NULL DEFAULT NULL,
	ADD COLUMN `cd_carrerainv` INT(11) NULL DEFAULT NULL,
	ADD COLUMN `dt_carrerainv` date NULL DEFAULT NULL,
	ADD COLUMN `cd_organismo` INT(11) NULL DEFAULT NULL,
	ADD COLUMN `cd_universidad` INT(11) NULL DEFAULT NULL,
	ADD COLUMN `ds_orgbeca` varchar(255) NULL,
	ADD COLUMN `ds_tipobeca` varchar(255) NULL,
	ADD COLUMN `dt_beca` date NULL DEFAULT NULL,
	ADD COLUMN `cd_titulo` INT(11) NULL DEFAULT NULL,
	ADD COLUMN `cd_titulopost` INT(11) NULL DEFAULT NULL,
	ADD COLUMN `bl_estudiante` BINARY(1) NULL,
	ADD COLUMN `nu_materias` INT(11) NULL DEFAULT NULL;
	
ALTER TABLE `integrante`
	ADD CONSTRAINT `FK_integrante_categoria` FOREIGN KEY (`cd_categoria`) REFERENCES `categoria` (`cd_categoria`),
	ADD CONSTRAINT `FK_integrante_deddoc` FOREIGN KEY (`cd_deddoc`) REFERENCES `deddoc` (`cd_deddoc`),
	ADD CONSTRAINT `FK_integrante_cargo` FOREIGN KEY (`cd_cargo`) REFERENCES `cargo` (`cd_cargo`),
	ADD CONSTRAINT `FK_integrante_facultad` FOREIGN KEY (`cd_facultad`) REFERENCES `facultad` (`cd_facultad`),
	ADD CONSTRAINT `FK_integrante_unidad` FOREIGN KEY (`cd_unidad`) REFERENCES `unidad` (`cd_unidad`),
	ADD CONSTRAINT `FK_integrante_carrerainv` FOREIGN KEY (`cd_carrerainv`) REFERENCES `carrerainv` (`cd_carrerainv`),
	ADD CONSTRAINT `FK_integrante_organismo` FOREIGN KEY (`cd_organismo`) REFERENCES `organismo` (`cd_organismo`),
	ADD CONSTRAINT `FK_integrante_universidad` FOREIGN KEY (`cd_universidad`) REFERENCES `universidad` (`cd_universidad`),
	ADD CONSTRAINT `FK_integrante_titulo` FOREIGN KEY (`cd_titulo`) REFERENCES `titulo` (`cd_titulo`),
	ADD CONSTRAINT `FK_integrante_titulo_2` FOREIGN KEY (`cd_titulopost`) REFERENCES `titulo` (`cd_titulo`);
	
	
CREATE TABLE `cyt_integrante_estado` (
	`oid` BIGINT(20) NOT NULL AUTO_INCREMENT,
	`integrante_oid` BIGINT(20) NULL DEFAULT NULL,
	`estado_oid` BIGINT(20) NULL DEFAULT NULL,
	`tipoInvestigador_oid` BIGINT(20) NULL DEFAULT NULL,
	`dt_alta` DATE NULL DEFAULT NULL,
	`dt_baja` DATE NULL DEFAULT NULL,
	`dt_cambio` DATE NULL DEFAULT NULL,
	 nu_horasinv INT(11) NULL DEFAULT NULL,
	 `ds_consecuencias` TEXT NULL,
	 `ds_motivos` TEXT NULL,
	 `ds_reduccionHS` TEXT NULL,
	`fechaDesde` DATETIME NULL DEFAULT NULL,
	`fechaHasta` DATETIME NULL DEFAULT NULL,
	`motivo` TEXT NULL,
	`user_oid` INT(11) NOT NULL,
	`fechaUltModificacion` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`oid`),
	INDEX `integrante_oid` (`integrante_oid`),
	
	INDEX `estado_oid` (`estado_oid`),
	INDEX `user_oid` (`user_oid`),

	CONSTRAINT `cyt_integrante_estado_ibfk_3` FOREIGN KEY (`user_oid`) REFERENCES `cyt_user` (`oid`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=0;

SET FOREIGN_KEY_CHECKS = 0;
UPDATE integrante INNER JOIN docente
ON integrante.cd_docente = docente.cd_docente 
SET integrante.ds_mail = docente.ds_mail, integrante.cd_categoria = docente.cd_categoria, integrante.cd_deddoc = docente.cd_deddoc, integrante.cd_cargo = docente.cd_cargo, 
integrante.dt_cargo = docente.dt_cargo, integrante.cd_facultad = docente.cd_facultad, integrante.cd_unidad = docente.cd_unidad, 
integrante.cd_carrerainv = docente.cd_carrerainv, integrante.cd_organismo = docente.cd_organismo, integrante.cd_universidad = docente.cd_universidad, integrante.dt_beca = docente.dt_beca, 
integrante.cd_titulo = docente.cd_titulo, integrante.cd_titulopost = docente.cd_titulopost, integrante.bl_estudiante = docente.bl_estudiante, 
integrante.nu_materias = docente.nu_materias;
SET FOREIGN_KEY_CHECKS = 1;


UPDATE integrante SET integrante.ds_orgbeca = (SELECT CASE  WHEN beca.cd_beca IS NULL THEN (CASE docente.bl_becario WHEN '1' THEN docente.ds_orgbeca ELSE '' END) ELSE 'UNLP' END
FROM docente LEFT JOIN beca ON docente.cd_docente = beca.cd_docente AND beca.dt_hasta >= '2016-07-01' 
WHERE docente.cd_docente = integrante.cd_docente);

UPDATE integrante SET integrante.ds_tipobeca = (SELECT CASE WHEN beca.cd_beca IS NULL THEN (CASE docente.bl_becario WHEN '1' THEN docente.ds_tipobeca ELSE '' END) ELSE beca.ds_tipobeca END 
FROM docente LEFT JOIN beca ON docente.cd_docente = beca.cd_docente AND beca.dt_hasta >= '2016-07-01' 
WHERE docente.cd_docente = integrante.cd_docente);

INSERT INTO `cyt_user` (`ds_username`, `ds_name`, ds_email, ds_password, ds_ips,facultad_oid)
SELECT CONCAT(UP.nu_precuil,'-',UP.nu_documento,'-',UP.nu_postcuil) as CUIL, UP.ds_apynom, UP.ds_mail, UP.ds_password, '', UP.cd_facultad
FROM usuarioproyecto as UP
WHERE NOT EXISTS (SELECT U.oid FROM cyt_user as U WHERE CONCAT(UP.nu_precuil,'-',UP.nu_documento,'-',UP.nu_postcuil) = U.ds_username) 
AND UP.nu_precuil !=0;


INSERT INTO `cdt_usergroup` (`ds_usergroup`) VALUES ('Admin Proyectos');
INSERT INTO `cdt_usergroup` (`ds_usergroup`) VALUES ('Admin Facultad Proyectos');
INSERT INTO `cdt_usergroup` (`ds_usergroup`) VALUES ('SeCyT Proyectos');
INSERT INTO `cdt_usergroup` (`ds_usergroup`) VALUES ('Director de Proyecto');

UPDATE `cdt_usergroup` SET `ds_usergroup` = 'Director de Unidad' WHERE `cdt_usergroup`.`cd_usergroup` =2;

INSERT INTO `cyt_user_usergroup` (`user_oid`, `usergroup_oid`) VALUES (1, 12);

INSERT INTO `cyt_user_usergroup` (`user_oid`, `usergroup_oid`)
SELECT cyt_user.oid,15 FROM cyt_user
WHERE EXISTS (SELECT usuarioproyecto.cd_usuario FROM usuarioproyecto WHERE CONCAT(usuarioproyecto.nu_precuil,'-',usuarioproyecto.nu_documento,'-',usuarioproyecto.nu_postcuil) = cyt_user.ds_username AND usuarioproyecto.cd_perfil = 3);


INSERT INTO cyt_user_usergroup (user_oid, usergroup_oid)
SELECT user_oid,3 FROM cyt_user_usergroup u1
WHERE u1.usergroup_oid = 15 AND NOT EXISTS (SELECT u2.user_oid FROM cyt_user_usergroup u2
WHERE u2.usergroup_oid = 3 AND u1.user_oid = u2.user_oid);

INSERT INTO cyt_user_usergroup (user_oid, usergroup_oid)
SELECT user_oid,15 FROM cyt_user_usergroup u1
WHERE usergroup_oid in (3, 9, 10, 11, 13) AND NOT EXISTS (SELECT u2.user_oid FROM cyt_user_usergroup u2
WHERE u2.usergroup_oid = 15 AND u1.user_oid = u2.user_oid);

INSERT INTO `cyt_user_usergroup` (`user_oid`, `usergroup_oid`)
SELECT cyt_user.oid,13 FROM cyt_user
WHERE EXISTS (SELECT usuarioproyecto.cd_usuario FROM usuarioproyecto WHERE cyt_user.ds_username like CONCAT('%-',usuarioproyecto.nu_documento,'-%') AND usuarioproyecto.cd_perfil = 9 AND usuarioproyecto.bl_activo=1);

INSERT INTO `cyt_user_usergroup` (`user_oid`, `usergroup_oid`)
SELECT cyt_user.oid,14 FROM cyt_user
WHERE EXISTS (SELECT usuarioproyecto.cd_usuario FROM usuarioproyecto WHERE CONCAT(usuarioproyecto.nu_precuil,'-',usuarioproyecto.nu_documento,'-',usuarioproyecto.nu_postcuil) = cyt_user.ds_username AND usuarioproyecto.cd_perfil = 8 AND usuarioproyecto.bl_activo=1)

ALTER TABLE `docente`
	ALTER `nu_horasdoc1c` DROP DEFAULT,
	ALTER `nu_horasdoc2c` DROP DEFAULT,
	ALTER `nu_semanasdoc1c` DROP DEFAULT,
	ALTER `nu_semanasdoc2c` DROP DEFAULT;
ALTER TABLE `docente`
	CHANGE COLUMN `nu_horasdoc1c` `nu_horasdoc1c` INT(11) NULL AFTER `cd_deddoc`,
	CHANGE COLUMN `nu_horasdoc2c` `nu_horasdoc2c` INT(11) NULL AFTER `nu_horasdoc1c`,
	CHANGE COLUMN `nu_semanasdoc1c` `nu_semanasdoc1c` INT(11) NULL AFTER `nu_horasdoc2c`,
	CHANGE COLUMN `nu_semanasdoc2c` `nu_semanasdoc2c` INT(11) NULL AFTER `nu_semanasdoc1c`;
ALTER TABLE `docente`
	ALTER `nu_dedinv` DROP DEFAULT,
	ALTER `cd_carrerainv` DROP DEFAULT,
	ALTER `cd_organismo` DROP DEFAULT;
ALTER TABLE `docente`
	CHANGE COLUMN `cd_categoria` `cd_categoria` INT(11) NULL DEFAULT '1' AFTER `ds_mail`,
	CHANGE COLUMN `nu_dedinv` `nu_dedinv` INT(11) NULL AFTER `cd_categoria`,
	CHANGE COLUMN `cd_carrerainv` `cd_carrerainv` INT(11) NULL AFTER `nu_dedinv`,
	CHANGE COLUMN `cd_organismo` `cd_organismo` INT(11) NULL AFTER `cd_carrerainv`,
	CHANGE COLUMN `cd_facultad` `cd_facultad` INT(11) NULL DEFAULT '574' AFTER `nu_semanasspu`,
	CHANGE COLUMN `cd_cargo` `cd_cargo` INT(11) NULL DEFAULT '6' AFTER `cd_facultad`,
	CHANGE COLUMN `cd_deddoc` `cd_deddoc` INT(11) NULL DEFAULT '4' AFTER `cd_cargo`,
	CHANGE COLUMN `cd_universidad` `cd_universidad` INT(11) NULL DEFAULT '11' AFTER `nu_semanasdoc2c`;


############## Primero se crean los estados de integrantes Directores ##########################################
INSERT INTO cyt_integrante_estado (integrante_oid, estado_oid, tipoInvestigador_oid, dt_alta, dt_baja, dt_cambio, nu_horasinv, ds_consecuencias, ds_motivos, ds_reduccionHS, fechaDesde, user_oid, fechaUltModificacion, motivo)
SELECT oid, cd_estado, cd_tipoinvestigador, dt_alta, dt_baja, dt_cambioHS, nu_horasinv, ds_consecuencias, ds_motivos, ds_reduccionHS, dt_alta, 1, dt_alta, ''
FROM integrante
WHERE cd_tipoinvestigador = 1;



####se crea una tabla auxiliar "aux_mov_altas_bajas" para separar mejor los campos, se separan usando excel para separar columnas####
CREATE TABLE `aux_mov_altas_bajas` (
	`usuario_oid` BIGINT(20) NULL DEFAULT NULL,
	`estado_oid` BIGINT(20) NULL DEFAULT NULL,
	`fechaHora` VARCHAR(20) DEFAULT NULL,
	 documento INT(11) NULL DEFAULT NULL,
	 proyecto_oid VARCHAR(20) NULL DEFAULT NULL, 
	`ds_consecuencia` text DEFAULT NULL
	
	
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;

############## Después se crean los estados "altas creadas" ##########################################
INSERT INTO `cyt_integrante_estado` (`integrante_oid`, `estado_oid`, `tipoInvestigador_oid`, `dt_alta`, `dt_baja`, `dt_cambio`, `nu_horasinv`, 
`ds_consecuencias`, `ds_motivos`, `ds_reduccionHS`, `fechaDesde`, `fechaHasta`, `motivo`, `user_oid`, `fechaUltModificacion`)
SELECT I.oid, AUX.estado_oid , I.cd_tipoinvestigador, I.dt_alta, I.dt_baja, I.dt_cambioHS, I.nu_horasinv, I.ds_consecuencias, I.ds_motivos, 
I.ds_reduccionHS, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)),
null, AUX.ds_consecuencia, U.oid, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2))
FROM `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN integrante I ON AUX.proyecto_oid = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
WHERE AUX.estado_oid = 1;

############## Controlo si hay mas de un integrante con fechaHasta en nulo ##########################################
SELECT * FROM cyt_integrante_estado  
WHERE EXISTS (SELECT U2.integrante_oid FROM cyt_integrante_estado U2
WHERE cyt_integrante_estado.integrante_oid = U2.integrante_oid AND fechaHasta is NULL
group by U2.integrante_oid
having count(U2.integrante_oid)>1 );

############## Elimino con unique los duplicados ##########################################
ALTER IGNORE TABLE `cyt_integrante_estado`
ADD UNIQUE INDEX `integrante_oid_estado_oid` (`integrante_oid`, `estado_oid`, fechaDesde);

############## eliminó la restriccion de unique ##########################################
ALTER TABLE `cyt_integrante_estado`
	DROP INDEX `integrante_oid_estado_oid`;

############## se actualizan las fechas hasta de los estados "creadas" con las fechas de las altas recibidas #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 1 AND AUX.estado_oid = 2;

############## Después se crean los estados "altas recibidas" ##########################################
INSERT INTO `cyt_integrante_estado` (`integrante_oid`, `estado_oid`, `tipoInvestigador_oid`, `dt_alta`, `dt_baja`, `dt_cambio`, `nu_horasinv`, 
`ds_consecuencias`, `ds_motivos`, `ds_reduccionHS`, `fechaDesde`, `fechaHasta`, `motivo`, `user_oid`, `fechaUltModificacion`)
SELECT I.oid, AUX.estado_oid , I.cd_tipoinvestigador, I.dt_alta, I.dt_baja, I.dt_cambioHS, I.nu_horasinv, I.ds_consecuencias, I.ds_motivos, 
I.ds_reduccionHS, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)),
null, AUX.ds_consecuencia, U.oid, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2))
FROM `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
WHERE AUX.estado_oid = 2;


############## se actualizan las fechas hasta de los estados "recibidas" con las fechas de las altas aceptadas #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 2 AND AUX.estado_oid = 31;	

############## por si hay "colgados" altas creadas que fueron aceptadas y no se habían enviado #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 1 AND IE.fechaHasta is null AND AUX.estado_oid = 31;
	
############## se crean los estados "altas aceptadas", en realidad se le pone estado_oid=3 (OJOO!!! que en la tabla auxiliar
estos estados van a estar como 31) ##########################################
INSERT INTO `cyt_integrante_estado` (`integrante_oid`, `estado_oid`, `tipoInvestigador_oid`, `dt_alta`, `dt_baja`, `dt_cambio`, `nu_horasinv`, 
`ds_consecuencias`, `ds_motivos`, `ds_reduccionHS`, `fechaDesde`, `fechaHasta`, `motivo`, `user_oid`, `fechaUltModificacion`)
SELECT I.oid, 3 , I.cd_tipoinvestigador, I.dt_alta, I.dt_baja, I.dt_cambioHS, I.nu_horasinv, I.ds_consecuencias, I.ds_motivos, 
I.ds_reduccionHS, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)),
null, AUX.ds_consecuencia, U.oid, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2))
FROM `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
WHERE AUX.estado_oid = 31;

############## se actualizan las fechas hasta de los estados "recibidas" con las fechas de las altas rechazadas #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 2 AND AUX.estado_oid = 28;	

############## por si hay "colgados" altas creadas que fueron aceptadas y no se habían enviado #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 1 AND IE.fechaHasta is null AND AUX.estado_oid = 28;
	
############## se crean los estados "altas rechazadas", en realidad se le pone estado_oid=3 con fecha de baja = fecha de alta(OJOO!!! que en la tabla auxiliar
estos estados van a estar como 28) ##########################################
INSERT INTO `cyt_integrante_estado` (`integrante_oid`, `estado_oid`, `tipoInvestigador_oid`, `dt_alta`, `dt_baja`, `dt_cambio`, `nu_horasinv`, 
`ds_consecuencias`, `ds_motivos`, `ds_reduccionHS`, `fechaDesde`, `fechaHasta`, `motivo`, `user_oid`, `fechaUltModificacion`)
SELECT I.oid, 3 , I.cd_tipoinvestigador, I.dt_alta, I.dt_alta, I.dt_cambioHS, I.nu_horasinv, I.ds_consecuencias, I.ds_motivos, 
I.ds_reduccionHS, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)),
null, AUX.ds_consecuencia, U.oid, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2))
FROM `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
WHERE AUX.estado_oid = 28;


	
############## se crean los estados de integrantes "aceptados" que faltan ##########################################
INSERT INTO cyt_integrante_estado (integrante_oid, estado_oid, tipoInvestigador_oid, dt_alta, dt_baja, dt_cambio, nu_horasinv, ds_consecuencias, ds_motivos, ds_reduccionHS, fechaDesde, user_oid, fechaUltModificacion, motivo)
SELECT oid, cd_estado, cd_tipoinvestigador, dt_alta, dt_baja, dt_cambioHS, nu_horasinv, ds_consecuencias, ds_motivos, ds_reduccionHS, dt_alta, 1, dt_alta, ''
FROM integrante
WHERE cd_estado = 3 AND NOT EXISTS (SELECT cyt_integrante_estado.oid FROM cyt_integrante_estado WHERE cyt_integrante_estado.estado_oid = 3 AND cyt_integrante_estado.integrante_oid = integrante.oid);

############## Controlo si hay mas de un integrante con fechaHasta en nulo ##########################################
SELECT * FROM cyt_integrante_estado  
WHERE EXISTS (SELECT U2.integrante_oid FROM cyt_integrante_estado U2
WHERE cyt_integrante_estado.integrante_oid = U2.integrante_oid AND fechaHasta is NULL
group by U2.integrante_oid
having count(U2.integrante_oid)>1 );

############## Elimino con unique los duplicados ##########################################
ALTER IGNORE TABLE `cyt_integrante_estado`
ADD UNIQUE INDEX `integrante_oid_estado_oid` (`integrante_oid`, `estado_oid`, fechaDesde);

############## eliminó la restriccion de unique ##########################################
ALTER TABLE `cyt_integrante_estado`
	DROP INDEX `integrante_oid_estado_oid`;
	
############## se actualizan las fechas hasta de los estados "aceptados" con las fechas de las bajas creadas #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,' %')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 3 AND AUX.estado_oid = 4;	

	
############## se crean los estados "bajas creadas" ##########################################
INSERT INTO `cyt_integrante_estado` (`integrante_oid`, `estado_oid`, `tipoInvestigador_oid`, `dt_alta`, `dt_baja`, `dt_cambio`, `nu_horasinv`, 
`ds_consecuencias`, `ds_motivos`, `ds_reduccionHS`, `fechaDesde`, `fechaHasta`, `motivo`, `user_oid`, `fechaUltModificacion`)
SELECT I.oid, AUX.estado_oid , I.cd_tipoinvestigador, I.dt_alta, I.dt_baja, I.dt_cambioHS, I.nu_horasinv, I.ds_consecuencias, I.ds_motivos, 
I.ds_reduccionHS, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)),
null, AUX.ds_consecuencia, U.oid, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2))
FROM `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,' %')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
WHERE AUX.estado_oid = 4;

############## se actualizan las fechas hasta de los estados "bajas creadas" con las fechas de las bajas recibidas #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 4 AND AUX.estado_oid = 5;

############## por si hay "colgados" aceptados con bajas enviadas #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 3 AND IE.fechaHasta is null AND AUX.estado_oid = 5;

############## se crean los estados "bajas recibidas" ##########################################
INSERT INTO `cyt_integrante_estado` (`integrante_oid`, `estado_oid`, `tipoInvestigador_oid`, `dt_alta`, `dt_baja`, `dt_cambio`, `nu_horasinv`, 
`ds_consecuencias`, `ds_motivos`, `ds_reduccionHS`, `fechaDesde`, `fechaHasta`, `motivo`, `user_oid`, `fechaUltModificacion`)
SELECT I.oid, AUX.estado_oid , I.cd_tipoinvestigador, I.dt_alta, I.dt_baja, I.dt_cambioHS, I.nu_horasinv, I.ds_consecuencias, I.ds_motivos, 
I.ds_reduccionHS, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)),
null, AUX.ds_consecuencia, U.oid, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2))
FROM `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
WHERE AUX.estado_oid = 5;



############## se actualizan las fechas hasta de los estados "bajas recibidas" con las fechas de las bajas aceptadas #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 5 AND AUX.estado_oid = 29;	

############## por si hay "colgados" bajas creadas que fueron aceptadas y no se habían enviado #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 4 AND IE.fechaHasta is null AND AUX.estado_oid = 29;

############## se crean los estados "bajas aceptadas", en realidad se le pone estado_oid=3 (OJOO!!! que en la tabla auxiliar
estos estados van a estar como 29) ##########################################
INSERT INTO `cyt_integrante_estado` (`integrante_oid`, `estado_oid`, `tipoInvestigador_oid`, `dt_alta`, `dt_baja`, `dt_cambio`, `nu_horasinv`, 
`ds_consecuencias`, `ds_motivos`, `ds_reduccionHS`, `fechaDesde`, `fechaHasta`, `motivo`, `user_oid`, `fechaUltModificacion`)
SELECT I.oid, 3 , I.cd_tipoinvestigador, I.dt_alta, I.dt_baja, I.dt_cambioHS, I.nu_horasinv, I.ds_consecuencias, I.ds_motivos, 
I.ds_reduccionHS, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)),
null, AUX.ds_consecuencia, U.oid, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2))
FROM `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
WHERE AUX.estado_oid = 29;

############## se actualizan las fechas hasta de los estados "bajas recibidas" con las fechas de las bajas rechazadas #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 5 AND AUX.estado_oid = 30;	

############## por si hay "colgados" bajas creadas que fueron rechazadas y no se habían enviado #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 4 AND IE.fechaHasta is null AND AUX.estado_oid = 30;

############## se crean los estados "bajas rechazadas", en realidad se le pone estado_oid=3 (OJOO!!! que en la tabla auxiliar
estos estados van a estar como 30) ##########################################
INSERT INTO `cyt_integrante_estado` (`integrante_oid`, `estado_oid`, `tipoInvestigador_oid`, `dt_alta`, `dt_baja`, `dt_cambio`, `nu_horasinv`, 
`ds_consecuencias`, `ds_motivos`, `ds_reduccionHS`, `fechaDesde`, `fechaHasta`, `motivo`, `user_oid`, `fechaUltModificacion`)
SELECT I.oid, 3 , I.cd_tipoinvestigador, I.dt_alta, I.dt_baja, I.dt_cambioHS, I.nu_horasinv, I.ds_consecuencias, I.ds_motivos, 
I.ds_reduccionHS, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)),
null, AUX.ds_consecuencia, U.oid, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2))
FROM `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
WHERE AUX.estado_oid = 30;

############## se actualizan las fechas hasta de los estados "aceptados" con las fechas de los cambios creados #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN integrante I ON AUX.proyecto_oid = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 3 AND AUX.estado_oid = 6;	

	
############## se crean los estados "cambios creados" ##########################################
INSERT INTO `cyt_integrante_estado` (`integrante_oid`, `estado_oid`, `tipoInvestigador_oid`, `dt_alta`, `dt_baja`, `dt_cambio`, `nu_horasinv`, 
`ds_consecuencias`, `ds_motivos`, `ds_reduccionHS`, `fechaDesde`, `fechaHasta`, `motivo`, `user_oid`, `fechaUltModificacion`)
SELECT I.oid, AUX.estado_oid , I.cd_tipoinvestigador, I.dt_alta, I.dt_baja, I.dt_cambioHS, I.nu_horasinv, I.ds_consecuencias, I.ds_motivos, 
I.ds_reduccionHS, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)),
null, AUX.ds_consecuencia, U.oid, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2))
FROM `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN integrante I ON AUX.proyecto_oid = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
WHERE AUX.estado_oid = 6;

############## se actualizan las fechas hasta de los estados "cambios creados" con las fechas de las cambios recibidos #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 6 AND AUX.estado_oid = 7;


############## se crean los estados "cambios recibidos" ##########################################
INSERT INTO `cyt_integrante_estado` (`integrante_oid`, `estado_oid`, `tipoInvestigador_oid`, `dt_alta`, `dt_baja`, `dt_cambio`, `nu_horasinv`, 
`ds_consecuencias`, `ds_motivos`, `ds_reduccionHS`, `fechaDesde`, `fechaHasta`, `motivo`, `user_oid`, `fechaUltModificacion`)
SELECT I.oid, AUX.estado_oid , I.cd_tipoinvestigador, I.dt_alta, I.dt_baja, I.dt_cambioHS, I.nu_horasinv, I.ds_consecuencias, I.ds_motivos, 
I.ds_reduccionHS, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)),
null, AUX.ds_consecuencia, U.oid, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2))
FROM `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
WHERE AUX.estado_oid = 7;

############## se actualizan las fechas hasta de los estados "cambios recibidos" con las fechas de los cambios hs aceptados #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 7 AND AUX.estado_oid = 32;	

############## por si hay "colgados" cambios creados que fueron aceptadas y no se habían enviado #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 6 AND IE.fechaHasta is null AND AUX.estado_oid = 32;

############## se crean los estados "cambios aceptados", en realidad se le pone estado_oid=3 (OJOO!!! que en la tabla auxiliar
estos estados van a estar como 29) ##########################################
INSERT INTO `cyt_integrante_estado` (`integrante_oid`, `estado_oid`, `tipoInvestigador_oid`, `dt_alta`, `dt_baja`, `dt_cambio`, `nu_horasinv`, 
`ds_consecuencias`, `ds_motivos`, `ds_reduccionHS`, `fechaDesde`, `fechaHasta`, `motivo`, `user_oid`, `fechaUltModificacion`)
SELECT I.oid, 3 , I.cd_tipoinvestigador, I.dt_alta, I.dt_baja, I.dt_cambioHS, I.nu_horasinv, I.ds_consecuencias, I.ds_motivos, 
I.ds_reduccionHS, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)),
null, AUX.ds_consecuencia, U.oid, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2))
FROM `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
WHERE AUX.estado_oid = 32;


############## se actualizan las fechas hasta de los estados "cambios recibidos" con las fechas de los cambios rechazados #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 7 AND AUX.estado_oid = 33;	

############## por si hay "colgados" cambios creados que fueron rechazados y no se habían enviado #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 6 AND IE.fechaHasta is null AND AUX.estado_oid = 33;

############## se crean los estados "cambios rechazadas", en realidad se le pone estado_oid=3 (OJOO!!! que en la tabla auxiliar
estos estados van a estar como 30) ##########################################
INSERT INTO `cyt_integrante_estado` (`integrante_oid`, `estado_oid`, `tipoInvestigador_oid`, `dt_alta`, `dt_baja`, `dt_cambio`, `nu_horasinv`, 
`ds_consecuencias`, `ds_motivos`, `ds_reduccionHS`, `fechaDesde`, `fechaHasta`, `motivo`, `user_oid`, `fechaUltModificacion`)
SELECT I.oid, 3 , I.cd_tipoinvestigador, I.dt_alta, I.dt_baja, I.dt_cambioHS, I.nu_horasinv, I.ds_consecuencias, I.ds_motivos, 
I.ds_reduccionHS, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)),
null, AUX.ds_consecuencia, U.oid, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2))
FROM `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
WHERE AUX.estado_oid = 33;


############## se actualizan las fechas hasta de los estados "aceptados" con las fechas de los cambios de hs creados #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN integrante I ON AUX.proyecto_oid = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 3 AND AUX.estado_oid = 8;	

	
############## se crean los estados "cambios hs creados" ##########################################
INSERT INTO `cyt_integrante_estado` (`integrante_oid`, `estado_oid`, `tipoInvestigador_oid`, `dt_alta`, `dt_baja`, `dt_cambio`, `nu_horasinv`, 
`ds_consecuencias`, `ds_motivos`, `ds_reduccionHS`, `fechaDesde`, `fechaHasta`, `motivo`, `user_oid`, `fechaUltModificacion`)
SELECT I.oid, AUX.estado_oid , I.cd_tipoinvestigador, I.dt_alta, I.dt_baja, I.dt_cambioHS, I.nu_horasinv, I.ds_consecuencias, I.ds_motivos, 
I.ds_reduccionHS, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)),
null, AUX.ds_consecuencia, U.oid, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2))
FROM `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN integrante I ON AUX.proyecto_oid = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
WHERE AUX.estado_oid = 8;


	
############## se actualizan las fechas hasta de los estados "cambios hs creados" con las fechas de las cambios hs recibidos #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 8 AND AUX.estado_oid = 9;


############## se crean los estados "cambios hs recibidos" ##########################################
INSERT INTO `cyt_integrante_estado` (`integrante_oid`, `estado_oid`, `tipoInvestigador_oid`, `dt_alta`, `dt_baja`, `dt_cambio`, `nu_horasinv`, 
`ds_consecuencias`, `ds_motivos`, `ds_reduccionHS`, `fechaDesde`, `fechaHasta`, `motivo`, `user_oid`, `fechaUltModificacion`)
SELECT I.oid, AUX.estado_oid , I.cd_tipoinvestigador, I.dt_alta, I.dt_baja, I.dt_cambioHS, I.nu_horasinv, I.ds_consecuencias, I.ds_motivos, 
I.ds_reduccionHS, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)),
null, AUX.ds_consecuencia, U.oid, CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2))
FROM `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
WHERE AUX.estado_oid = 9;

############## se actualizan las fechas hasta de los estados "cambios hs recibidos" con las fechas de los cambios hs aceptados #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 9 AND AUX.estado_oid = 32;	

############## por si hay "colgados" cambios creados que fueron aceptadas y no se habían enviado #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 8 AND IE.fechaHasta is null AND AUX.estado_oid = 32;

############## se actualizan las fechas hasta de los estados "cambios hs recibidos" con las fechas de los cambios rechazados #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 9 AND AUX.estado_oid = 33;	

############## por si hay "colgados" cambios hs creados que fueron rechazados y no se habían enviado #############################
UPDATE `aux_mov_altas_bajas` AUX 
INNER JOIN docente D ON AUX.documento = D.nu_documento
INNER JOIN proyecto P ON AUX.proyecto_oid LIKE CONCAT('%',P.ds_codigo,'%')
INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto AND D.cd_docente = I.cd_docente 
INNER JOIN usuarioproyecto UP ON AUX.usuario_oid = UP.cd_usuario
INNER JOIN cyt_user U ON U.ds_username LIKE CONCAT('%',UP.nu_documento,'%')
INNER JOIN cyt_integrante_estado IE ON IE.integrante_oid = I.oid
SET IE.fechaHasta = CONCAT(SUBSTRING(AUX.fechaHora,1,4),'-',SUBSTRING(AUX.fechaHora,5,2),'-',SUBSTRING(AUX.fechaHora,7,2),' ',SUBSTRING(AUX.fechaHora,9,2),':',SUBSTRING(AUX.fechaHora,11,2),':',SUBSTRING(AUX.fechaHora,13,2)) 
WHERE IE.estado_oid = 8 AND IE.fechaHasta is null AND AUX.estado_oid = 33;



########Se cargan todos los movimientos manuales que hice y estaban en ds_cyt de la tabla integrantes (todos con cd_estado aceptado y fechaDesde y fechaHasta = a la fecha que se hicieron########
CREATE TABLE IF NOT EXISTS `aux_integrante_estado_manuales` (
  `integrante_oid` bigint(20) DEFAULT NULL,
  `estado_oid` bigint(20) DEFAULT NULL,
  `tipoInvestigador_oid` bigint(20) DEFAULT NULL,
  `dt_alta` date DEFAULT NULL,
  `dt_baja` date DEFAULT NULL,
  `dt_cambio` date DEFAULT NULL,
  `nu_horasinv` int(11) DEFAULT NULL,
  `ds_reduccionHS` text,
  `fechaDesde` datetime DEFAULT NULL,
  `fechaHasta` datetime DEFAULT NULL,
  `motivo` text,
  `user_oid` int(11) NOT NULL
);

INSERT INTO `cyt_integrante_estado` (`integrante_oid`, `estado_oid`, `tipoInvestigador_oid`, `dt_alta`, `dt_baja`, `dt_cambio`, `nu_horasinv`, 
`ds_reduccionHS`, `fechaDesde`, `fechaHasta`, `motivo`, `user_oid`)
SELECT * FROM `aux_integrante_estado_manuales`;


############## se actualizan las fechas de baja '0000-00-00' a null ##########################################
UPDATE cyt_integrante_estado SET dt_baja = null WHERE dt_baja = '0000-00-00';

############## se controlan si hay integrantes que no tienen fechaHasta en null ##########################################
SELECT integrante.* 
FROM integrante
WHERE NOT EXISTS (SELECT cyt_integrante_estado.oid FROM cyt_integrante_estado WHERE fechaHasta is null AND cyt_integrante_estado.integrante_oid = integrante.oid);

############## se agregan los que faltan ##########################################
INSERT INTO `cyt_integrante_estado` (`integrante_oid`, `estado_oid`, `tipoInvestigador_oid`, `dt_alta`, `dt_baja`, `dt_cambio`, `nu_horasinv`, 
`ds_consecuencias`, `ds_motivos`, `ds_reduccionHS`, `fechaDesde`, `fechaHasta`, `motivo`, `user_oid`, `fechaUltModificacion`)
SELECT integrante.oid, integrante.cd_estado, integrante.cd_tipoinvestigador, integrante.dt_alta, integrante.dt_baja, integrante.dt_cambioHS, integrante.nu_horasinv,
integrante.ds_consecuencias, integrante.ds_motivos, integrante.ds_reduccionHS, integrante.dt_alta, null, integrante.ds_cyt, 1, integrante.dt_alta 
FROM integrante
WHERE NOT EXISTS (SELECT cyt_integrante_estado.oid FROM cyt_integrante_estado WHERE fechaHasta is null AND cyt_integrante_estado.integrante_oid = integrante.oid);



######################### Igualo la fecha de ult mod con la de fechaDesde ############################
UPDATE cyt_integrante_estado SET fechaUltModificacion = fechaDesde

############## Se controla que los estados finales nuevos (fechaHasta = null) coincidan con los estados viejos ##########################################
SELECT I.oid, I.cd_estado, E.estado_oid 
FROM integrante I LEFT JOIN cyt_integrante_estado E ON I.oid = E.integrante_oid 
WHERE I.cd_estado != E.estado_oid AND E.fechaHasta IS NULL
ORDER BY I.oid;


 ###################################10/05/2017###################################################3
 ALTER TABLE `cyt_integrante_estado`
	
	ADD COLUMN `categoria_oid` INT(11) NULL,
	ADD COLUMN `deddoc_oid` INT(11) NULL DEFAULT NULL,
	ADD COLUMN `cargo_oid` INT(11) NULL DEFAULT NULL,
	ADD COLUMN `facultad_oid` INT(11) NULL DEFAULT NULL;
	
ALTER TABLE `cyt_integrante_estado`
	ADD CONSTRAINT `FK_cyt_integrante_estado_categoria` FOREIGN KEY (`categoria_oid`) REFERENCES `categoria` (`cd_categoria`),
	ADD CONSTRAINT `FK_cyt_integrante_estado_deddoc` FOREIGN KEY (`deddoc_oid`) REFERENCES `deddoc` (`cd_deddoc`),
	ADD CONSTRAINT `FK_cyt_integrante_estado_cargo` FOREIGN KEY (`cargo_oid`) REFERENCES `cargo` (`cd_cargo`),
	ADD CONSTRAINT `FK_cyt_integrante_estado_facultad` FOREIGN KEY (`facultad_oid`) REFERENCES `facultad` (`cd_facultad`);
	
###################################02/02/2018###################################################
ALTER TABLE `integrante`
	ADD COLUMN `dt_becaEstimulo` date NULL DEFAULT NULL,
	ADD COLUMN `bl_becaEstimulo` BINARY(1) NULL;
	
ALTER TABLE `docente`
	ADD COLUMN `dt_becaEstimulo` date NULL DEFAULT NULL,
	ADD COLUMN `bl_becaEstimulo` BINARY(1) NULL;
	
	
INSERT INTO `cargo` (`cd_cargo`, `ds_cargo`, `cd_cargosipi`, `nu_orden`) VALUES ('12', 'Profesor Emérito', '0', '13'), ('13', 'Profesor Consulto', '0', '14');

###################################27/02/2019###################################################

ALTER TABLE `integrante`
	ADD COLUMN `dt_becaEstimuloHasta` date NULL DEFAULT NULL,
	ADD COLUMN `dt_becaHasta` date NULL DEFAULT NULL;
	
ALTER TABLE `docente`
	ADD COLUMN `dt_becaEstimuloHasta` date NULL DEFAULT NULL,
	ADD COLUMN `dt_becaHasta` date NULL DEFAULT NULL;
	
ALTER TABLE `integrante`
	ADD COLUMN `ds_resolucionBeca` VARCHAR(255) DEFAULT NULL;
	
###################################27/11/2019###################################################

ALTER TABLE `cyt_integrante_estado`
	ADD COLUMN `carrerainv_oid` INT(11) NULL AFTER `facultad_oid`,
	ADD COLUMN `organismo_oid` INT(11) NULL DEFAULT NULL AFTER `carrerainv_oid`,
	ADD COLUMN `ds_orgbeca` VARCHAR(255) NULL DEFAULT NULL AFTER `organismo_oid`,
	ADD COLUMN `ds_tipobeca` VARCHAR(255) NULL DEFAULT NULL AFTER `ds_orgbeca`,
	ADD COLUMN `dt_beca` DATE NULL DEFAULT NULL AFTER `ds_tipobeca`,
	ADD COLUMN `dt_becaHasta` DATE NULL DEFAULT NULL AFTER `dt_beca`,
	ADD COLUMN `bl_becaEstimulo` BINARY(1) NULL DEFAULT NULL AFTER `dt_becaHasta`,
	ADD COLUMN `dt_becaEstimulo` DATE NULL DEFAULT NULL AFTER `bl_becaEstimulo`,
	ADD COLUMN `dt_becaEstimuloHasta` DATE NULL DEFAULT NULL AFTER `dt_becaEstimulo`;
	
	
###################################18/12/2019###################################################	
CREATE TABLE `aux_subsidios_proyectos` (
	
	`proyecto` VARCHAR(10) DEFAULT NULL,
	 monto INT(11) NULL DEFAULT NULL
	
	
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;

###################################14/07/2023###################################################
ALTER TABLE `integrante`
	ADD COLUMN `nu_totalMat` INT(11) NULL,
	ADD COLUMN `ds_carrera` VARCHAR(255) NULL DEFAULT NULL;

ALTER TABLE `docente`
	ADD COLUMN `nu_totalMat` INT(11) NULL,
	ADD COLUMN `ds_carrera` VARCHAR(255) NULL DEFAULT NULL;