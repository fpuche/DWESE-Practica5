
CREATE TABLE `producto` (
`id` int(11) NOT NULL primary key auto_increment,
`nombreProducto` varchar(40) NOT NULL,
`descripcionProducto` varchar(100) NOT NULL,
`precioProducto` decimal(7,2) NOT NULL,
`ivaProducto` decimal(5,2) NOT NULL,
`foto` varchar(50) NOT NULL
) ENGINE=InnoDB;


CREATE TABLE `venta` (
`id` int(11) NOT NULL primary key auto_increment,
`fecha` varchar(40) NOT NULL,
`hora` varchar(20) NOT NULL,
`pago` enum('si', 'no', 'duda') NOT NULL DEFAULT 'no',
`nombreUsuario` varchar (30) NOT NULL,
`dirUsuario` varchar(80) NOT NULL,
`precioTotal` decimal(8,2) NOT NULL
) ENGINE=InnoDB;


CREATE TABLE `detalleVenta` (
`id` int(11) NOT NULL primary key auto_increment,
`idVenta` int(11) NOT NULL,
`idProducto` int(11) NOT NULL,
`cantidad` int (11) NOT NULL,
`precioVenta` decimal(7,2) NOT NULL,
`ivaVenta` decimal(5,2) NOT NULL,
CONSTRAINT FK_id_venta FOREIGN KEY (idVenta) REFERENCES venta(id),
CONSTRAINT FK_id_producto FOREIGN KEY (idProducto) REFERENCES producto(id)
) ENGINE=InnoDB;

CREATE TABLE `paypal` (
`id` int(11) NOT NULL primary key auto_increment,
`itemname` int(11) NOT NULL,
`verifica` enum('verificado', 'no verificado', 'id no válida', 'con error') NOT NULL DEFAULT 'no verificado'
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `usuario` (
`login` varchar(30) NOT NULL primary key,
`clave` varchar(40) NOT NULL,
`nombre` varchar(30) NOT NULL,
`apellidos` varchar(60) NOT NULL,
`email` varchar(40) NOT NULL,
`fechaalta` date NOT NULL,
`isactivo` tinyint(1) NOT NULL,
`isroot` tinyint(1) NOT NULL DEFAULT 0,
`rol` enum('administrador', 'usuario') NOT NULL DEFAULT 'usuario',
`fechalogin` datetime
) ENGINE=InnoDB;