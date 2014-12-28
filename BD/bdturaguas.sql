CREATE SCHEMA GENERAL;
CREATE SCHEMA FACTURACION;
CREATE SCHEMA INVENTARIO;
CREATE SCHEMA SEGURIDAD;

CREATE SEQUENCE FACTURACION.SEQ_IMPUESTO;

CREATE TABLE FACTURACION.timpuesto(
	nid_impuesto NUMERIC NOT NULL DEFAULT NEXTVAL('FACTURACION.SEQ_IMPUESTO'),
	cdescripcion VARCHAR(20) NOT NULL,
	nporcentaje NUMERIC NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_impuesto PRIMARY KEY(nid_impuesto)
);

CREATE SEQUENCE GENERAL.SEQ_ROL;

CREATE TABLE GENERAL.trol(
	nid_rol NUMERIC NOT NULL DEFAULT NEXTVAL('GENERAL.SEQ_ROL'),
	cdescripcion VARCHAR(30) NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_rol PRIMARY KEY(nid_rol)
);

CREATE SEQUENCE FACTURACION.SEQ_TIPO_DOCUMENTO;

CREATE TABLE FACTURACION.ttipo_documento(
	nid_tipodocumento NUMERIC NOT NULL DEFAULT NEXTVAL('FACTURACION.SEQ_TIPO_DOCUMENTO'),
	cdescripcion VARCHAR(30) NOT NULL,
	nfactor NUMERIC DEFAULT 1,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_tipo_documento PRIMARY KEY(nid_tipodocumento)
);

CREATE SEQUENCE FACTURACION.SEQ_CONDICION_PAGO;

CREATE TABLE FACTURACION.tcondicion_pago(
	nid_condicionpago NUMERIC NOT NULL DEFAULT NEXTVAL('FACTURACION.SEQ_CONDICION_PAGO'),
	cdescripcion VARCHAR(30) NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pḱ_condicion_pago PRIMARY KEY(nid_condicionpago)
);

CREATE SEQUENCE GENERAL.SEQ_COMBO_VALOR;

CREATE TABLE GENERAL.tcombo_valor(
	nid_combovalor NUMERIC NOT NULL DEFAULT NEXTVAL('GENERAL.SEQ_COMBO_VALOR'),
	ctabla VARCHAR(40) NOT NULL,
	cdescripcion VARCHAR(40) NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_combovalor PRIMARY KEY(nid_combovalor)
);

CREATE SEQUENCE GENERAL.SEQ_LOCALIDAD;

CREATE TABLE GENERAL.tlocalidad(
	nid_localidad NUMERIC NOT NULL DEFAULT NEXTVAL('GENERAL.SEQ_LOCALIDAD'),
	ctabla VARCHAR(30) NOT NULL,
	cdescripcion VARCHAR(50) NOT NULL,
	nid_localidad_padre NUMERIC NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_localidad PRIMARY KEY(nid_localidad)
);

CREATE SEQUENCE FACTURACION.SEQ_LISTA_PRECIO;

CREATE TABLE FACTURACION.tlista_precio(
	nid_listaprecio NUMERIC NOT NULL DEFAULT NEXTVAL('FACTURACION.SEQ_LISTA_PRECIO'),
	cdescripcion VARCHAR(30) NOT NULL,
	dvigencia_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	dvigencia_hasta TIMESTAMP NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_lista_precio PRIMARY KEY(nid_listaprecio)
);

CREATE SEQUENCE INVENTARIO.SEQ_UBICACION;

CREATE TABLE INVENTARIO.tubicacion(
	nid_ubicacion NUMERIC NOT NULL DEFAULT NEXTVAL('INVENTARIO.SEQ_UBICACION'),
	cdescripcion VARCHAR(60) NOT NULL,
	cpunto_referencia VARCHAR(255) NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_ubicacion PRIMARY KEY(nid_ubicacion)
);

CREATE SEQUENCE INVENTARIO.SEQ_CATEGORIA;

CREATE TABLE INVENTARIO.tcategoria(
	nid_categoria NUMERIC NOT NULL DEFAULT NEXTVAL('INVENTARIO.SEQ_CATEGORIA'),
	cdescripcion VARCHAR(50) NOT NULL,
	cacumulado CHAR(1) DEFAULT 'N',
	nid_categoria_padre NUMERIC,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_categoria PRIMARY KEY(nid_categoria)
);

CREATE SEQUENCE FACTURACION.SEQ_MOTIVO_DEVOLUCION;

CREATE TABLE FACTURACION.tmotivo_devolucion(
	nid_motivodevolucion NUMERIC NOT NULL DEFAULT NEXTVAL('FACTURACION.SEQ_MOTIVO_DEVOLUCION'),
	cdescripcion VARCHAR(50) NOT NULL,
	cacumulado CHAR(1) DEFAULT 'N',
	nid_motivodevolucion_padre NUMERIC,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_motivodevolucion PRIMARY KEY(nid_motivodevolucion)
);

CREATE SEQUENCE INVENTARIO.SEQ_UM;

CREATE TABLE INVENTARIO.tunidad_medida(
	nid_unidadmedida NUMERIC NOT NULL DEFAULT NEXTVAL('INVENTARIO.SEQ_UM'),
	cdescripcion VARCHAR(30) NOT NULL,
	csimbolo CHAR(5) NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_unidad_medida PRIMARY KEY(nid_unidadmedida)
);

CREATE SEQUENCE INVENTARIO.SEQ_TIPO_ARTICULO;

CREATE TABLE INVENTARIO.ttipo_articulo(
	nid_tipoarticulo NUMERIC NOT NULL DEFAULT NEXTVAL('INVENTARIO.SEQ_TIPO_ARTICULO'),
	cdescripcion VARCHAR(30) NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_tipo_articulo PRIMARY KEY(nid_tipoarticulo)
);

CREATE SEQUENCE INVENTARIO.SEQ_PRESENTACION;

CREATE TABLE INVENTARIO.tpresentacion(
	nid_presentacion NUMERIC NOT NULL DEFAULT NEXTVAL('INVENTARIO.SEQ_PRESENTACION'),
	cdescripcion VARCHAR(60) NOT NULL,
	csimbolo CHAR(10) NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_presentacion PRIMARY KEY(nid_presentacion)
);

CREATE SEQUENCE FACTURACION.SEQ_MOTIVO_RAZON;

CREATE TABLE FACTURACION.tmotivo_razon(
	nid_motivorazon NUMERIC NOT NULL DEFAULT NEXTVAL('FACTURACION.SEQ_MOTIVO_RAZON'),
	cdescripcion VARCHAR(255) NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_motivorazon PRIMARY KEY(nid_motivorazon)
);

CREATE SEQUENCE INVENTARIO.SEQ_MARCA;

CREATE TABLE INVENTARIO.tmarca(
	nid_marca NUMERIC NOT NULL DEFAULT NEXTVAL('INVENTARIO.SEQ_MARCA'),
	cdescripcion VARCHAR(255) NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_marca PRIMARY KEY(nid_marca)
);

CREATE SEQUENCE INVENTARIO.SEQ_ALMACEN;

CREATE TABLE INVENTARIO.talmacen(
	nid_almacen NUMERIC NOT NULL DEFAULT NEXTVAL('INVENTARIO.SEQ_ALMACEN'),
	cdescripcion VARCHAR(60) NOT NULL,
	nid_ubicacion NUMERIC NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_almacen PRIMARY KEY(nid_almacen),
	CONSTRAINT fk_almacen_ubicacion FOREIGN KEY (nid_ubicacion) REFERENCES INVENTARIO.tubicacion(nid_ubicacion) ON DELETE RESTRICT ON UPDATE CASCADE 
);

