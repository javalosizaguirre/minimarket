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

/*Table structure for table `ges_cliente` */

DROP TABLE IF EXISTS `ges_cliente`;

CREATE TABLE `ges_cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nrodocumento` varchar(15) DEFAULT NULL,
  `tipodocumento` char(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `ges_cliente` */

/*Table structure for table `ges_venta` */

DROP TABLE IF EXISTS `ges_venta`;

CREATE TABLE `ges_venta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipocomprobante` char(2) DEFAULT NULL,
  `nrocomprobante` char(1) DEFAULT NULL,
  `fechaventa` date DEFAULT NULL,
  `cliente` char(15) DEFAULT NULL,
  `formapago` int(11) DEFAULT NULL,
  `tarjeta` int(11) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `mae_formapago` */

insert  into `mae_formapago`(`formapago`,`descripcion`,`activo`,`usuarioregistra`,`fecharegistra`,`usuariomodifica`,`fechamodifica`) values 
(1,'Contado','1','42412264','2021-03-19 08:41:02',NULL,NULL),
(2,'Credito','1','42412264','2021-03-19 08:41:09',NULL,NULL),
(3,'Tarjeta','1','42412264','2021-03-19 08:41:14',NULL,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

/*Data for the table `mae_perfil` */

insert  into `mae_perfil`(`perfil`,`descripcion`,`activo`,`usuarioregistra`,`fecharegistra`,`usuariomodifica`,`fechamodifica`) values 
(1,'Desarrollador','1','42412264','2021-03-17 17:18:35',NULL,NULL),
(2,'Administrador','1','42412264','2021-03-17 17:18:50',NULL,NULL),
(3,'Vendedor','1','42412264','2021-03-17 17:19:01',NULL,NULL);

/*Table structure for table `mae_tarjetas` */

DROP TABLE IF EXISTS `mae_tarjetas`;

CREATE TABLE `mae_tarjetas` (
  `tarjeta` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(250) DEFAULT NULL,
  `activo` char(1) DEFAULT '1',
  `usuarioregistra` varchar(15) DEFAULT NULL,
  `fecharegistra` datetime DEFAULT NULL,
  `usuariomodifica` varchar(15) DEFAULT NULL,
  `fechamodifica` datetime DEFAULT NULL,
  PRIMARY KEY (`tarjeta`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `mae_tarjetas` */

insert  into `mae_tarjetas`(`tarjeta`,`descripcion`,`activo`,`usuarioregistra`,`fecharegistra`,`usuariomodifica`,`fechamodifica`) values 
(1,'VISA','1','42412264','2021-03-19 08:59:30',NULL,NULL),
(2,'MASTERCARD','1','42412264','2021-03-19 08:59:48',NULL,NULL),
(3,'DINERS CLUB','1','42412264','2021-03-19 08:59:55',NULL,NULL);

/*Table structure for table `mae_tipocomprobante` */

DROP TABLE IF EXISTS `mae_tipocomprobante`;

CREATE TABLE `mae_tipocomprobante` (
  `tipocomprobante` char(2) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `activo` char(1) DEFAULT '1',
  `usuarioregistra` varchar(15) DEFAULT NULL,
  `fecharegistra` datetime DEFAULT NULL,
  `usuariomodifica` varchar(15) DEFAULT NULL,
  `fechamodifica` datetime DEFAULT NULL,
  PRIMARY KEY (`tipocomprobante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `mae_tipocomprobante` */

insert  into `mae_tipocomprobante`(`tipocomprobante`,`descripcion`,`activo`,`usuarioregistra`,`fecharegistra`,`usuariomodifica`,`fechamodifica`) values 
('01','Factura','1','42412264','2021-03-17 17:12:58',NULL,NULL),
('03','Boleta','1','42412264','2021-03-17 17:12:39',NULL,NULL),
('07','Nota de Credito','1','42412264','2021-03-17 17:13:19',NULL,NULL),
('08','Nota de Débito','1','42412264','2021-03-17 17:13:31',NULL,NULL);

/*Table structure for table `mae_tipodocumento` */

DROP TABLE IF EXISTS `mae_tipodocumento`;

CREATE TABLE `mae_tipodocumento` (
  `tipodocumento` char(2) NOT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `activo` char(1) DEFAULT NULL,
  `usuarioregistra` varchar(15) DEFAULT NULL,
  `fecharegistra` datetime DEFAULT NULL,
  `usuariomodifica` varchar(15) DEFAULT NULL,
  `fechamodifica` datetime DEFAULT NULL,
  PRIMARY KEY (`tipodocumento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `mae_tipodocumento` */

insert  into `mae_tipodocumento`(`tipodocumento`,`descripcion`,`activo`,`usuarioregistra`,`fecharegistra`,`usuariomodifica`,`fechamodifica`) values 
('0','DOC.TRIB.NO.DOM.SIN.RUC','1','42412264','2021-03-19 09:28:39',NULL,NULL),
('1','DOC. NACIONAL DE IDENTIDAD (DNI)','1','42412264','2021-03-19 09:28:50','42412264','2021-03-19 09:35:29'),
('4','CARNET DE EXTRANJERIA','1','42412264','2021-03-19 09:29:00',NULL,NULL),
('6','REG. UNICO DE CONTRIBUYENTES (RUC)','1','42412264','2021-03-19 09:30:51',NULL,NULL),
('7','PASAPORTE','1','42412264','2021-03-19 09:31:07',NULL,NULL),
('A','CED. DIPLOMATICA DE IDENTIDAD','1','42412264','2021-03-19 09:31:21',NULL,NULL);

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
('001','003','000','Tipos de Comprobante','','xajax__interfazTipoComprobante();','','','0',0,4,'','1','','','2021-03-19 08:19:44',NULL),
('001','004','000','Gestión de Accesos','','','','','0',0,3,'','1','','','2021-03-19 08:00:19',NULL),
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
('001','005','000','Forma de Pago','','xajax__interfazFormaPago();','','','0',0,5,'','1','','','2021-03-19 08:40:32',NULL),
('001','006','000','Tarjetas','','xajax__interfazTarjetas();','','','0',0,6,'','1','','','2021-03-19 08:59:22',NULL),
('001','007','000','Tipo de Documento','','xajax__interfazTipoDocumento();','','','0',0,7,'','1','','','2021-03-19 09:07:15',NULL),
('002','003','000','Categoria Producto','','xajax__interfazCategoriaProducto();','','','0',0,3,'','1','','','2021-03-19 21:10:23',NULL),
('002','004','000','Marca Producto','','xajax__interfazMarcaProducto();','','','0',0,4,'','1','','','2021-03-19 22:15:38',NULL),
('002','005','000','Modelo Producto','','xajax__interfazModeloProducto();','','','0',0,5,'','1','','','2021-03-19 22:29:49',NULL),
('002','006','000','Talla Producto','','xajax__interfazTallaProducto();','','','0',0,6,'','1','','','2021-03-19 22:42:39',NULL),
('002','007','000','Unidad de Medida','','xajax__interfazUnidadMedidaProducto();','','','0',0,7,'','1','','','2021-03-19 22:56:47',NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

/*Data for the table `men_perfilopciones` */

insert  into `men_perfilopciones`(`id`,`perfil`,`menu`,`opcion`,`subopcion`,`estado`,`usuarioregistro`,`fecharegistro`) values 
(1,1,'001','001','000','1',NULL,NULL),
(9,1,'001','002','000','1',NULL,NULL),
(10,1,'001','003','000','1',NULL,NULL),
(11,1,'001','004','000','1',NULL,NULL),
(13,1,'001','005','000','1',NULL,NULL),
(19,1,'001','006','000','1',NULL,NULL),
(20,1,'001','007','000','1',NULL,NULL),
(2,1,'002','001','000','1',NULL,NULL),
(15,1,'002','002','000','1',NULL,NULL),
(21,1,'002','003','000','1',NULL,NULL),
(22,1,'002','004','000','1',NULL,NULL),
(23,1,'002','005','000','1',NULL,NULL),
(24,1,'002','006','000','1',NULL,NULL),
(25,1,'002','007','000','1',NULL,NULL),
(3,1,'003','001','000','1',NULL,NULL),
(16,1,'003','002','000','1',NULL,NULL),
(4,1,'004','001','000','1',NULL,NULL),
(17,1,'004','002','000','1',NULL,NULL),
(5,1,'005','001','000','1',NULL,NULL),
(6,1,'006','001','000','1',NULL,NULL),
(18,1,'006','002','000','1',NULL,NULL),
(7,1,'007','001','000','1',NULL,NULL),
(8,1,'008','001','000','1',NULL,NULL);

/*Table structure for table `prod_categoria` */

DROP TABLE IF EXISTS `prod_categoria`;

CREATE TABLE `prod_categoria` (
  `categoria` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(250) DEFAULT NULL,
  `activo` char(1) DEFAULT '1',
  `usuarioregistra` varchar(15) DEFAULT NULL,
  `fecharegistra` datetime DEFAULT NULL,
  `usuariomodifica` varchar(15) DEFAULT NULL,
  `fechamodifica` datetime DEFAULT NULL,
  PRIMARY KEY (`categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `prod_categoria` */

/*Table structure for table `prod_clase` */

DROP TABLE IF EXISTS `prod_clase`;

CREATE TABLE `prod_clase` (
  `clase` char(2) NOT NULL,
  `familia` char(2) DEFAULT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `activo` char(1) DEFAULT NULL,
  `usuarioregistra` varchar(15) DEFAULT NULL,
  `fecharegistra` datetime DEFAULT NULL,
  PRIMARY KEY (`clase`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `prod_clase` */

/*Table structure for table `prod_familia` */

DROP TABLE IF EXISTS `prod_familia`;

CREATE TABLE `prod_familia` (
  `familia` char(2) NOT NULL,
  `segmento` char(2) DEFAULT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `activo` char(1) DEFAULT NULL,
  `usuarioregistra` varchar(15) DEFAULT NULL,
  `fecharegistra` datetime DEFAULT NULL,
  PRIMARY KEY (`familia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `prod_familia` */

/*Table structure for table `prod_marca` */

DROP TABLE IF EXISTS `prod_marca`;

CREATE TABLE `prod_marca` (
  `marca` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(150) DEFAULT NULL,
  `activo` char(1) DEFAULT NULL,
  `usuarioregistra` varchar(15) DEFAULT NULL,
  `fecharegistra` datetime DEFAULT NULL,
  `usuariomodifica` varchar(15) DEFAULT NULL,
  `fechamodifica` datetime DEFAULT NULL,
  PRIMARY KEY (`marca`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `prod_marca` */

/*Table structure for table `prod_modelo` */

DROP TABLE IF EXISTS `prod_modelo`;

CREATE TABLE `prod_modelo` (
  `modelo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(150) DEFAULT NULL,
  `activo` char(1) DEFAULT '1',
  `usuarioregistra` varchar(15) DEFAULT NULL,
  `fecharegistra` datetime DEFAULT NULL,
  `usuariomodifica` varchar(15) DEFAULT NULL,
  `fechamodifica` datetime DEFAULT NULL,
  PRIMARY KEY (`modelo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `prod_modelo` */

/*Table structure for table `prod_producto` */

DROP TABLE IF EXISTS `prod_producto`;

CREATE TABLE `prod_producto` (
  `producto` char(15) DEFAULT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `categoria` int(11) DEFAULT NULL,
  `marca` int(11) DEFAULT NULL,
  `modelo` int(11) DEFAULT NULL,
  `talla` int(11) DEFAULT NULL,
  `unidadmedida` int(11) DEFAULT NULL,
  `stockactual` int(11) DEFAULT NULL,
  `stockminimo` int(11) DEFAULT NULL,
  `preciocompra` double(9,2) DEFAULT NULL,
  `precioventa` double(9,2) DEFAULT NULL,
  `fechavencimiento` date DEFAULT NULL,
  `activo` char(1) DEFAULT NULL,
  `usuarioregistra` varchar(15) DEFAULT NULL,
  `fecharegistra` datetime DEFAULT NULL,
  `usuariomodifica` varchar(15) DEFAULT NULL,
  `fechamodifica` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `prod_producto` */

/*Table structure for table `prod_producto_sunat` */

DROP TABLE IF EXISTS `prod_producto_sunat`;

CREATE TABLE `prod_producto_sunat` (
  `producto` char(8) NOT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `activo` char(1) DEFAULT NULL,
  `usuarioregistra` varchar(15) DEFAULT NULL,
  `fecharegistra` datetime DEFAULT NULL,
  PRIMARY KEY (`producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `prod_producto_sunat` */

/*Table structure for table `prod_segmento` */

DROP TABLE IF EXISTS `prod_segmento`;

CREATE TABLE `prod_segmento` (
  `segmento` char(2) NOT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `activo` char(1) DEFAULT '1',
  `usuarioregistra` varchar(15) DEFAULT NULL,
  `fecharegistra` datetime DEFAULT NULL,
  PRIMARY KEY (`segmento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `prod_segmento` */

/*Table structure for table `prod_talla` */

DROP TABLE IF EXISTS `prod_talla`;

CREATE TABLE `prod_talla` (
  `talla` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(150) DEFAULT NULL,
  `activo` char(1) DEFAULT '1',
  `usuarioregistra` varchar(15) DEFAULT NULL,
  `fecharegistra` datetime DEFAULT NULL,
  `usuariomodifica` varchar(15) DEFAULT NULL,
  `fechamodifica` datetime DEFAULT NULL,
  PRIMARY KEY (`talla`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `prod_talla` */

insert  into `prod_talla`(`talla`,`descripcion`,`activo`,`usuarioregistra`,`fecharegistra`,`usuariomodifica`,`fechamodifica`) values 
(3,'XL','1','42412264','2021-03-19 22:45:57',NULL,NULL),
(4,'S','1','42412264','2021-03-19 22:46:00',NULL,NULL);

/*Table structure for table `prod_unidadmedida` */

DROP TABLE IF EXISTS `prod_unidadmedida`;

CREATE TABLE `prod_unidadmedida` (
  `unidadmedida` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(150) DEFAULT NULL,
  `activo` char(1) DEFAULT NULL,
  `usuarioregistra` varchar(15) DEFAULT NULL,
  `fecharegistra` datetime DEFAULT NULL,
  `usuariomodifica` varchar(15) DEFAULT NULL,
  `fechamodifica` datetime DEFAULT NULL,
  PRIMARY KEY (`unidadmedida`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `prod_unidadmedida` */

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

/* Procedure structure for procedure `sp_categoriaproductoBuscar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_categoriaproductoBuscar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_categoriaproductoBuscar`(IN `_criterio` VARCHAR(80), IN `_buscarPor` CHAR(1), IN `_flag` SMALLINT, IN `_pagina` INT, IN `_reg_por_pag` INT)
BEGIN
	   
    
    IF _flag='1' THEN
        SELECT COUNT(*) AS total
        FROM
        `prod_categoria` WHERE `descripcion` LIKE CONCAT('%',_criterio,'%');
    ELSE
        SET @rownum=0;
        
        SELECT 	* FROM 
        (
            SELECT @rownum:=@rownum+1 AS rownum,
                `categoria`,`descripcion`,`activo`
            FROM `prod_categoria` WHERE `descripcion` LIKE CONCAT('%',_criterio,'%')
            
        )R
        WHERE 	rownum > _reg_por_pag * (_pagina-1) AND
            rownum <= _reg_por_pag * _pagina
        ORDER BY rownum;
    END IF;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_categoriaproductoConsultar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_categoriaproductoConsultar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_categoriaproductoConsultar`(
	_flag CHAR(2),
	_criterio VARCHAR(250)
)
BEGIN
	
		IF _flag = '1' THEN
			SELECT * FROM `prod_categoria` WHERE `categoria` = _criterio;
		ELSEIF _flag = '2' THEN
			SELECT `categoria`, descripcion FROM `prod_categoria` WHERE activo ='1';
		END IF;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_categoriaproductoMantenedor` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_categoriaproductoMantenedor` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_categoriaproductoMantenedor`(
	_flag CHAR(1),
	_categoria CHAR(5),
	_descripcion VARCHAR(250),
	_activo CHAR(1),
	_usuario VARCHAR(15)
)
BEGIN
	DECLARE _xtotal INT DEFAULT 0;
		IF _flag = '1' THEN
			SELECT COUNT(*) INTO _xtotal FROM `prod_categoria` WHERE descripcion = _descripcion;
			IF _xtotal = 0 THEN
				INSERT INTO `prod_categoria`(`descripcion`,`activo`,`usuarioregistra`,`fecharegistra`)
				VALUES(_descripcion, _activo, _usuario, NOW());
				SELECT 'MSG_001' AS mensaje;
			ELSE
				SELECT 'MSG_004' AS mensaje;
			END IF;
		ELSEIF _flag = '2' THEN
			SELECT COUNT(*) INTO _xtotal FROM `prod_categoria` WHERE descripcion = _descripcion AND `categoria` <> _categoria;
			IF _xtotal = 0 THEN
				UPDATE `prod_categoria` SET
				`descripcion` = _descripcion,
				`activo` = _activo,
				`usuariomodifica` = _usuario,
				`fechamodifica` = NOW()
				WHERE 
				`categoria` = _categoria;
				SELECT 'MSG_002' AS mensaje;
			ELSE
				SELECT 'MSG_004' AS mensaje;
			END IF;
		ELSEIF _flag = '3' THEN
			SELECT COUNT(*) INTO _xtotal FROM `prod_producto` WHERE `categoria` = _categoria;
			IF _xtotal = 0 THEN
				DELETE FROM `prod_categoria` WHERE `categoria` = _categoria;
				SELECT 'MSG_003' AS mensaje;
			ELSE
				SELECT 'MSG_005' AS mensaje;
			END IF;
		END IF;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_formapagoBuscar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_formapagoBuscar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_formapagoBuscar`(IN `_criterio` VARCHAR(80), IN `_buscarPor` CHAR(1), IN `_flag` SMALLINT, IN `_pagina` INT, IN `_reg_por_pag` INT)
BEGIN
	   
    
    IF _flag='1' THEN
        SELECT COUNT(*) AS total
        FROM
        `mae_formapago` WHERE `descripcion` LIKE CONCAT('%',_criterio,'%');
    ELSE
        SET @rownum=0;
        
        SELECT 	* FROM 
        (
            SELECT @rownum:=@rownum+1 AS rownum,
                `formapago`,`descripcion`,`activo`
            FROM `mae_formapago` WHERE `descripcion` LIKE CONCAT('%',_criterio,'%')
            
        )R
        WHERE 	rownum > _reg_por_pag * (_pagina-1) AND
            rownum <= _reg_por_pag * _pagina
        ORDER BY rownum;
    END IF;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_formapagoConsultar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_formapagoConsultar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_formapagoConsultar`(
	_flag CHAR(2),
	_criterio VARCHAR(250)
)
BEGIN
	
		IF _flag = '1' THEN
			SELECT * FROM `mae_formapago` WHERE `formapago` = _criterio;
		ELSEIF _flag = '2' THEN
			SELECT `formapago`, descripcion FROM `mae_formapago` WHERE activo ='1';
		END IF;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_formapagoMantenedor` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_formapagoMantenedor` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_formapagoMantenedor`(
	_flag CHAR(1),
	_formapago CHAR(5),
	_descripcion VARCHAR(250),
	_activo CHAR(1),
	_usuario VARCHAR(15)
)
BEGIN
	DECLARE _xtotal INT DEFAULT 0;
		IF _flag = '1' THEN
			SELECT COUNT(*) INTO _xtotal FROM `mae_formapago` WHERE descripcion = _descripcion;
			IF _xtotal = 0 THEN
				INSERT INTO `mae_formapago`(`descripcion`,`activo`,`usuarioregistra`,`fecharegistra`)
				VALUES(_descripcion, _activo, _usuario, NOW());
				SELECT 'MSG_001' AS mensaje;
			ELSE
				SELECT 'MSG_004' AS mensaje;
			END IF;
		ELSEIF _flag = '2' THEN
			SELECT COUNT(*) INTO _xtotal FROM `mae_formapago` WHERE descripcion = _descripcion AND `formapago` <> _formapago;
			IF _xtotal = 0 THEN
				UPDATE `mae_formapago` SET
				`descripcion` = _descripcion,
				`activo` = _activo,
				`usuariomodifica` = _usuario,
				`fechamodifica` = NOW()
				WHERE 
				`formapago` = _formapago;
				SELECT 'MSG_002' AS mensaje;
			ELSE
				SELECT 'MSG_004' AS mensaje;
			END IF;
		ELSEIF _flag = '3' THEN
			SELECT COUNT(*) INTO _xtotal FROM `ges_venta` WHERE `formapago` = _formapago;
			IF _xtotal = 0 THEN
				DELETE FROM `mae_formapago` WHERE `formapago` = _formapago;
				SELECT 'MSG_003' AS mensaje;
			ELSE
				SELECT 'MSG_005' AS mensaje;
			END IF;
		END IF;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_marcaproductoBuscar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_marcaproductoBuscar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_marcaproductoBuscar`(IN `_criterio` VARCHAR(80), IN `_buscarPor` CHAR(1), IN `_flag` SMALLINT, IN `_pagina` INT, IN `_reg_por_pag` INT)
BEGIN
	   
    
    IF _flag='1' THEN
        SELECT COUNT(*) AS total
        FROM
        `prod_marca` WHERE `descripcion` LIKE CONCAT('%',_criterio,'%');
    ELSE
        SET @rownum=0;
        
        SELECT 	* FROM 
        (
            SELECT @rownum:=@rownum+1 AS rownum,
                `marca`,`descripcion`,`activo`
            FROM `prod_marca` WHERE `descripcion` LIKE CONCAT('%',_criterio,'%')
            
        )R
        WHERE 	rownum > _reg_por_pag * (_pagina-1) AND
            rownum <= _reg_por_pag * _pagina
        ORDER BY rownum;
    END IF;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_marcaproductoConsultar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_marcaproductoConsultar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_marcaproductoConsultar`(
	_flag CHAR(2),
	_criterio VARCHAR(250)
)
BEGIN
	
		IF _flag = '1' THEN
			SELECT * FROM `prod_marca` WHERE `marca` = _criterio;
		ELSEIF _flag = '2' THEN
			SELECT `marca`, descripcion FROM `prod_marca` WHERE activo ='1';
		END IF;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_marcaproductoMantenedor` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_marcaproductoMantenedor` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_marcaproductoMantenedor`(
	_flag CHAR(1),
	_marca CHAR(5),
	_descripcion VARCHAR(250),
	_activo CHAR(1),
	_usuario VARCHAR(15)
)
BEGIN
	DECLARE _xtotal INT DEFAULT 0;
		IF _flag = '1' THEN
			SELECT COUNT(*) INTO _xtotal FROM `prod_marca` WHERE descripcion = _descripcion;
			IF _xtotal = 0 THEN
				INSERT INTO `prod_marca`(`descripcion`,`activo`,`usuarioregistra`,`fecharegistra`)
				VALUES(_descripcion, _activo, _usuario, NOW());
				SELECT 'MSG_001' AS mensaje;
			ELSE
				SELECT 'MSG_004' AS mensaje;
			END IF;
		ELSEIF _flag = '2' THEN
			SELECT COUNT(*) INTO _xtotal FROM `prod_marca` WHERE descripcion = _descripcion AND `marca` <> _marca;
			IF _xtotal = 0 THEN
				UPDATE `prod_marca` SET
				`descripcion` = _descripcion,
				`activo` = _activo,
				`usuariomodifica` = _usuario,
				`fechamodifica` = NOW()
				WHERE 
				`marca` = _marca;
				SELECT 'MSG_002' AS mensaje;
			ELSE
				SELECT 'MSG_004' AS mensaje;
			END IF;
		ELSEIF _flag = '3' THEN
			SELECT COUNT(*) INTO _xtotal FROM `prod_producto` WHERE `marca` = _marca;
			IF _xtotal = 0 THEN
				DELETE FROM `prod_marca` WHERE `marca` = _marca;
				SELECT 'MSG_003' AS mensaje;
			ELSE
				SELECT 'MSG_005' AS mensaje;
			END IF;
		END IF;
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

/* Procedure structure for procedure `sp_modeloproductoBuscar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_modeloproductoBuscar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_modeloproductoBuscar`(IN `_criterio` VARCHAR(80), IN `_buscarPor` CHAR(1), IN `_flag` SMALLINT, IN `_pagina` INT, IN `_reg_por_pag` INT)
BEGIN
	   
    
    IF _flag='1' THEN
        SELECT COUNT(*) AS total
        FROM
        `prod_modelo` WHERE `descripcion` LIKE CONCAT('%',_criterio,'%');
    ELSE
        SET @rownum=0;
        
        SELECT 	* FROM 
        (
            SELECT @rownum:=@rownum+1 AS rownum,
                `modelo`,`descripcion`,`activo`
            FROM `prod_modelo` WHERE `descripcion` LIKE CONCAT('%',_criterio,'%')
            
        )R
        WHERE 	rownum > _reg_por_pag * (_pagina-1) AND
            rownum <= _reg_por_pag * _pagina
        ORDER BY rownum;
    END IF;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_modeloproductoConsultar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_modeloproductoConsultar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_modeloproductoConsultar`(
	_flag CHAR(2),
	_criterio VARCHAR(250)
)
BEGIN
	
		IF _flag = '1' THEN
			SELECT * FROM `prod_modelo` WHERE `modelo` = _criterio;
		ELSEIF _flag = '2' THEN
			SELECT `modelo`, descripcion FROM `prod_modelo` WHERE activo ='1';
		END IF;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_modeloproductoMantenedor` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_modeloproductoMantenedor` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_modeloproductoMantenedor`(
	_flag CHAR(1),
	_modelo CHAR(5),
	_descripcion VARCHAR(250),
	_activo CHAR(1),
	_usuario VARCHAR(15)
)
BEGIN
	DECLARE _xtotal INT DEFAULT 0;
		IF _flag = '1' THEN
			SELECT COUNT(*) INTO _xtotal FROM `prod_modelo` WHERE descripcion = _descripcion;
			IF _xtotal = 0 THEN
				INSERT INTO `prod_modelo`(`descripcion`,`activo`,`usuarioregistra`,`fecharegistra`)
				VALUES(_descripcion, _activo, _usuario, NOW());
				SELECT 'MSG_001' AS mensaje;
			ELSE
				SELECT 'MSG_004' AS mensaje;
			END IF;
		ELSEIF _flag = '2' THEN
			SELECT COUNT(*) INTO _xtotal FROM `prod_modelo` WHERE descripcion = _descripcion AND `modelo` <> _modelo;
			IF _xtotal = 0 THEN
				UPDATE `prod_modelo` SET
				`descripcion` = _descripcion,
				`activo` = _activo,
				`usuariomodifica` = _usuario,
				`fechamodifica` = NOW()
				WHERE 
				`modelo` = _modelo;
				SELECT 'MSG_002' AS mensaje;
			ELSE
				SELECT 'MSG_004' AS mensaje;
			END IF;
		ELSEIF _flag = '3' THEN
			SELECT COUNT(*) INTO _xtotal FROM `prod_producto` WHERE `modelo` = _modelo;
			IF _xtotal = 0 THEN
				DELETE FROM `prod_modelo` WHERE `modelo` = _modelo;
				SELECT 'MSG_003' AS mensaje;
			ELSE
				SELECT 'MSG_005' AS mensaje;
			END IF;
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

/* Procedure structure for procedure `sp_tallaproductoBuscar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_tallaproductoBuscar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tallaproductoBuscar`(IN `_criterio` VARCHAR(80), IN `_buscarPor` CHAR(1), IN `_flag` SMALLINT, IN `_pagina` INT, IN `_reg_por_pag` INT)
BEGIN
	   
    
    IF _flag='1' THEN
        SELECT COUNT(*) AS total
        FROM
        `prod_talla` WHERE `descripcion` LIKE CONCAT('%',_criterio,'%');
    ELSE
        SET @rownum=0;
        
        SELECT 	* FROM 
        (
            SELECT @rownum:=@rownum+1 AS rownum,
                `talla`,`descripcion`,`activo`
            FROM `prod_talla` WHERE `descripcion` LIKE CONCAT('%',_criterio,'%')
            
        )R
        WHERE 	rownum > _reg_por_pag * (_pagina-1) AND
            rownum <= _reg_por_pag * _pagina
        ORDER BY rownum;
    END IF;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_tallaproductoConsultar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_tallaproductoConsultar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tallaproductoConsultar`(
	_flag CHAR(2),
	_criterio VARCHAR(250)
)
BEGIN
	
		IF _flag = '1' THEN
			SELECT * FROM `prod_talla` WHERE `talla` = _criterio;
		ELSEIF _flag = '2' THEN
			SELECT `talla`, descripcion FROM `prod_talla` WHERE activo ='1';
		END IF;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_tallaproductoMantenedor` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_tallaproductoMantenedor` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tallaproductoMantenedor`(
	_flag CHAR(1),
	_talla CHAR(5),
	_descripcion VARCHAR(250),
	_activo CHAR(1),
	_usuario VARCHAR(15)
)
BEGIN
	DECLARE _xtotal INT DEFAULT 0;
		IF _flag = '1' THEN
			SELECT COUNT(*) INTO _xtotal FROM `prod_talla` WHERE descripcion = _descripcion;
			IF _xtotal = 0 THEN
				INSERT INTO `prod_talla`(`descripcion`,`activo`,`usuarioregistra`,`fecharegistra`)
				VALUES(_descripcion, _activo, _usuario, NOW());
				SELECT 'MSG_001' AS mensaje;
			ELSE
				SELECT 'MSG_004' AS mensaje;
			END IF;
		ELSEIF _flag = '2' THEN
			SELECT COUNT(*) INTO _xtotal FROM `prod_talla` WHERE descripcion = _descripcion AND `talla` <> _talla;
			IF _xtotal = 0 THEN
				UPDATE `prod_talla` SET
				`descripcion` = _descripcion,
				`activo` = _activo,
				`usuariomodifica` = _usuario,
				`fechamodifica` = NOW()
				WHERE 
				`talla` = _talla;
				SELECT 'MSG_002' AS mensaje;
			ELSE
				SELECT 'MSG_004' AS mensaje;
			END IF;
		ELSEIF _flag = '3' THEN
			SELECT COUNT(*) INTO _xtotal FROM `prod_producto` WHERE `talla` = _talla;
			IF _xtotal = 0 THEN
				DELETE FROM `prod_talla` WHERE `talla` = _talla;
				SELECT 'MSG_003' AS mensaje;
			ELSE
				SELECT 'MSG_005' AS mensaje;
			END IF;
		END IF;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_tarjetasBuscar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_tarjetasBuscar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tarjetasBuscar`(IN `_criterio` VARCHAR(80), IN `_buscarPor` CHAR(1), IN `_flag` SMALLINT, IN `_pagina` INT, IN `_reg_por_pag` INT)
BEGIN
	   
    
    IF _flag='1' THEN
        SELECT COUNT(*) AS total
        FROM
        `mae_tarjetas` WHERE `descripcion` LIKE CONCAT('%',_criterio,'%');
    ELSE
        SET @rownum=0;
        
        SELECT 	* FROM 
        (
            SELECT @rownum:=@rownum+1 AS rownum,
                `tarjeta`,`descripcion`,`activo`
            FROM `mae_tarjetas` WHERE `descripcion` LIKE CONCAT('%',_criterio,'%')
            
        )R
        WHERE 	rownum > _reg_por_pag * (_pagina-1) AND
            rownum <= _reg_por_pag * _pagina
        ORDER BY rownum;
    END IF;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_tarjetasConsultar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_tarjetasConsultar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tarjetasConsultar`(
	_flag CHAR(2),
	_criterio VARCHAR(250)
)
BEGIN
	
		IF _flag = '1' THEN
			SELECT * FROM `mae_tarjetas` WHERE `tarjeta` = _criterio;
		ELSEIF _flag = '2' THEN
			SELECT `tarjeta`, descripcion FROM `mae_tarjetas` WHERE activo ='1';
		END IF;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_tarjetasMantenedor` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_tarjetasMantenedor` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tarjetasMantenedor`(
	_flag CHAR(1),
	_tarjeta CHAR(5),
	_descripcion VARCHAR(250),
	_activo CHAR(1),
	_usuario VARCHAR(15)
)
BEGIN
	DECLARE _xtotal INT DEFAULT 0;
		IF _flag = '1' THEN
			SELECT COUNT(*) INTO _xtotal FROM `mae_tarjetas` WHERE descripcion = _descripcion;
			IF _xtotal = 0 THEN
				INSERT INTO `mae_tarjetas`(`descripcion`,`activo`,`usuarioregistra`,`fecharegistra`)
				VALUES(_descripcion, _activo, _usuario, NOW());
				SELECT 'MSG_001' AS mensaje;
			ELSE
				SELECT 'MSG_004' AS mensaje;
			END IF;
		ELSEIF _flag = '2' THEN
			SELECT COUNT(*) INTO _xtotal FROM `mae_tarjetas` WHERE descripcion = _descripcion AND `tarjeta` <> _tarjeta;
			IF _xtotal = 0 THEN
				UPDATE `mae_tarjetas` SET
				`descripcion` = _descripcion,
				`activo` = _activo,
				`usuariomodifica` = _usuario,
				`fechamodifica` = NOW()
				WHERE 
				`tarjeta` = _tarjeta;
				SELECT 'MSG_002' AS mensaje;
			ELSE
				SELECT 'MSG_004' AS mensaje;
			END IF;
		ELSEIF _flag = '3' THEN
			SELECT COUNT(*) INTO _xtotal FROM `ges_venta` WHERE `tarjeta` = _tarjeta;
			IF _xtotal = 0 THEN
				DELETE FROM `mae_tarjetas` WHERE `tarjeta` = _tarjeta;
				SELECT 'MSG_003' AS mensaje;
			ELSE
				SELECT 'MSG_005' AS mensaje;
			END IF;
		END IF;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_tipocomprobanteBuscar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_tipocomprobanteBuscar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tipocomprobanteBuscar`(IN `_criterio` VARCHAR(80), IN `_buscarPor` CHAR(1), IN `_flag` SMALLINT, IN `_pagina` INT, IN `_reg_por_pag` INT)
BEGIN
	   
    
    IF _flag='1' THEN
        SELECT COUNT(*) AS total
        FROM
        `mae_tipocomprobante` WHERE `descripcion` LIKE CONCAT('%',_criterio,'%');
    ELSE
        SET @rownum=0;
        
        SELECT 	* FROM 
        (
            SELECT @rownum:=@rownum+1 AS rownum,
                `tipocomprobante`,`descripcion`,`activo`
            FROM `mae_tipocomprobante` WHERE `descripcion` LIKE CONCAT('%',_criterio,'%')
            
        )R
        WHERE 	rownum > _reg_por_pag * (_pagina-1) AND
            rownum <= _reg_por_pag * _pagina
        ORDER BY rownum;
    END IF;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_tipocomprobanteConsultar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_tipocomprobanteConsultar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tipocomprobanteConsultar`(
	_flag CHAR(2),
	_criterio VARCHAR(250)
)
BEGIN
	
		IF _flag = '1' THEN
			SELECT * FROM `mae_tipocomprobante` WHERE `tipocomprobante` = _criterio;
		ELSEIF _flag = '2' THEN
			SELECT `tipocomprobante`, descripcion FROM `mae_tipocomprobante` WHERE activo ='1';
		END IF;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_tipocomprobanteMantenedor` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_tipocomprobanteMantenedor` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tipocomprobanteMantenedor`(
	_flag CHAR(1),
	_tipocomprobante CHAR(5),
	_descripcion VARCHAR(250),
	_activo CHAR(1),
	_usuario VARCHAR(15)
)
BEGIN
	DECLARE _xtotal INT DEFAULT 0;
		IF _flag = '1' THEN
			SELECT COUNT(*) INTO _xtotal FROM `mae_tipocomprobante` WHERE descripcion = _descripcion;
			IF _xtotal = 0 THEN
				INSERT INTO `mae_tipocomprobante`(tipocomprobante, `descripcion`,`activo`,`usuarioregistra`,`fecharegistra`)
				VALUES(_tipocomprobante, _descripcion, _activo, _usuario, NOW());
				SELECT 'MSG_001' AS mensaje;
			ELSE
				SELECT 'MSG_004' AS mensaje;
			END IF;
		ELSEIF _flag = '2' THEN
			SELECT COUNT(*) INTO _xtotal FROM `mae_tipocomprobante` WHERE descripcion = _descripcion AND `tipocomprobante` <> _tipocomprobante;
			IF _xtotal = 0 THEN
				UPDATE `mae_tipocomprobante` SET
				`descripcion` = _descripcion,
				`activo` = _activo,
				`usuariomodifica` = _usuario,
				`fechamodifica` = NOW()
				WHERE 
				`tipocomprobante` = _tipocomprobante;
				SELECT 'MSG_002' AS mensaje;
			ELSE
				SELECT 'MSG_004' AS mensaje;
			END IF;
		ELSEIF _flag = '3' THEN
			SELECT COUNT(*) INTO _xtotal FROM `ges_venta` WHERE `tipocomprobante` = _tipocomprobante;
			IF _xtotal = 0 THEN
				DELETE FROM `mae_tipocomprobante` WHERE `tipocomprobante` = _tipocomprobante;
				SELECT 'MSG_003' AS mensaje;
			ELSE
				SELECT 'MSG_005' AS mensaje;
			END IF;
		END IF;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_tipodocumentoBuscar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_tipodocumentoBuscar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tipodocumentoBuscar`(IN `_criterio` VARCHAR(80), IN `_buscarPor` CHAR(1), IN `_flag` SMALLINT, IN `_pagina` INT, IN `_reg_por_pag` INT)
BEGIN
	   
    
    IF _flag='1' THEN
        SELECT COUNT(*) AS total
        FROM
        `mae_tipodocumento` WHERE `descripcion` LIKE CONCAT('%',_criterio,'%');
    ELSE
        SET @rownum=0;
        
        SELECT 	* FROM 
        (
            SELECT @rownum:=@rownum+1 AS rownum,
                `tipodocumento`,`descripcion`,`activo`
            FROM `mae_tipodocumento` WHERE `descripcion` LIKE CONCAT('%',_criterio,'%')
            
        )R
        WHERE 	rownum > _reg_por_pag * (_pagina-1) AND
            rownum <= _reg_por_pag * _pagina
        ORDER BY rownum;
    END IF;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_tipodocumentoConsultar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_tipodocumentoConsultar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tipodocumentoConsultar`(
	_flag CHAR(2),
	_criterio VARCHAR(250)
)
BEGIN
	
		IF _flag = '1' THEN
			SELECT * FROM `mae_tipodocumento` WHERE `tipodocumento` = _criterio;
		ELSEIF _flag = '2' THEN
			SELECT `mae_tipodocumento`, descripcion FROM `mae_tipocomprobante` WHERE activo ='1';
		END IF;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_tipodocumentoMantenedor` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_tipodocumentoMantenedor` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tipodocumentoMantenedor`(
	_flag CHAR(1),
	_tipodocumento CHAR(5),
	_descripcion VARCHAR(250),
	_activo CHAR(1),
	_usuario VARCHAR(15)
)
BEGIN
	DECLARE _xtotal INT DEFAULT 0;
		IF _flag = '1' THEN
			SELECT COUNT(*) INTO _xtotal FROM `mae_tipodocumento` WHERE descripcion = _descripcion or `tipodocumento` = _tipodocumento;
			IF _xtotal = 0 THEN
				INSERT INTO `mae_tipodocumento`(`tipodocumento`, `descripcion`,`activo`,`usuarioregistra`,`fecharegistra`)
				VALUES(_tipodocumento, _descripcion, _activo, _usuario, NOW());
				SELECT 'MSG_001' AS mensaje;
			ELSE
				SELECT 'MSG_004' AS mensaje;
			END IF;
		ELSEIF _flag = '2' THEN
			SELECT COUNT(*) INTO _xtotal FROM `mae_tipodocumento` WHERE descripcion = _descripcion AND `tipodocumento`<> _tipodocumento;
			IF _xtotal = 0 THEN
				UPDATE `mae_tipodocumento` SET
				`descripcion` = _descripcion,
				`activo` = _activo,
				`usuariomodifica` = _usuario,
				`fechamodifica` = NOW()
				WHERE 
				`tipodocumento` = _tipodocumento;
				SELECT 'MSG_002' AS mensaje;
			ELSE
				SELECT 'MSG_004' AS mensaje;
			END IF;
		ELSEIF _flag = '3' THEN
			SELECT COUNT(*) INTO _xtotal FROM `ges_cliente` WHERE `tipodocumento` = _tipodocumento;
			IF _xtotal = 0 THEN
				DELETE FROM `mae_tipodocumento` WHERE `tipodocumento`= _tipodocumento;
				SELECT 'MSG_003' AS mensaje;
			ELSE
				SELECT 'MSG_005' AS mensaje;
			END IF;
		END IF;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_unidadmedidaproductoBuscar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_unidadmedidaproductoBuscar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_unidadmedidaproductoBuscar`(IN `_criterio` VARCHAR(80), IN `_buscarPor` CHAR(1), IN `_flag` SMALLINT, IN `_pagina` INT, IN `_reg_por_pag` INT)
BEGIN
	   
    
    IF _flag='1' THEN
        SELECT COUNT(*) AS total
        FROM
        `prod_unidadmedida` WHERE `descripcion` LIKE CONCAT('%',_criterio,'%');
    ELSE
        SET @rownum=0;
        
        SELECT 	* FROM 
        (
            SELECT @rownum:=@rownum+1 AS rownum,
                `unidadmedida`,`descripcion`,`activo`
            FROM `prod_unidadmedida` WHERE `descripcion` LIKE CONCAT('%',_criterio,'%')
            
        )R
        WHERE 	rownum > _reg_por_pag * (_pagina-1) AND
            rownum <= _reg_por_pag * _pagina
        ORDER BY rownum;
    END IF;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_unidadmedidaproductoConsultar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_unidadmedidaproductoConsultar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_unidadmedidaproductoConsultar`(
	_flag CHAR(2),
	_criterio VARCHAR(250)
)
BEGIN
	
		IF _flag = '1' THEN
			SELECT * FROM `prod_unidadmedida` WHERE `unidadmedida` = _criterio;
		ELSEIF _flag = '2' THEN
			SELECT `unidadmedida`, descripcion FROM `prod_unidadmedida` WHERE activo ='1';
		END IF;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_unidadmedidaproductoMantenedor` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_unidadmedidaproductoMantenedor` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_unidadmedidaproductoMantenedor`(
	_flag CHAR(1),
	_unidadmedida CHAR(5),
	_descripcion VARCHAR(250),
	_activo CHAR(1),
	_usuario VARCHAR(15)
)
BEGIN
	DECLARE _xtotal INT DEFAULT 0;
		IF _flag = '1' THEN
			SELECT COUNT(*) INTO _xtotal FROM `prod_unidadmedida` WHERE descripcion = _descripcion;
			IF _xtotal = 0 THEN
				INSERT INTO `prod_unidadmedida`(`descripcion`,`activo`,`usuarioregistra`,`fecharegistra`)
				VALUES(_descripcion, _activo, _usuario, NOW());
				SELECT 'MSG_001' AS mensaje;
			ELSE
				SELECT 'MSG_004' AS mensaje;
			END IF;
		ELSEIF _flag = '2' THEN
			SELECT COUNT(*) INTO _xtotal FROM `prod_unidadmedida` WHERE descripcion = _descripcion AND `unidadmedida` <> _unidadmedida;
			IF _xtotal = 0 THEN
				UPDATE `prod_unidadmedida` SET
				`descripcion` = _descripcion,
				`activo` = _activo,
				`usuariomodifica` = _usuario,
				`fechamodifica` = NOW()
				WHERE 
				`unidadmedida` = _unidadmedida;
				SELECT 'MSG_002' AS mensaje;
			ELSE
				SELECT 'MSG_004' AS mensaje;
			END IF;
		ELSEIF _flag = '3' THEN
			SELECT COUNT(*) INTO _xtotal FROM `prod_producto` WHERE `unidadmedida` = _unidadmedida;
			IF _xtotal = 0 THEN
				DELETE FROM `prod_unidadmedida` WHERE `unidadmedida` = _unidadmedida;
				SELECT 'MSG_003' AS mensaje;
			ELSE
				SELECT 'MSG_005' AS mensaje;
			END IF;
		END IF;
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
