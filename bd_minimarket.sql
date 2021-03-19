/*
SQLyog Professional v13.1.1 (64 bit)
MySQL - 10.4.14-MariaDB : Database - bd_minimarket
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bd_minimarket` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `bd_minimarket`;

/*Table structure for table `ges_venta` */

DROP TABLE IF EXISTS `ges_venta`;

CREATE TABLE `ges_venta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipocomprobante` char(5) DEFAULT NULL,
  `nrocomprobante` char(1) DEFAULT NULL,
  `fechaventa` date DEFAULT NULL,
  `cliente` char(15) DEFAULT NULL,
  `usuarioregistra` varchar(15) DEFAULT NULL,
  `fecharegistra` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `ges_venta` */

/*Table structure for table `mae_formapago` */

DROP TABLE IF EXISTS `mae_formapago`;

CREATE TABLE `mae_formapago` (
  `formapago` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) DEFAULT NULL,
  `activo` char(1) DEFAULT '1',
  `usuarioregistra` varchar(15) DEFAULT NULL,
  `fecharegistra` datetime DEFAULT NULL,
  `usuariomodifica` varchar(15) DEFAULT NULL,
  `fechamodifica` datetime DEFAULT NULL,
  PRIMARY KEY (`formapago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `mae_formapago` */

/*Table structure for table `mae_perfil` */

DROP TABLE IF EXISTS `mae_perfil`;

CREATE TABLE `mae_perfil` (
  `perfil` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(250) DEFAULT NULL,
  `activo` char(1) DEFAULT '1',
  `usuarioregistra` varchar(15) DEFAULT NULL,
  `fecharegistra` datetime DEFAULT NULL,
  `usuariomodifica` varchar(15) DEFAULT NULL,
  `fechamodifica` datetime DEFAULT NULL,
  PRIMARY KEY (`perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

/*Data for the table `mae_perfil` */

insert  into `mae_perfil`(`perfil`,`descripcion`,`activo`,`usuarioregistra`,`fecharegistra`,`usuariomodifica`,`fechamodifica`) values 
(1,'Desarrollador','1','42412264','2021-03-17 17:18:35',NULL,NULL),
(2,'Administrador','1','42412264','2021-03-17 17:18:50',NULL,NULL),
(3,'Vendedor','1','42412264','2021-03-17 17:19:01',NULL,NULL);

/*Table structure for table `mae_tipodocumento` */

DROP TABLE IF EXISTS `mae_tipodocumento`;

CREATE TABLE `mae_tipodocumento` (
  `tipodocumento` char(2) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `activo` char(1) DEFAULT '1',
  `usuarioregistra` varchar(15) DEFAULT NULL,
  `fecharegistra` datetime DEFAULT NULL,
  PRIMARY KEY (`tipodocumento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `mae_tipodocumento` */

insert  into `mae_tipodocumento`(`tipodocumento`,`descripcion`,`activo`,`usuarioregistra`,`fecharegistra`) values 
('01','Factura','1','42412264','2021-03-17 17:12:58'),
('03','Boleta','1','42412264','2021-03-17 17:12:39'),
('07','Nota de Credito','1','42412264','2021-03-17 17:13:19'),
('08','Nota de Débito','1','42412264','2021-03-17 17:13:31');

/*Table structure for table `mae_usuario` */

DROP TABLE IF EXISTS `mae_usuario`;

CREATE TABLE `mae_usuario` (
  `dni` char(10) NOT NULL,
  `perfil` int(11) DEFAULT NULL,
  `nombres` varchar(250) DEFAULT NULL,
  `apellidos` varchar(250) DEFAULT NULL,
  `fechanacimiento` datetime DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `nrotelefono` varchar(15) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `nombreimg` varchar(50) DEFAULT NULL,
  `rutaimg` varchar(250) DEFAULT NULL,
  `contrasenia` varchar(250) DEFAULT NULL,
  `activo` char(1) DEFAULT '1',
  `usuarioregistra` varchar(15) DEFAULT NULL,
  `fecharegistra` datetime DEFAULT NULL,
  `usuariomodifica` varchar(15) DEFAULT NULL,
  `fechamodifica` datetime DEFAULT NULL,
  PRIMARY KEY (`dni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `mae_usuario` */

insert  into `mae_usuario`(`dni`,`perfil`,`nombres`,`apellidos`,`fechanacimiento`,`email`,`nrotelefono`,`direccion`,`nombreimg`,`rutaimg`,`contrasenia`,`activo`,`usuarioregistra`,`fecharegistra`,`usuariomodifica`,`fechamodifica`) values 
('42412264',1,'JOSE LUIS','AVALOS IZAGUIRRE','0000-00-00 00:00:00','j.avalosizaguirre@gmail.com','918096484','Avenida Pardo 1370 Interior 10','','','4e16d1300507a7a0531ee4ac9b146f10','1','42412264','2021-03-17 17:20:03','42412264','2021-03-18 22:27:51');

/*Table structure for table `men_menuprincipal` */

DROP TABLE IF EXISTS `men_menuprincipal`;

CREATE TABLE `men_menuprincipal` (
  `menu` char(3) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `Imagen` varchar(50) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `Url` varchar(250) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `Orden` smallint(6) NOT NULL DEFAULT 0,
  `Descripcion` varchar(250) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `Estado` char(1) COLLATE utf8_spanish_ci NOT NULL DEFAULT '1',
  `Usuario` varchar(30) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `FechaSistema` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `men_menuprincipal` */

insert  into `men_menuprincipal`(`menu`,`Nombre`,`Imagen`,`Url`,`Orden`,`Descripcion`,`Estado`,`Usuario`,`FechaSistema`) values 
('001','Administración','fa fa-cogs','',1,'','1','42412264','2021-03-18 09:37:12'),
('002','Productos','fa fa-cubes','',2,'','1','42412264','2021-03-18 09:37:28'),
('003','Clientes','fa fa-users','',3,'','1','42412264','2021-03-18 10:02:47'),
('004','Proveedores','fa fa-user-circle','',4,'','1','42412264','2021-03-18 10:01:13'),
('005','Ventas','fa fa-shopping-cart','',5,'','1','','2021-03-18 10:08:59'),
('006','Cierre de Caja','fa fa-balance-scale','',6,'','1','42412264','2021-03-18 09:41:35'),
('007','Facturación Electronica','fa fa-book','',7,'','1','','2021-03-18 10:09:50'),
('008','Reportes','fa fa-chart-line','',8,'','1','','2021-03-18 10:09:25');

/*Table structure for table `men_opciones` */

DROP TABLE IF EXISTS `men_opciones`;

CREATE TABLE `men_opciones` (
  `Menu` char(3) COLLATE utf8_spanish_ci NOT NULL,
  `Opcion` char(3) COLLATE utf8_spanish_ci NOT NULL,
  `Subopcion` char(3) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `Imagen` varchar(50) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `Url` varchar(250) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `Target` varchar(30) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `ImagenToolBar` varchar(120) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `ToolBar` char(1) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0' COMMENT '0=No muestra en el toolbar, 1=Si',
  `OrdenToolBar` smallint(6) NOT NULL DEFAULT 0,
  `Orden` smallint(6) NOT NULL DEFAULT 0,
  `Descripcion` varchar(250) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `Estado` char(1) COLLATE utf8_spanish_ci NOT NULL DEFAULT '1',
  `Usuario` varchar(30) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `UsuarioModifica` varchar(30) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `FechaSistema` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `FechaModifica` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `men_opciones` */

insert  into `men_opciones`(`Menu`,`Opcion`,`Subopcion`,`Nombre`,`Imagen`,`Url`,`Target`,`ImagenToolBar`,`ToolBar`,`OrdenToolBar`,`Orden`,`Descripcion`,`Estado`,`Usuario`,`UsuarioModifica`,`FechaSistema`,`FechaModifica`) values 
('001','001','000','Perfiles de Usuario','','xajax__interfazPerfil();','','','0',0,1,'','1','','','2021-03-18 11:55:19',NULL),
('001','002','000','Usuario','','xajax__interfazUsuarios();','','','0',0,2,'','1','','','2021-03-18 21:02:52',NULL),
('001','003','000','Tipos de Documento','','','','','0',0,3,'','1','','','2021-03-18 10:20:13',NULL),
('001','004','000','Gestión de Accesos','','','','','0',0,5,'','1','','','2021-03-18 22:28:48',NULL),
('002','001','000','Registro de Productos','','','','','0',0,1,'','1','','','2021-03-18 09:56:36',NULL),
('002','002','000','Listado de Productos','','','','','0',0,2,'','1','','','2021-03-18 10:20:57',NULL),
('003','001','000','Registro de Clientes','','','','','0',0,1,'','1','','','2021-03-18 09:57:08',NULL),
('003','002','000','Listado de Clientes','','','','','0',0,2,'','1','','','2021-03-18 09:57:19',NULL),
('004','001','000','Registro de Proveedores','','','','','0',0,1,'','1','','','2021-03-18 09:57:37',NULL),
('004','002','000','Listado de Proveedores','','','','','0',0,2,'','1','','','2021-03-18 09:57:52',NULL),
('005','001','000','Registro de Ventas','','','','','0',0,1,'','1','','','2021-03-18 09:58:09',NULL),
('006','001','000','Cierre de Caja','','','','','0',0,1,'','1','','','2021-03-18 09:58:24',NULL),
('006','002','000','Consultar Cierre','','','','','0',0,2,'','1','','','2021-03-18 09:58:37',NULL),
('007','001','000','Enviar facturas','','','','','0',0,1,'','1','','','2021-03-18 09:58:54',NULL),
('008','001','000','Reporte de Ventas','','','','','0',0,1,'','1','','','2021-03-18 09:59:16',NULL),
('001','005','000','Forma de Pago','','','','','0',0,4,'','1','','','2021-03-18 22:28:46',NULL);

/*Table structure for table `men_perfilopciones` */

DROP TABLE IF EXISTS `men_perfilopciones`;

CREATE TABLE `men_perfilopciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `perfil` int(11) NOT NULL,
  `menu` char(3) NOT NULL,
  `opcion` char(3) NOT NULL,
  `subopcion` char(3) DEFAULT NULL,
  `estado` varchar(1) DEFAULT '1',
  `usuarioregistro` char(8) DEFAULT NULL,
  `fecharegistro` datetime DEFAULT NULL,
  PRIMARY KEY (`perfil`,`menu`,`opcion`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `men_perfilopciones` */

insert  into `men_perfilopciones`(`id`,`perfil`,`menu`,`opcion`,`subopcion`,`estado`,`usuarioregistro`,`fecharegistro`) values 
(1,1,'001','001','000','1',NULL,NULL),
(9,1,'001','002','000','1',NULL,NULL),
(10,1,'001','003','000','1',NULL,NULL),
(11,1,'001','004','000','1',NULL,NULL),
(13,1,'001','005','000','1',NULL,NULL),
(2,1,'002','001','000','1',NULL,NULL),
(15,1,'002','002','000','1',NULL,NULL),
(3,1,'003','001','000','1',NULL,NULL),
(16,1,'003','002','000','1',NULL,NULL),
(4,1,'004','001','000','1',NULL,NULL),
(17,1,'004','002','000','1',NULL,NULL),
(5,1,'005','001','000','1',NULL,NULL),
(6,1,'006','001','000','1',NULL,NULL),
(18,1,'006','002','000','1',NULL,NULL),
(7,1,'007','001','000','1',NULL,NULL),
(8,1,'008','001','000','1',NULL,NULL);

/* Function  structure for function  `fnExplode` */

/*!50003 DROP FUNCTION IF EXISTS `fnExplode` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `fnExplode`(_x TEXT,
_delim VARCHAR(12),
_pos INT
) RETURNS text CHARSET utf8
    DETERMINISTIC
BEGIN
        RETURN REPLACE(SUBSTRING(SUBSTRING_INDEX(_x, _delim, _pos), CHAR_LENGTH(SUBSTRING_INDEX(_x, _delim, _pos -1)) + 1), _delim, '');
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_adminiciarsesion` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_adminiciarsesion` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adminiciarsesion`(`_usuario` VARCHAR(100), `_clave` VARCHAR(300))
BEGIN
		SELECT a.dni,fnExplode(a.nombres,' ',1) as nombres,fnExplode(a.apellidos,' ',1) apellidos,a.perfil,a.nombreimg, a.rutaimg, b.descripcion
		FROM `mae_usuario` a
		inner join mae_perfil b on a.perfil = b.perfil
		WHERE a.dni = _usuario AND a.`contrasenia` = _clave;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_menuConsultar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_menuConsultar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_menuConsultar`(`_flag` CHAR(1), `_perfil` INT, `_menu` CHAR(3))
BEGIN		
		IF _flag = '1' THEN
			SELECT DISTINCT a.Menu,b.Nombre, b.orden, b.Imagen FROM `men_perfilopciones` a
			INNER JOIN `men_menuprincipal` b ON a.menu = b.menu
			WHERE a.perfil = _perfil  AND b.estado = '1' AND a.estado = '1' ORDER BY b.orden ASC;
		ELSEIF _flag ='2' THEN
			SELECT a.*, b.Nombre, b.Url, b.target AS urlarchivo FROM `men_perfilopciones` a
			INNER JOIN `men_opciones` b on a.menu = b.menu AND a.opcion = b.opcion
			WHERE a.perfil = _perfil AND a.menu = _menu AND b.estado = '1' AND a.estado = '1' ORDER BY b.Orden;		
		END IF;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_perfilBuscar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_perfilBuscar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_perfilBuscar`(IN `_criterio` VARCHAR(80), IN `_buscarPor` CHAR(1), IN `_flag` SMALLINT, IN `_pagina` INT, IN `_reg_por_pag` INT)
BEGIN
	   
    
    IF _flag='1' THEN
        SELECT COUNT(*) AS total
        FROM
        `mae_perfil` WHERE `descripcion` LIKE CONCAT('%',_criterio,'%');
    ELSE
        SET @rownum=0;
        
        SELECT 	* FROM 
        (
            SELECT @rownum:=@rownum+1 AS rownum,
                `perfil`,`descripcion`,`activo`
            FROM `mae_perfil` WHERE `descripcion` LIKE CONCAT('%',_criterio,'%')
            
        )R
        WHERE 	rownum > _reg_por_pag * (_pagina-1) AND
            rownum <= _reg_por_pag * _pagina
        ORDER BY rownum;
    END IF;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_perfilConsultar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_perfilConsultar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_perfilConsultar`(
	_flag char(2),
	_criterio varchar(250)
)
BEGIN
	
		if _flag = '1' then
			select * from `mae_perfil` where perfil = _criterio;
		elseif _flag = '2' then
			SELECT perfil, descripcion FROM `mae_perfil` WHERE activo ='1';
		end if;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_perfilMantenedor` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_perfilMantenedor` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_perfilMantenedor`(
	_flag char(1),
	_perfil char(5),
	_descripcion varchar(250),
	_activo char(1),
	_usuario varchar(15)
)
BEGIN
	declare _xtotal int default 0;
		if _flag = '1' then
			select count(*) into _xtotal from mae_perfil where descripcion = _descripcion;
			if _xtotal = 0 then
				insert into `mae_perfil`(`descripcion`,`activo`,`usuarioregistra`,`fecharegistra`)
				values(_descripcion, _activo, _usuario, now());
				select 'MSG_001' as mensaje;
			else
				select 'MSG_004' as mensaje;
			end if;
		elseif _flag = '2' then
			SELECT COUNT(*) INTO _xtotal FROM mae_perfil WHERE descripcion = _descripcion and perfil <> _perfil;
			IF _xtotal = 0 THEN
				update `mae_perfil` set
				`descripcion` = _descripcion,
				`activo` = _activo,
				`usuariomodifica` = _usuario,
				`fechamodifica` = now()
				where 
				perfil = _perfil;
				SELECT 'MSG_002' AS mensaje;
			ELSE
				SELECT 'MSG_004' AS mensaje;
			END IF;
		elseif _flag = '3' then
			select count(*) into _xtotal from `men_perfilopciones` where `perfil` = _perfil;
			if _xtotal = 0 then
				delete from `mae_perfil` where `perfil` = _perfil;
				SELECT 'MSG_003' AS mensaje;
			else
				select 'MSG_005' as mensaje;
			end if;
		end if;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_usuariosBuscar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_usuariosBuscar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuariosBuscar`(IN `_criterio` VARCHAR(80), IN `_buscarPor` CHAR(1), IN `_flag` SMALLINT, IN `_pagina` INT, IN `_reg_por_pag` INT)
BEGIN
	   
    
    IF _flag='1' THEN
        SELECT COUNT(*) AS total
        FROM
        `mae_usuario`  a
        INNER JOIN mae_perfil b ON a.perfil = b.perfil
        WHERE (a.`nombres` LIKE CONCAT('%',_criterio,'%') or a.`apellidos` LIKE CONCAT('%',_criterio,'%') or a.dni = _criterio);
    ELSE
        SET @rownum=0;
        
        SELECT 	* FROM 
        (
            SELECT @rownum:=@rownum+1 AS rownum,
                a.`dni`,a.`perfil`,concat(ifnull(a.`nombres`,''),' ',ifnull(a.`apellidos`,'')) nombres,
                date_format(a.`fechanacimiento`, '%d-%m-%Y') fechanacimiento,a.`email`,a.`nrotelefono`,a.`direccion`,a.`activo`,
                b.descripcion as nombreperfil
            FROM `mae_usuario` a
            inner join mae_perfil b on a.perfil = b.perfil
             WHERE (a.`nombres` LIKE CONCAT('%',_criterio,'%') OR a.`apellidos` LIKE CONCAT('%',_criterio,'%') OR a.dni = _criterio)
            
        )R
        WHERE 	rownum > _reg_por_pag * (_pagina-1) AND
            rownum <= _reg_por_pag * _pagina
        ORDER BY rownum;
    END IF;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_usuariosConsultar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_usuariosConsultar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuariosConsultar`(
	_flag char(2),
	_criterio varchar(250)
)
BEGIN
		if _flag = '1' then
			select * from `mae_usuario` where dni = _criterio;
		elseif _flag = '2' then
			SELECT * FROM `mae_usuario` WHERE activo='1';
		end if;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_usuariosMantenedor` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_usuariosMantenedor` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuariosMantenedor`(
	_flag char(2),
	_dni char(10),
	_perfil int,
	_nombres varchar(250),
	_apellidos VARCHAR(250),
	_fechanacimiento date,
	_email VARCHAR(150),
	_nrotelefono VARCHAR(15),
	_direccion VARCHAR(150),
	_nombreimg VARCHAR(50),
	_rutaimg VARCHAR(250),
	_contrasenia VARCHAR(250),
	_activo char(1),
	_usuario varchar(15)
)
BEGIN
	declare _xtotal int default 0;
	declare _xperfil int default 0;
	declare _xcontrasenia varchar(250) default '';
	if _flag = '1' then
		select count(*) into _xtotal from `mae_usuario` where `dni` = _dni;
		if _xtotal = 0 then
			insert into `mae_usuario`(`dni`,`perfil`,`nombres`,`apellidos`,`fechanacimiento`,`email`,`nrotelefono`,`direccion`,
			`nombreimg`,`rutaimg`,`contrasenia`,`activo`,`usuarioregistra`,`fecharegistra`)
			values(_dni, _perfil, _nombres, _apellidos, _fechanacimiento, _email, _nrotelefono, _direccion, _nombreimg,
			_rutaimg, _contrasenia, _activo, _usuario, now());
			
			select 'MSG_001' as mensaje;
		else
			SELECT 'MSG_004' AS mensaje;
		end if;
	elseif _flag = '2' then				
		if _contrasenia = '' then
			SELECT `contrasenia` INTO _xcontrasenia FROM `mae_usuario` WHERE `dni` = _dni;
		else
			set _xcontrasenia = _contrasenia;
		end if;
			
			update `mae_usuario` set
			`perfil` = _perfil,
			`nombres` = _nombres,
			`apellidos` = _apellidos,
			`fechanacimiento` = _fechanacimiento,
			`email` = _email,
			`nrotelefono` = _nrotelefono,
			`direccion` = _direccion,
			`nombreimg` = _nombreimg,
			`rutaimg` = _rutaimg,
			`contrasenia` = _xcontrasenia,
			`activo` = _activo,
			`usuariomodifica` = _usuario,
			`fechamodifica` = now()
			where dni = _dni;
			SELECT 'MSG_002' AS mensaje;
		
	elseif _flag = '3' then
		
		select count(*) into _xtotal from `ges_venta` where `usuarioregistra` = _dni;
		
		if _xtotal = 0 then
			delete from `mae_usuario` where dni = _dni;
			select 'MSG_003' as mensaje;
		else
			SELECT 'MSG_005' AS mensaje;
		end if;
	end if;
	END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