CREATE TABLE GENERAL.tpersona(
	crif_persona CHAR(10) NOT NULL,
	cnombre VARCHAR(60) NOT NULL,
	cdireccion VARCHAR(60) NOT NULL,
	ctelefhab CHAR(11) NULL,
	ctelefmov CHAR(11) NULL,
	cemail VARCHAR(60) NULL ,
	ntipo_persona NUMERIC NOT NULL,
	nid_localidad NUMERIC,
	nid_rol NUMERIC,
	nid_condicionpago NUMERIC,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_persona PRIMARY KEY(crif_persona),
	CONSTRAINT fk_persona_localidad FOREIGN KEY (nid_localidad) REFERENCES GENERAL.tlocalidad(nid_localidad) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_persona_rol FOREIGN KEY(nid_rol) REFERENCES GENERAL.trol(nid_rol) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_persona_tipopersona FOREIGN KEY(ntipo_persona) REFERENCES GENERAL.tcombo_valor(nid_combovalor) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_persona_condicionpago FOREIGN KEY(nid_condicionpago) REFERENCES FACTURACION.tcondicion_pago(nid_condicionpago) ON DELETE RESTRICT ON UPDATE CASCADE 
);

CREATE SEQUENCE GENERAL.SEQ_DIRECCION;

CREATE TABLE GENERAL.tdireccion_despacho(
	nid_direcciondespacho NUMERIC NOT NULL DEFAULT NEXTVAL('GENERAL.SEQ_DIRECCION'),
	crif_persona CHAR(10) NOT NULL,
	cdireccion VARCHAR(255) NOT NULL,
	ctelefono CHAR(11) NULL,
	csede_principal CHAR(1) NOT NULL DEFAULT 'N',
	nid_localidad NUMERIC NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_direcciondespacho PRIMARY KEY(nid_direcciondespacho),
	CONSTRAINT fk_direcciondespacho_localidad FOREIGN KEY(nid_localidad) REFERENCES GENERAL.tlocalidad(nid_localidad) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE SEQUENCE GENERAL.SEQ_PERSONA_CONTACTO;

CREATE TABLE GENERAL.tpersona_contacto(
	nid_personacontacto NUMERIC NOT NULL DEFAULT NEXTVAL('GENERAL.SEQ_PERSONA_CONTACTO'),
	crif_persona CHAR(10) NOT NULL,
	nid_direcciondespacho NUMERIC NULL,
	cnombre VARCHAR(60) NOT NULL,
	ccargo VARCHAR(40) NULL,
	ctelefono CHAR(11) NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_personacontacto PRIMARY KEY(nid_personacontacto),
	CONSTRAINT fk_personacontacto_persona FOREIGN KEY(crif_persona) REFERENCES GENERAL.tpersona(crif_persona) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_personacontacto_direccion FOREIGN KEY(nid_direcciondespacho) REFERENCES GENERAL.tdireccion_despacho(nid_direcciondespacho) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE INVENTARIO.tarticulo(
	cid_articulo CHAR(15) NOT NULL,
	cdescripcion VARCHAR(60) NOT NULL,
	nid_tipoarticulo NUMERIC NOT NULL,
	nid_presentacion NUMERIC,
	nid_categoria NUMERIC,
	nid_unidadmedida NUMERIC,
	nid_marca NUMERIC,
	nid_impuesto NUMERIC,
	ncantidad_min NUMERIC NOT NULL DEFAULT 0,
	ncantidad_max NUMERIC NOT NULL DEFAULT 9999999,
	cid_articulo_final CHAR(15),
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_articulo PRIMARY KEY(cid_articulo),
	CONSTRAINT fk_articulo_tipoarticulo FOREIGN KEY(nid_tipoarticulo) REFERENCES INVENTARIO.ttipo_articulo(nid_tipoarticulo) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_articulo_presentacion FOREIGN KEY(nid_presentacion) REFERENCES INVENTARIO.tpresentacion(nid_presentacion) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_articulo_categoria FOREIGN KEY(nid_categoria) REFERENCES INVENTARIO.tcategoria(nid_categoria) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_articulo_um FOREIGN KEY(nid_unidadmedida) REFERENCES INVENTARIO.tunidad_medida(nid_unidadmedida) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_articulo_marca FOREIGN KEY(nid_marca) REFERENCES INVENTARIO.tmarca(nid_marca) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_articulo_artfinal FOREIGN KEY(cid_articulo_final) REFERENCES INVENTARIO.tarticulo(cid_articulo) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_articulo_impuesto FOREIGN KEY(nid_impuesto) REFERENCES FACTURACION.timpuesto(nid_impuesto) ON DELETE RESTRICT ON UPDATE CASCADE 
);

CREATE SEQUENCE INVENTARIO.SEQ_CONFIGURACION_ARTICULO;

CREATE TABLE INVENTARIO.tconfiguracion_articulo(
	nid_configuracionarticulo NUMERIC NOT NULL DEFAULT NEXTVAL('INVENTARIO.SEQ_CONFIGURACION_ARTICULO'),
	cid_servicio CHAR(15) NOT NULL,
	cid_insumo CHAR(15) NOT NULL,
	ncantidad NUMERIC DEFAULT 0,
	nmerma NUMERIC DEFAULT 0,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_configuracionarticulo PRIMARY KEY(nid_configuracionarticulo),
	CONSTRAINT uk_servicio_insumo UNIQUE(cid_servicio,cid_insumo),
	CONSTRAINT fk_configuracion_servicio FOREIGN KEY(cid_servicio) REFERENCES INVENTARIO.tarticulo(cid_articulo) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_configuracion_insumo FOREIGN KEY(cid_insumo) REFERENCES INVENTARIO.tarticulo(cid_articulo) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE SEQUENCE INVENTARIO.SEQ_UM_CONVERSION;

CREATE TABLE INVENTARIO.tum_conversion(
	nid_um_conversion NUMERIC NOT NULL DEFAULT NEXTVAL('INVENTARIO.SEQ_UM_CONVERSION'),
	cid_articulo CHAR(15) NOT NULL,
	nid_um_desde NUMERIC NOT NULL,
	nid_um_hasta NUMERIC NOT NULL,
	nfactor_multiplicador NUMERIC DEFAULT 0,
	nfactor_divisor NUMERIC DEFAULT 0,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_um_conversion PRIMARY KEY(nid_um_conversion),
	CONSTRAINT fk_conversion_articulo FOREIGN KEY(cid_articulo) REFERENCES INVENTARIO.tarticulo(cid_articulo) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_conversion_umdesde FOREIGN KEY(nid_um_desde) REFERENCES INVENTARIO.tunidad_medida(nid_unidadmedida) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_conversion_umhasta FOREIGN KEY(nid_um_hasta) REFERENCES INVENTARIO.tunidad_medida(nid_unidadmedida) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE SEQUENCE INVENTARIO.SEQ_INVENTARIO;

CREATE TABLE INVENTARIO.tinventario(
	nid_inventario NUMERIC NOT NULL DEFAULT NEXTVAL('INVENTARIO.SEQ_INVENTARIO'),
	cid_articulo CHAR(15) NOT NULL,
	nid_almacen NUMERIC NOT NULL,
	nexistencia NUMERIC NOT NULL DEFAULT 0,
	nestatus_inventario NUMERIC NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_inventario PRIMARY KEY(nid_inventario),
	CONSTRAINT fk_inventario_combovalor FOREIGN KEY(nestatus_inventario) REFERENCES GENERAL.tcombo_valor(nid_combovalor) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_inventario_articulo FOREIGN KEY(cid_articulo) REFERENCES INVENTARIO.tarticulo(cid_articulo) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_inventario_almacen FOREIGN KEY(nid_almacen) REFERENCES INVENTARIO.talmacen(nid_almacen) ON DELETE RESTRICT ON UPDATE CASCADE 
);

CREATE SEQUENCE FACTURACION.SEQ_DOCUMENTO;

CREATE TABLE FACTURACION.tdocumento(
	nid_documento NUMERIC NOT NULL DEFAULT NEXTVAL('FACTURACION.SEQ_DOCUMENTO'),
	dfecha_documento TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	ctipo_transaccion CHAR(1) NOT NULL DEFAULT 'V',
	nid_tipodocumento NUMERIC NOT NULL,
	crif_persona CHAR(10) NOT NULL,
	nid_direcciondespacho NUMERIC NOT NULL,
	nnro_orden CHAR(11) NULL,
	nnro_ent_recib CHAR(11) NULL,
	dfecha_ent_recib TIMESTAMP NULL,
	cestado_documento CHAR(2) NOT NULL DEFAULT 'DR',
	caccion_documento CHAR(2) NOT NULL DEFAULT 'CO',
	nmonto_total NUMERIC DEFAULT 0,
	nid_condicionpago NUMERIC NOT NULL,
	nid_motivorazon NUMERIC NULL,
	nid_almacen NUMERIC NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_documento PRIMARY KEY(nid_documento),
	CONSTRAINT fk_documento_tipodocumento FOREIGN KEY(nid_tipodocumento) REFERENCES FACTURACION.ttipo_documento(nid_tipodocumento) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_documento_persona FOREIGN KEY(crif_persona) REFERENCES GENERAL.tpersona(crif_persona) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_documento_direcciondespacho FOREIGN KEY(nid_direcciondespacho) REFERENCES GENERAL.tdireccion_despacho(nid_direcciondespacho) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_documento_condicionpago FOREIGN KEY(nid_condicionpago) REFERENCES FACTURACION.tcondicion_pago(nid_condicionpago) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_documento_motivorazon FOREIGN KEY(nid_motivorazon) REFERENCES FACTURACION.tmotivo_razon(nid_motivorazon) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_documento_almance FOREIGN KEY(nid_almacen) REFERENCES INVENTARIO.talmacen(nid_almacen) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT uk_documento_ordens UNIQUE(nnro_orden,nnro_ent_recib,ctipo_transaccion)
);

CREATE SEQUENCE FACTURACION.SEQ_DEVOLUCION;

CREATE TABLE FACTURACION.tdevolucion(
	nid_devolucion NUMERIC NOT NULL DEFAULT NEXTVAL('FACTURACION.SEQ_DEVOLUCION'),
	nid_documento NUMERIC NOT NULL,
	dfecha_devolucion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	cestado_devolucion CHAR(2) NOT NULL DEFAULT 'DR',
	caccion_devolucion CHAR(2) NOT NULL DEFAULT 'CO',
	nid_motivorazon NUMERIC,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_devolucion PRIMARY KEY(nid_devolucion),
	CONSTRAINT fk_devolucion_documento FOREIGN KEY(nid_documento) REFERENCES FACTURACION.tdocumento(nid_documento) ON DELETE RESTRICT ON UPDATE CASCADE, 
	CONSTRAINT fk_devolucion_motivorazon FOREIGN KEY(nid_motivorazon) REFERENCES FACTURACION.tmotivo_razon(nid_motivorazon) ON DELETE RESTRICT ON UPDATE CASCADE,
);

CREATE SEQUENCE FACTURACION.SEQ_DET_DEVOLUCION;

CREATE TABLE FACTURACION.tdetalle_devolucion(
	nid_detalledevolucion NUMERIC NOT NULL DEFAULT NEXTVAL('FACTURACION.SEQ_DET_DEVOLUCION'),
	nid_devolucion NUMERIC NOT NULL,
	nid_motivodevolucion NUMERIC NOT NULL,
	cid_articulo CHAR(15) NOT NULL,
	ncantidad_articulo NUMERIC,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_detalledevolucion PRIMARY KEY(nid_detalledevolucion),
	CONSTRAINT fk_detalledevolucion_devolucion FOREIGN KEY(nid_devolucion) REFERENCES FACTURACION.tdevolucion(nid_devolucion) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_detalledevolucion_articulo FOREIGN KEY(cid_articulo) REFERENCES INVENTARIO.tarticulo(cid_articulo) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_detalledevolucion_motivo FOREIGN KEY(nid_motivodevolucion) REFERENCES FACTURACION.tmotivo_devolucion(nid_motivodevolucion) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE SEQUENCE INVENTARIO.SEQ_MOV_INVENTARIO;

CREATE TABLE INVENTARIO.tmovimiento_inventario(
	nid_movinventario NUMERIC NOT NULL DEFAULT NEXTVAL('INVENTARIO.SEQ_MOV_INVENTARIO'),
	nid_documento NUMERIC,
	nid_devolucion NUMERIC,
	dfecha_movinventario TIMESTAMP,
	ctipo_movinventario CHAR(1) NOT NULL DEFAULT 'E',
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_movinventario PRIMARY KEY(nid_movinventario),
	CONSTRAINT fk_movinventario_documento FOREIGN KEY(nid_documento) REFERENCES FACTURACION.tdocumento(nid_documento) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_movinventario_devolucion FOREIGN KEY(nid_devolucion) REFERENCES FACTURACION.tdevolucion(nid_devolucion) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE SEQUENCE FACTURACION.SEQ_DET_LISTAPRECIO;

CREATE TABLE FACTURACION.tdetalle_lista_precio(
	nid_detallelistaprecio NUMERIC NOT NULL DEFAULT NEXTVAL('FACTURACION.SEQ_DET_LISTAPRECIO'),
	nid_listaprecio NUMERIC NOT NULL,
	cid_articulo CHAR(15) NOT NULL,
	nprecio NUMERIC DEFAULT 0,
	nprecio_limite NUMERIC DEFAULT 0,
	ndescuento NUMERIC DEFAULT 0,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL
	CONSTRAINT pk_detallelistaprecio PRIMARY KEY(nid_detallelistaprecio),
	CONSTRAINT fk_detalleprecio_listaprecio FOREIGN KEY(nid_listaprecio) REFERENCES FACTURACION.tlista_precio(nid_listaprecio) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_detalleprecio_articulo FOREIGN KEY(cid_articulo) REFERENCES INVENTARIO.tarticulo(cid_articulo) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE SEQUENCE FACTURACION.SEQ_DET_DOCUMENTO;

CREATE TABLE FACTURACION.tdetalle_documento(
	nid_detalledocumento NUMERIC NOT NULL DEFAULT NEXTVAL('FACTURACION.SEQ_DET_DOCUMENTO'),
	nid_documento NUMERIC NOT NULL,
	cid_articulo CHAR(15) NOT NULL,
	ncantidad_articulo NUMERIC NOT NULL DEFAULT 0,
	nid_impuesto NUMERIC NOT NULL,
	nprecio NUMERIC DEFAULT 0,
	npreciolista NUMERIC DEFAULT 0,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_detalledocumento PRIMARY KEY(nid_detalledocumento),
	CONSTRAINT fk_detalledocumento_documento FOREIGN KEY(nid_documento) REFERENCES FACTURACION.tdocumento(nid_documento) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_detalledocumento_articulo FOREIGN KEY(cid_articulo) REFERENCES INVENTARIO.tarticulo(cid_articulo) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_detalledocumento_impuesto FOREIGN KEY(nid_impuesto) REFERENCES FACTURACION.timpuesto(nid_impuesto) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE SEQUENCE INVENTARIO.SEQ_DET_MOVIMIENTO_INV;

CREATE TABLE INVENTARIO.tdetalle_movimiento_inventario(
	nid_detallemovimientoinventario NUMERIC NOT NULL DEFAULT NEXTVAL('INVENTARIO.SEQ_DET_MOVIMIENTO_INV'),
	nid_movinventario NUMERIC NOT NULL,
	cid_articulo CHAR(15) NOT NULL,
	nid_inventario NUMERIC NOT NULL,
	ncantidad NUMERIC DEFAULT 0,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_detallemovinv PRIMARY KEY(nid_detallemovimientoinventario),
	CONSTRAINT fk_detallemovinv_movinventario FOREIGN KEY(nid_movinventario) REFERENCES INVENTARIO.tmovimiento_inventario(nid_movinventario) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_detallemovinv_articulo FOREIGN KEY(cid_articulo) REFERENCES INVENTARIO.tarticulo(cid_articulo) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_detallemovinv_inventario FOREIGN KEY(nid_inventario) REFERENCES INVENTARIO.tinventario(nid_inventario) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE SEGURIDAD.tsistema(
	crif_empresa CHAR(10) NOT NULL,
	cnombre_empresa VARCHAR(200) NOT NULL,
	ctlf_empresa CHAR(11) NOT NULL,
	cemail_empresa VARCHAR(60) NULL,
	cclave_email_empresa VARCHAR(60) NULL,
	cdireccion_empresa VARCHAR(150) NOT NULL,
	cmision TEXT,
	cvision TEXT, 
	cobjetivo TEXT,
	chistoria TEXT, 
	nid_localidad NUMERIC NOT NULL,
	CONSTRAINT pk_sistema PRIMARY KEY(crif_empresa),
	CONSTRAINT fk_sistema_localidad FOREIGN KEY(nid_localidad) REFERENCES GENERAL.tlocalidad(nid_localidad) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE SEQUENCE SEGURIDAD.SEQ_BITACORA;

CREATE TABLE SEGURIDAD.tbitacora (
	nid_bitacora NUMERIC NOT NULL DEFAULT NEXTVAL('SEGURIDAD.SEQ_BITACORA'),
	cip VARCHAR(15) NOT NULL,
	cso VARCHAR(50) NOT NULL,
	cnavegador VARCHAR(35) NOT NULL,
	cusuario_base_de_datos VARCHAR(60) NOT NULL,
	cusuario_aplicacion CHAR(15) NOT NULL,
	cquery TEXT NOT NULL,
	dfecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT pk_bitacora PRIMARY KEY(nid_bitacora)
);

CREATE SEQUENCE SEGURIDAD.SEQ_CONFIGURACION;

CREATE TABLE SEGURIDAD.tconfiguracion(
	nid_configuracion NUMERIC NOT NULL DEFAULT NEXTVAL('SEGURIDAD.SEQ_CONFIGURACION'),
	cdescripcion VARCHAR(30) NOT NULL,
	nlongitud_minclave NUMERIC NOT NULL DEFAULT 6,
	nlongitud_maxclave NUMERIC NOT NULL DEFAULT 10,
	ncantidad_letrasmayusculas NUMERIC NOT NULL DEFAULT 1,
	ncantidad_letrasminusculas NUMERIC NOT NULL DEFAULT 5,
	ncantidad_caracteresespeciales NUMERIC NOT NULL DEFAULT 1,
	ncantidad_numeros NUMERIC NOT NULL DEFAULT 3,
	ndias_vigenciaclave NUMERIC NOT NULL DEFAULT 180,
	ndias_aviso NUMERIC NOT NULL DEFAULT 15,
	nintentos_fallidos NUMERIC NOT NULL DEFAULT 3,
	nnumero_preguntas NUMERIC NOT NULL DEFAULT 3,
	nnumero_respuestasaresponder NUMERIC NOT NULL DEFAULT 3,
	CONSTRAINT pk_configuracion PRIMARY KEY(nid_configuracion)
);

CREATE SEQUENCE SEGURIDAD.SEQ_MODULO;

CREATE TABLE SEGURIDAD.tmodulo (
	nid_modulo NUMERIC NOT NULL DEFAULT NEXTVAL('SEGURIDAD.SEQ_MODULO'),
	cnombremodulo VARCHAR(70) NOT NULL,
	cicono VARCHAR(200) NOT NULL DEFAULT 'icon-list-alt',
	norden NUMERIC DEFAULT 0,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
  	CONSTRAINT pk_modulo PRIMARY KEY(nid_modulo)
);

CREATE SEQUENCE SEGURIDAD.SEQ_OPCION;

CREATE TABLE SEGURIDAD.topcion (
	nid_opcion NUMERIC NOT NULL DEFAULT NEXTVAL('SEGURIDAD.SEQ_OPCION'),
	cnombreopcion VARCHAR(45) NOT NULL,
	norden NUMERIC NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_opcion PRIMARY KEY(nid_opcion)
);

CREATE SEQUENCE SEGURIDAD.SEQ_PERFIL;

CREATE TABLE SEGURIDAD.tperfil (
	nid_perfil NUMERIC NOT NULL DEFAULT NEXTVAL('SEGURIDAD.SEQ_PERFIL'),
	cnombreperfil VARCHAR(45) NOT NULL,
	nid_configuracion NUMERIC NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_perfil PRIMARY KEY(nid_perfil),
	CONSTRAINT fk_perfil_configuracion FOREIGN KEY(nid_configuracion) REFERENCES SEGURIDAD.tconfiguracion(nid_configuracion) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE SEGURIDAD.tusuario (
	cnombreusuario CHAR(15) NOT NULL,
	ccedula CHAR(10) NOT NULL,
	nid_perfil NUMERIC NOT NULL,
	nintentos_fallidos NUMERIC NOT NULL DEFAULT 0,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_usuario PRIMARY KEY(cnombreusuario),
	CONSTRAINT fk_usuario_perfil FOREIGN KEY(nid_perfil) REFERENCES SEGURIDAD.tperfil(nid_perfil) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE SEGURIDAD.tcontrasena (
  	cnombreusuario CHAR(15) NOT NULL,
  	ccontrasena VARCHAR(60) NOT NULL,
  	nestado NUMERIC NOT NULL DEFAULT 3,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT fk_contrasena_usuario FOREIGN KEY(cnombreusuario) REFERENCES SEGURIDAD.tusuario(cnombreusuario) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE SEGURIDAD.trespuesta_secreta(
	cnombreusuario CHAR(15) NOT NULL,
	cpregunta VARCHAR(60) NOT NULL,
	crespuesta VARCHAR(60) NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_respuesta_pregunta_usuario PRIMARY KEY(cpregunta,cnombreusuario),
	CONSTRAINT fk_respuesta_usuario FOREIGN KEY(cnombreusuario) REFERENCES SEGURIDAD.tusuario(cnombreusuario) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE SEQUENCE SEGURIDAD.SEQ_FORMULARIO;

CREATE TABLE SEGURIDAD.tformulario (
	nid_formulario NUMERIC NOT NULL DEFAULT NEXTVAL('SEGURIDAD.SEQ_FORMULARIO'),
	cnombreformulario VARCHAR(45) NOT NULL,
	nid_modulo NUMERIC NOT NULL,
	curl VARCHAR(50) DEFAULT NULL,
	norden NUMERIC DEFAULT 0,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_formulario PRIMARY KEY(nid_formulario),
	CONSTRAINT fk_formulario_modulo FOREIGN KEY(nid_modulo) REFERENCES SEGURIDAD.tmodulo(nid_modulo) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE SEQUENCE SEGURIDAD.SEQ_SERVICIO;

CREATE TABLE SEGURIDAD.tservicio (
	nid_servicio NUMERIC NOT NULL DEFAULT NEXTVAL('SEGURIDAD.SEQ_SERVICIO'),
	cnombreservicio VARCHAR(45) NOT NULL,
	nid_formulario NUMERIC NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_servicio PRIMARY KEY(nid_servicio),
	CONSTRAINT fk_servicio_formulario FOREIGN KEY(nid_formulario) REFERENCES SEGURIDAD.tformulario(nid_formulario) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE SEGURIDAD.tdetalleservicio_perfil_opcion(
	nid_opcion NUMERIC NOT NULL,
	nid_servicio NUMERIC NOT NULL,
	nid_perfil NUMERIC NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT fk_opcion FOREIGN KEY(nid_opcion) REFERENCES SEGURIDAD.topcion(nid_opcion) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_servicio FOREIGN KEY(nid_servicio) REFERENCES SEGURIDAD.tservicio(nid_servicio) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_perfil FOREIGN KEY(nid_perfil) REFERENCES SEGURIDAD.tperfil(nid_perfil) ON DELETE RESTRICT ON UPDATE CASCADE
);


--NEW CHANGES 

CREATE SEQUENCE FACTURACION.SEQ_DOCUMENTOCOMPRA;

CREATE TABLE FACTURACION.tdocumentocompra(
	nid_documentocompra NUMERIC NOT NULL DEFAULT NEXTVAL('FACTURACION.SEQ_DOCUMENTOCOMPRA'),
	dfecha_documento TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	nid_tipodocumento NUMERIC NOT NULL,
	nnro_solicitud CHAR(10) NULL,
	nnro_recepcion CHAR(10) NULL,
	dfecha_recepcion TIMESTAMP NULL,
    crif_persona CHAR(10) NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_documentocompra PRIMARY KEY(nid_documentocompra),
	CONSTRAINT fk_documento_tipodocumento FOREIGN KEY(nid_tipodocumento) REFERENCES FACTURACION.ttipo_documento(nid_tipodocumento) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_documentocompra_proveedor FOREIGN KEY(crif_persona) REFERENCES GENERAL.tpersona(crif_persona) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT uk_documentocompra UNIQUE(nnro_solicitud,nnro_recepcion)
);

CREATE SEQUENCE FACTURACION.SEQ_DET_DOCUMENTOCOMPRA;

CREATE TABLE FACTURACION.tdetalle_documentocompra(
	nid_detalledocumentocompra NUMERIC NOT NULL DEFAULT NEXTVAL('FACTURACION.SEQ_DET_DOCUMENTOCOMPRA'),
	nid_documentocompra NUMERIC NOT NULL,
    nlinea NUMERIC NOT NULL,
	cid_articulo CHAR(15) NOT NULL,
	ncantidad_articulo NUMERIC NOT NULL DEFAULT 0,
    nid_almacen NUMERIC NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_detalledocumentocompra PRIMARY KEY(nid_detalledocumentocompra),
	CONSTRAINT fk_detalledocumento_documento FOREIGN KEY(nid_documentocompra) REFERENCES FACTURACION.tdocumentocompra(nid_documentocompra) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_detalledocumento_articulo FOREIGN KEY(cid_articulo) REFERENCES INVENTARIO.tarticulo(cid_articulo) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_detalledocumento_almacen FOREIGN KEY(nid_almacen) REFERENCES INVENTARIO.talmacen(nid_almacen) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE VIEW facturacion.vw_solicitudcompra AS 
SELECT dc.nid_documentocompra,nid_tipodocumento,dfecha_documento,nnro_solicitud,nid_detalledocumentocompra,
nlinea,cid_articulo,ncantidad_articulo,dc.dfecha_desactivacion 
FROM facturacion.tdocumentocompra dc 
INNER JOIN facturacion.tdetalle_documentocompra ddc ON dc.nid_documentocompra=ddc.nid_documentocompra 
WHERE dc.nnro_recepcion IS NULL

CREATE VIEW facturacion.vw_recepcion AS 
SELECT dc.nid_documentocompra,nid_tipodocumento,dfecha_documento,nnro_solicitud,nnro_recepcion,dfecha_recepcion,
nid_detalledocumentocompra,nlinea,cid_articulo,ncantidad_articulo,dc.crif_persona  
FROM facturacion.tdocumentocompra dc 
INNER JOIN facturacion.tdetalle_documentocompra ddc ON dc.nid_documentocompra=ddc.nid_documentocompra 
WHERE dc.nnro_recepcion IS NOT NULL

CREATE SEQUENCE FACTURACION.SEQ_DOCUMENTOVENTA;

CREATE TABLE FACTURACION.tdocumentoventa(
	nid_documentoventa NUMERIC NOT NULL DEFAULT NEXTVAL('FACTURACION.SEQ_DOCUMENTOVENTA'),
	dfecha_documento TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	nid_tipodocumento NUMERIC NOT NULL,
	nnro_cotizacion CHAR(10) NULL,
	nnro_entrega CHAR(10) NULL,
	dfecha_entrega TIMESTAMP NULL,
    nid_condicionpago NUMERIC NOT NULL,
    crif_persona CHAR(10) NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_documentoventa PRIMARY KEY(nid_documentoventa),
	CONSTRAINT fk_documento_tipodocumento FOREIGN KEY(nid_tipodocumento) REFERENCES FACTURACION.ttipo_documento(nid_tipodocumento) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_documento_condicionpago FOREIGN KEY(nid_condicionpago) REFERENCES FACTURACION.tcondicion_pago(nid_condicionpago) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_documento_cliente FOREIGN KEY(crif_persona) REFERENCES GENERAL.tpersona(crif_persona) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT uk_documentoventa UNIQUE(nnro_cotizacion,nnro_entrega)
);

CREATE SEQUENCE FACTURACION.SEQ_DET_DOCUMENTOVENTA;

CREATE TABLE FACTURACION.tdetalle_documentoventa(
	nid_detalledocumentoventa NUMERIC NOT NULL DEFAULT NEXTVAL('FACTURACION.SEQ_DET_DOCUMENTOVENTA'),
	nid_documentoventa NUMERIC NOT NULL,
    nlinea NUMERIC NOT NULL,
	cid_articulo CHAR(15) NOT NULL,
	ncantidad_articulo NUMERIC NOT NULL DEFAULT 0,
    nprecio NUMERIC NOT NULL DEFAULT 0,
    nid_almacen NUMERIC NOT NULL,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_detalledocumentoventa PRIMARY KEY(nid_detalledocumentoventa),
	CONSTRAINT fk_detalledocumento_documentoventa FOREIGN KEY(nid_documentoventa) REFERENCES FACTURACION.tdocumentoventa(nid_documentoventa) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_detalledocumento_articulo FOREIGN KEY(cid_articulo) REFERENCES INVENTARIO.tarticulo(cid_articulo) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_detalledocumento_almacen FOREIGN KEY(nid_almacen) REFERENCES INVENTARIO.talmacen(nid_almacen) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE VIEW facturacion.vw_cotizacion AS 
SELECT dc.nid_documentoventa,nid_tipodocumento,dfecha_documento,nnro_cotizacion,nid_condicionpago,crif_persona,
nid_detalledocumentoventa,nlinea,cid_articulo,ncantidad_articulo,nprecio,(ncantidad_articulo*nprecio) nneto_linea,
nid_almacen,dc.dfecha_desactivacion 
FROM facturacion.tdocumentoventa dc 
INNER JOIN facturacion.tdetalle_documentoventa ddc ON dc.nid_documentoventa=ddc.nid_documentoventa 
WHERE dc.nnro_entrega IS NULL

CREATE VIEW facturacion.vw_entrega AS 
SELECT dc.nid_documentoventa,nid_tipodocumento,dfecha_documento,nnro_cotizacion,nnro_entrega,dfecha_entrega,
nid_condicionpago,crif_persona,nid_detalledocumentoventa,nlinea,cid_articulo,ncantidad_articulo,nprecio,
(ncantidad_articulo*nprecio) nneto_linea,nid_almacen,dc.dfecha_desactivacion 
FROM facturacion.tdocumentoventa dc 
INNER JOIN facturacion.tdetalle_documentoventa ddc ON dc.nid_documentoventa=ddc.nid_documentoventa 
WHERE dc.nnro_entrega IS NOT NULL

CREATE TABLE FACTURACION.tdevolucion(
	nid_devolucion NUMERIC NOT NULL DEFAULT NEXTVAL('FACTURACION.SEQ_DEVOLUCION'),
    nnro_devolucion CHAR(10) NOT NULL,
	nid_documentocompra NUMERIC NULL,
    nid_documentoventa NUMERIC NULL,
	dfecha_devolucion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_devolucion PRIMARY KEY(nid_devolucion),
    CONSTRAINT uk_nro_devolucion UNIQUE(nnro_devolucion,nid_documentocompra,nid_documentoventa),
	CONSTRAINT fk_devolucion_documentocompra FOREIGN KEY(nid_documentocompra) REFERENCES FACTURACION.tdocumentocompra(nid_documentocompra) ON DELETE RESTRICT ON UPDATE CASCADE, 
    CONSTRAINT fk_devolucion_documentoventa FOREIGN KEY(nid_documentoventa) REFERENCES FACTURACION.tdocumentoventa(nid_documentoventa) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE FACTURACION.tdetalle_devolucion(
	nid_detalledevolucion NUMERIC NOT NULL DEFAULT NEXTVAL('FACTURACION.SEQ_DET_DEVOLUCION'),
	nid_devolucion NUMERIC NOT NULL,
	nid_motivodevolucion NUMERIC NOT NULL,
	cid_articulo CHAR(15) NOT NULL,
	ncantidad_articulo NUMERIC,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_detalledevolucion PRIMARY KEY(nid_detalledevolucion),
	CONSTRAINT fk_detalledevolucion_devolucion FOREIGN KEY(nid_devolucion) REFERENCES FACTURACION.tdevolucion(nid_devolucion) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_detalledevolucion_articulo FOREIGN KEY(cid_articulo) REFERENCES INVENTARIO.tarticulo(cid_articulo) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_detalledevolucion_motivo FOREIGN KEY(nid_motivodevolucion) REFERENCES FACTURACION.tmotivo_devolucion(nid_motivodevolucion) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE OR REPLACE VIEW facturacion.vw_devolucion_proveedor AS 
SELECT d.nid_devolucion,d.nnro_devolucion,d.nid_documentocompra,
d.dfecha_devolucion,dd.nid_detalledevolucion,dd.nid_motivodevolucion,dd.cid_articulo,
dd.ncantidad_articulo,r.crif_persona,d.dfecha_desactivacion 
FROM facturacion.tdevolucion d 
INNER JOIN facturacion.tdetalle_devolucion dd ON d.nid_devolucion = dd.nid_devolucion 
INNER JOIN facturacion.vw_recepcion r ON d.nid_documentocompra = r.nid_documentocompra 
WHERE d.nid_documentoventa IS NULL;

CREATE OR REPLACE VIEW facturacion.vw_devolucion_cliente AS 
SELECT d.nid_devolucion,d.nnro_devolucion,d.nid_documentoventa,
d.dfecha_devolucion,dd.nid_detalledevolucion,dd.nid_motivodevolucion,dd.cid_articulo,
dd.ncantidad_articulo,r.crif_persona,d.dfecha_desactivacion 
FROM facturacion.tdevolucion d 
INNER JOIN facturacion.tdetalle_devolucion dd ON d.nid_devolucion = dd.nid_devolucion 
INNER JOIN facturacion.vw_entrega r ON d.nid_documentoventa = r.nid_documentoventa 
WHERE d.nid_documentocompra IS NULL; 


CREATE OR REPLACE VIEW inventario.vw_produccion AS 
SELECT p.nid_produccion,p.nnro_produccion,p.dfecha_documento,
p.cid_articulo productoterminado,p.ncantidad cantidad_a_producir,
dp.nid_detalleproduccion,dp.cid_insumo materiaprima,dp.ncantidad cantidad_usada,
p.dfecha_desactivacion 
FROM inventario.tproduccion p 
INNER JOIN inventario.tdetalle_produccion dp ON p.nid_produccion = dp.nid_produccion 

CREATE TABLE INVENTARIO.tmovimiento_inventario(
	nid_movinventario NUMERIC NOT NULL DEFAULT NEXTVAL('INVENTARIO.SEQ_MOV_INVENTARIO'),
	nid_documentocompra NUMERIC,
    nid_documentoventa NUMERIC,
	nid_devolucion NUMERIC,
	dfecha_movinventario TIMESTAMP,
	ctipo_movinventario CHAR(1) NOT NULL DEFAULT 'E',
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_movinventario PRIMARY KEY(nid_movinventario),
	CONSTRAINT fk_movinventario_documentocompra FOREIGN KEY(nid_documentocompra) REFERENCES FACTURACION.tdocumentocompra(nid_documentocompra) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_movinventario_documentoventa FOREIGN KEY(nid_documentoventa) REFERENCES FACTURACION.tdocumentoventa(nid_documentoventa) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_movinventario_devolucion FOREIGN KEY(nid_devolucion) REFERENCES FACTURACION.tdevolucion(nid_devolucion) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE INVENTARIO.tdetalle_movimiento_inventario(
	nid_detallemovimientoinventario NUMERIC NOT NULL DEFAULT NEXTVAL('INVENTARIO.SEQ_DET_MOVIMIENTO_INV'),
	nid_movinventario NUMERIC NOT NULL,
	cid_articulo CHAR(15) NOT NULL,
	nid_inventario NUMERIC NOT NULL,
	ncantidad NUMERIC DEFAULT 0,
	dfecha_desactivacion TIMESTAMP NULL,
	dcreado_desde TIMESTAMP,
	ccreado_por CHAR(15) NULL,
	dmodificado_desde TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cmodificado_por CHAR(15) NULL,
	CONSTRAINT pk_detallemovinv PRIMARY KEY(nid_detallemovimientoinventario),
	CONSTRAINT fk_detallemovinv_movinventario FOREIGN KEY(nid_movinventario) REFERENCES INVENTARIO.tmovimiento_inventario(nid_movinventario) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_detallemovinv_articulo FOREIGN KEY(cid_articulo) REFERENCES INVENTARIO.tarticulo(cid_articulo) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_detallemovinv_inventario FOREIGN KEY(nid_inventario) REFERENCES INVENTARIO.tinventario(nid_inventario) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE SEQUENCE facturacion.seq_reembolso;

CREATE TABLE facturacion.treembolso
(
  nid_reembolso numeric NOT NULL DEFAULT nextval('facturacion.seq_reembolso'::regclass),
  nnro_reembolso character(10),
  dfecha_documento timestamp without time zone NOT NULL DEFAULT now(),
  ctipo_transaccion char(1) NOT NULL DEFAULT 'C',
  nid_tipodocumento numeric NOT NULL,
  nid_devolucion numeric NOT NULL,
  crif_persona character(10),
  dfecha_desactivacion timestamp without time zone,
  dcreado_desde timestamp without time zone,
  ccreado_por character(15),
  dmodificado_desde timestamp without time zone DEFAULT now(),
  cmodificado_por character(15),
  CONSTRAINT pk_reembolso PRIMARY KEY (nid_reembolso),
  CONSTRAINT fk_reembolso_tipodocumento FOREIGN KEY (nid_tipodocumento)
      REFERENCES facturacion.ttipo_documento (nid_tipodocumento) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_reembolso_persona FOREIGN KEY (crif_persona)
      REFERENCES general.tpersona (crif_persona) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT uk_reembolso UNIQUE (nid_tipodocumento, nid_devolucion)
);

CREATE SEQUENCE facturacion.seq_det_reembolso;

CREATE TABLE facturacion.tdetalle_reembolso
(
  nid_detallereembolso numeric NOT NULL DEFAULT nextval('facturacion.seq_det_reembolso'::regclass),
  nid_reembolso numeric NOT NULL,
  nlinea numeric NOT NULL,
  cid_articulo character(15) NOT NULL,
  ncantidad_articulo numeric NOT NULL DEFAULT 0,
  dfecha_desactivacion timestamp without time zone,
  dcreado_desde timestamp without time zone,
  ccreado_por character(15),
  dmodificado_desde timestamp without time zone DEFAULT now(),
  cmodificado_por character(15),
  CONSTRAINT pk_detallereembolso PRIMARY KEY (nid_detallereembolso),
  CONSTRAINT fk_detallereembolso_articulo FOREIGN KEY (cid_articulo)
      REFERENCES inventario.tarticulo (cid_articulo) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_detallereembolso_reembolso FOREIGN KEY (nid_reembolso)
      REFERENCES facturacion.treembolso (nid_reembolso) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE OR REPLACE VIEW facturacion.vw_reembolso_proveedor AS 
SELECT r.nid_reembolso,r.nnro_reembolso,r.dfecha_documento,r.ctipo_transaccion,r.nid_tipodocumento,r.nid_devolucion,
r.crif_persona,r.dfecha_desactivacion,dr.nid_detallereembolso,dr.nlinea,dr.cid_articulo,dr.ncantidad_articulo 
FROM facturacion.treembolso r 
INNER JOIN facturacion.tdetalle_reembolso dr ON r.nid_reembolso = dr.nid_reembolso 
WHERE r.ctipo_transaccion = 'C';

CREATE OR REPLACE VIEW facturacion.vw_reembolso_cliente AS 
SELECT r.nid_reembolso,r.nnro_reembolso,r.dfecha_documento,r.ctipo_transaccion,r.nid_tipodocumento,r.nid_devolucion,
r.crif_persona,r.dfecha_desactivacion,dr.nid_detallereembolso,dr.nlinea,dr.cid_articulo,dr.ncantidad_articulo 
FROM facturacion.treembolso r 
INNER JOIN facturacion.tdetalle_reembolso dr ON r.nid_reembolso = dr.nid_reembolso 
WHERE r.ctipo_transaccion = 'V';

CREATE OR REPLACE VIEW INVENTARIO.vw_movimiento_inventario AS 
SELECT mi.nid_movinventario,'Nota Recep. Nro. '|| r.nnro_recepcion documento,mi.dfecha_movinventario fecha,mi.ctipo_movinventario,
CASE mi.ctipo_movinventario WHEN 'E' THEN 'ENTRADA' ELSE 'SALIDA' END tipo,dmi.cid_articulo||' '||a.cdescripcion articulo,dmi.ntipo_inventario,
cv.cdescripcion inventario,dmi.ncantidad 
FROM facturacion.vw_recepcion r 
INNER JOIN inventario.tmovimiento_inventario mi ON mi.nid_documento = r.nid_documentocompra 
INNER JOIN inventario.tdetalle_movimiento_inventario dmi ON mi.nid_movinventario = dmi.nid_movinventario AND r.cid_articulo = dmi.cid_articulo 
INNER JOIN inventario.tarticulo a ON dmi.cid_articulo = a.cid_articulo 
INNER JOIN general.tcombo_valor cv ON dmi.ntipo_inventario = cv.nid_combovalor AND cv.ctabla = 'tdetalle_movimiento_inventario'
UNION
SELECT mi.nid_movinventario,'Nota Ent. Nro. '|| e.nnro_entrega documento,mi.dfecha_movinventario fecha,mi.ctipo_movinventario,
CASE mi.ctipo_movinventario WHEN 'E' THEN 'ENTRADA' ELSE 'SALIDA' END tipo,dmi.cid_articulo||' '||a.cdescripcion articulo,dmi.ntipo_inventario,
cv.cdescripcion inventario,dmi.ncantidad 
FROM facturacion.vw_entrega e 
INNER JOIN inventario.tmovimiento_inventario mi ON mi.nid_documento = e.nid_documentoventa 
INNER JOIN inventario.tdetalle_movimiento_inventario dmi ON mi.nid_movinventario = dmi.nid_movinventario AND e.cid_articulo = dmi.cid_articulo 
INNER JOIN inventario.tarticulo a ON dmi.cid_articulo = a.cid_articulo 
INNER JOIN general.tcombo_valor cv ON dmi.ntipo_inventario = cv.nid_combovalor AND cv.ctabla = 'tdetalle_movimiento_inventario'
UNION 
SELECT mi.nid_movinventario,'ND a Proveedor Nro. ' || d.nnro_devolucion documento,mi.dfecha_movinventario fecha,mi.ctipo_movinventario,
CASE mi.ctipo_movinventario WHEN 'E' THEN 'ENTRADA' ELSE 'SALIDA' END tipo,dmi.cid_articulo || ' ' || a.cdescripcion articulo,dmi.ntipo_inventario,
cv.cdescripcion inventario,dmi.ncantidad 
FROM facturacion.vw_devolucion_proveedor d 
INNER JOIN inventario.tmovimiento_inventario mi ON mi.nid_documento = d.nid_devolucion 
INNER JOIN inventario.tdetalle_movimiento_inventario dmi ON mi.nid_movinventario = dmi.nid_movinventario 
INNER JOIN inventario.tarticulo a ON dmi.cid_articulo = a.cid_articulo 
INNER JOIN general.tcombo_valor cv ON dmi.ntipo_inventario = cv.nid_combovalor AND cv.ctabla = 'tdetalle_movimiento_inventario' 
UNION 
SELECT mi.nid_movinventario,'ND a Cliente Nro. ' || d.nnro_devolucion documento,mi.dfecha_movinventario fecha,mi.ctipo_movinventario,
CASE mi.ctipo_movinventario WHEN 'E' THEN 'ENTRADA' ELSE 'SALIDA' END tipo,dmi.cid_articulo || ' ' || a.cdescripcion articulo,dmi.ntipo_inventario,
cv.cdescripcion inventario,dmi.ncantidad 
FROM facturacion.vw_devolucion_cliente d 
INNER JOIN inventario.tmovimiento_inventario mi ON mi.nid_documento = d.nid_devolucion 
INNER JOIN inventario.tdetalle_movimiento_inventario dmi ON mi.nid_movinventario = dmi.nid_movinventario 
INNER JOIN inventario.tarticulo a ON dmi.cid_articulo = a.cid_articulo 
INNER JOIN general.tcombo_valor cv ON dmi.ntipo_inventario = cv.nid_combovalor AND cv.ctabla = 'tdetalle_movimiento_inventario' 
UNION 
SELECT mi.nid_movinventario,'Producción Nro. ' || p.nnro_produccion documento,mi.dfecha_movinventario fecha,mi.ctipo_movinventario,
CASE mi.ctipo_movinventario WHEN 'E' THEN 'ENTRADA' ELSE 'SALIDA' END tipo,dmi.cid_articulo || ' ' || a.cdescripcion articulo,dmi.ntipo_inventario,
cv.cdescripcion inventario,dmi.ncantidad 
FROM inventario.vw_produccion p 
INNER JOIN inventario.tmovimiento_inventario mi ON mi.nid_documento = p.nid_produccion 
INNER JOIN inventario.tdetalle_movimiento_inventario dmi ON mi.nid_movinventario = dmi.nid_movinventario 
INNER JOIN inventario.tarticulo a ON dmi.cid_articulo = a.cid_articulo 
INNER JOIN general.tcombo_valor cv ON dmi.ntipo_inventario = cv.nid_combovalor AND cv.ctabla = 'tdetalle_movimiento_inventario' 
UNION 
SELECT mi.nid_movinventario,'NR a Cliente Nro. ' || r.nnro_reembolso documento,mi.dfecha_movinventario fecha,mi.ctipo_movinventario,
CASE mi.ctipo_movinventario WHEN 'E' THEN 'ENTRADA' ELSE 'SALIDA' END tipo,dmi.cid_articulo || ' ' || a.cdescripcion articulo,dmi.ntipo_inventario,
cv.cdescripcion inventario,dmi.ncantidad 
FROM facturacion.vw_reembolso_cliente r 
INNER JOIN inventario.tmovimiento_inventario mi ON mi.nid_documento = r.nid_reembolso  
INNER JOIN inventario.tdetalle_movimiento_inventario dmi ON mi.nid_movinventario = dmi.nid_movinventario 
INNER JOIN inventario.tarticulo a ON dmi.cid_articulo = a.cid_articulo 
INNER JOIN general.tcombo_valor cv ON dmi.ntipo_inventario = cv.nid_combovalor AND cv.ctabla = 'tdetalle_movimiento_inventario' 
UNION
SELECT mi.nid_movinventario,'NR a Proveedor Nro. ' || r.nnro_reembolso documento,mi.dfecha_movinventario fecha,mi.ctipo_movinventario,
CASE mi.ctipo_movinventario WHEN 'E' THEN 'ENTRADA' ELSE 'SALIDA' END tipo,dmi.cid_articulo || ' ' || a.cdescripcion articulo,dmi.ntipo_inventario,
cv.cdescripcion inventario,dmi.ncantidad 
FROM facturacion.vw_reembolso_proveedor r 
INNER JOIN inventario.tmovimiento_inventario mi ON mi.nid_documento = r.nid_reembolso  
INNER JOIN inventario.tdetalle_movimiento_inventario dmi ON mi.nid_movinventario = dmi.nid_movinventario 
INNER JOIN inventario.tarticulo a ON dmi.cid_articulo = a.cid_articulo 
INNER JOIN general.tcombo_valor cv ON dmi.ntipo_inventario = cv.nid_combovalor AND cv.ctabla = 'tdetalle_movimiento_inventario';

CREATE OR REPLACE VIEW inventario.vw_inventario AS 
SELECT v.nid_combovalor,v.cdescripcion estatus_inventario,dmi.cid_articulo,
ar.cdescripcion articulo,LAST(dmi.nvalor_actual) existencia 
FROM inventario.tmovimiento_inventario mi 
INNER JOIN inventario.tdetalle_movimiento_inventario dmi ON mi.nid_movinventario = dmi.nid_movinventario 
INNER JOIN general.tcombo_valor v ON dmi.ntipo_inventario = v.nid_combovalor AND v.ctabla = 'tdetalle_movimiento_inventario' 
INNER JOIN inventario.tarticulo ar ON dmi.cid_articulo = ar.cid_articulo 
GROUP BY v.nid_combovalor,v.cdescripcion,dmi.cid_articulo,ar.cdescripcion

CREATE OR REPLACE VIEW inventario.vw_inventario_productos AS
SELECT nid_estatus_inventario,estatus_inventario,cid_articulo,articulo,SUM(existencia) existencia FROM 
(SELECT (SELECT nid_combovalor FROM general.tcombo_valor WHERE LOWER(cdescripcion) LIKE '%ordenado%' LIMIT 1) nid_estatus_inventario,
(SELECT cdescripcion FROM general.tcombo_valor WHERE LOWER(cdescripcion) LIKE '%ordenado%' LIMIT 1) estatus_inventario,
sc.cid_articulo,a.cdescripcion articulo,(MAX(sc.ncantidad_articulo)-SUM(CASE WHEN r.ncantidad_articulo IS NULL THEN 0 ELSE r.ncantidad_articulo END)) existencia 
FROM facturacion.vw_solicitudcompra sc 
LEFT JOIN facturacion.vw_recepcion r ON sc.nnro_solicitud = r.nnro_solicitud AND sc.cid_articulo = r.cid_articulo 
INNER JOIN inventario.tarticulo a ON sc.cid_articulo = a.cid_articulo 
GROUP BY sc.nnro_solicitud,1,2,3,4
HAVING MAX(sc.ncantidad_articulo) > SUM(CASE WHEN r.ncantidad_articulo IS NULL THEN 0 ELSE r.ncantidad_articulo END)) compra 
GROUP BY nid_estatus_inventario,estatus_inventario,cid_articulo,articulo
UNION
SELECT nid_combovalor AS nid_estatus_inventario,estatus_inventario, cid_articulo,articulo,existencia 
FROM inventario.vw_inventario  
UNION
SELECT nid_estatus_inventario,estatus_inventario,cid_articulo,articulo,SUM(existencia) existencia FROM 
(SELECT (SELECT nid_combovalor FROM general.tcombo_valor WHERE LOWER(cdescripcion) LIKE '%reservado%' LIMIT 1) nid_estatus_inventario,
(SELECT cdescripcion FROM general.tcombo_valor WHERE LOWER(cdescripcion) LIKE '%reservado%' LIMIT 1) estatus_inventario,
sc.cid_articulo,a.cdescripcion articulo,(MAX(sc.ncantidad_articulo)-SUM(CASE WHEN r.ncantidad_articulo IS NULL THEN 0 ELSE r.ncantidad_articulo END)) existencia 
FROM facturacion.vw_cotizacion sc 
LEFT JOIN facturacion.vw_entrega r ON sc.nnro_cotizacion = r.nnro_cotizacion AND sc.cid_articulo = r.cid_articulo 
INNER JOIN inventario.tarticulo a ON sc.cid_articulo = a.cid_articulo 
GROUP BY sc.nnro_cotizacion,1,2,3,4 
HAVING MAX(sc.ncantidad_articulo) > SUM(CASE WHEN r.ncantidad_articulo IS NULL THEN 0 ELSE r.ncantidad_articulo END)) venta
GROUP BY nid_estatus_inventario,estatus_inventario,cid_articulo,articulo

CREATE OR REPLACE VIEW inventario.vw_produccion_disponible AS 
SELECT a.cid_articulo productoterminado,ca.cid_insumo insumobase,(ip.existencia*umc.nfactor_multiplicador) cantidad_kg, ip.existencia cant_usar,
SUM(CASE WHEN pa.nid_unidadmedida = p.nid_unidadmedida THEN ROUND(((ip.existencia*umc.nfactor_multiplicador) / ca.ncantidad)-ca.nmerma,0) ELSE 0 END) cantidad_disponible 
FROM inventario.tarticulo a 
INNER JOIN inventario.tpresentacion pa ON a.nid_presentacion = pa.nid_presentacion 
INNER JOIN inventario.tconfiguracion_articulo ca ON a.cid_articulo = ca.cid_servicio 
INNER JOIN inventario.tarticulo i ON ca.cid_insumo = i.cid_articulo 
INNER JOIN inventario.tpresentacion p ON i.nid_presentacion = p.nid_presentacion 
INNER JOIN inventario.tum_conversion umc ON ca.cid_insumo = umc.cid_articulo AND p.nid_unidadmedida = umc.nid_um_hasta 
INNER JOIN inventario.vw_inventario_productos ip ON ca.cid_insumo = ip.cid_articulo AND ip.nid_estatus_inventario = (SELECT nid_combovalor FROM general.tcombo_valor WHERE LOWER(cdescripcion) LIKE '%materia prima%')
WHERE ca.cinsumobase = 'Y'
GROUP BY 1,2,3,4

-- END NEW CHANGES