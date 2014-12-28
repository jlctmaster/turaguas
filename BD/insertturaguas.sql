insert into general.tcombo_valor (ctabla,cdescripcion,dcreado_desde) values ('tpersona','EMPLEADO',NOW()),('tpersona','CLIENTE',NOW()),('tpersona','PROVEEDOR',NOW());

INSERT INTO GENERAL.trol (cdescripcion,dcreado_desde) values ('OPERADOR DE SISTEMA',NOW()),('PRODUCTOR',NOW()),('DELEGADO INSTITUCIONAL',NOW());

insert into general.tlocalidad (ctabla,cdescripcion,dcreado_desde) values ('tpais','VENEZUELA',NOW());

insert into general.tlocalidad (ctabla,cdescripcion,nid_localidad_padre,dcreado_desde) values ('testado','PORTUGUESA',1,NOW());

insert into general.tlocalidad (ctabla,cdescripcion,nid_localidad_padre,dcreado_desde) values ('tciudad','ARAURE',2,NOW());

insert into general.tlocalidad (ctabla,cdescripcion,nid_localidad_padre,dcreado_desde) values ('tmunicipio','ARAURE',3,NOW());

insert into general.tlocalidad (ctabla,cdescripcion,nid_localidad_padre,dcreado_desde) values ('tparroquia','ARAURE',4,NOW());

insert into seguridad.tsistema 
(crif_empresa,cnombre_empresa,ctlf_empresa,cemail_empresa,cdireccion_empresa,cmision,cvision,chistoria,nid_localidad,cobjetivo) values 
('J410337856','EMPAQUETADORA SOCIALISTA COMUNAL "EL FUTURO DE LAS TURAGUAS"','02556234587','EFT@GMAIL.COM',
'AV. LOS AGRICULTORES DIAGONAL A MAQUINARIAS CADELMA AL LADO DEL CENTRO DE ACOPIO DE LA GRAN MISIÓN VIVIENDA VENEZUELA','Desarrollar actividades socioeconómicas políticas, culturales y ecológicas con igualdad sustantiva entre sus integrantes, basadas en la ejecución del ciclo productivo socialista. Realizar actividades que resulten beneficiosas a sus productores y productoras para alcanzar el buen vivir propio y de sus familias. Reinvertir socialmente los excedentes derivados de sus actividades en el desarrollo integral de los Consejos Comunales: C.C. sector Morichal C.C. sector Venezuela, C.C. Mercantil Sur, C.C. Mercantil Norte, a los fines de contribuir con el desarrollo social de la República Bolivariana de Venezuela.',
'Responder a las necesidades colectivas y contribuir a fortalecer las potencialidades y capacidades de las comunidades y al desarrollo social de la República Bolivariana de Venezuela, en el marco del cumplimiento del Plan de Desarrollo Económico y Social de la Nación, las políticas y desarrollo del Ministerio del Poder Popular para las Comunas y la Protección Social, del plan de desarrollo y ciclo productivo, así como también garantizar la planificación de la gestión de los Consejos Comunales: C.C. sector Morichal C.C. sector Venezuela, C.C. Mercantil Sur, C.C. Mercantil Norte.',
'La empresa de propiedad social indirecta comunal denominada “EL FUTURO DE LAS TURAGUAS” nace a través del Consejo Comunal “Las Turaguas” en el año 2012 como parte del proyecto productivo impulsado por dicho consejo comunal, conformada por familias procedentes de Caracas que quedaron damnificadas a consecuencia de fuertes lluvias y que han sido reubicadas y dignificadas por el presidente Hugo Chávez, en la Urbanización Prados del Sol, quienes fueron formados a través de la Gran Misión Saber y Trabajo como trabajadores y trabajadoras de esta empresa social, dicho proyecto toma vida gracias a los logros del gobierno revolucionario y a través del Programa de Inventiva Tecnológica Popular y del Fondo Bicentenario.',5,
'<b>Objetivo General:</b><br/><br/> Prestar servicio de empaquetado de granos y polvos, así como el empaquetado de productos para la venta, desarrollando actividades socioeconómicas políticas, culturales y ecológicas con igualdad sustantiva entre sus integrantes, basadas en la ejecución del ciclo productivo socialista.<br/><br/><b> Objetivos Específicos: </b><br/><br/>Asegurar que el manejo de la organización socio - productiva y los beneficios que de ella deriven, estén orientados a la satisfacción de las necesidades de las comunidades mediante la producción de los bienes y servicios, saberes y conocimientos, pudiendo ser de intercambio de carácter solidario, en la generación de riquezas para reinvertirlo socialmente, dado que entran en funcionamiento nuevas formas de generación, apropiación y distribución de los excedentes.<br /><br />Velar por que su planificación productiva esté enmarcada dentro del plan de gestión, administración y resguardo de los medios y factores de producción por parte del pueblo organizado, para la creación del nuevo tejido productivo que permita la producción de bienes y servicios para la satisfacción de necesidades que garanticen la suprema felicidad social.<br /><br />La relación de la organización socio - productiva con la fortaleza organizativa o instancia de agregación y participación popular de la cual forme parte la propia organización socio - productiva.<br /><br />Ejecutar el desarrollo de su ciclo productivo apegados a los principios de un ambiente ecológico equilibrado.<br /><br />Garantizar que el manejo de la organización socio - productiva y sus respectivos beneficios sean tendentes a la satisfacción de las necesidades colectivas.<br /><br />El ajuste de precios finales para los consumidores, consumidoras y usuarios y usuarias de los bienes o servicios provenientes de las actividades desarrolladas por su organización, atendiendo los lineamientos y políticas del órgano competente en la materia de comercio solidario.<br /><br />La promoción de formas de organización del trabajo que desarrollen una nueva cultura de trabajo. La organización de las fuerzas productivas para liberarse de la relación de dominación mercantil y de explotación que le impone el régimen del capitalismo.');

INSERT INTO seguridad.tconfiguracion (cdescripcion,nnumero_respuestasaresponder) values ('POR DEFECTO',1);

insert into seguridad.tperfil (cnombreperfil,nid_configuracion,dcreado_desde) values ('ADMINISTRADOR',1,NOW());

insert into seguridad.topcion (cnombreopcion,norden,dcreado_desde) values ('INSERTAR',1,NOW()),('ACTUALIZAR',2,NOW()),('DESACTIVAR',3,NOW()),('ACTIVAR',4,NOW()),('CONSULTAR',5,NOW()),('LIMPIAR',6,NOW()),('MOSTRAR',7,NOW());

INSERT INTO seguridad.tmodulo (cnombremodulo,cicono,dcreado_desde) values ('UBICACIONES','icon-list-alt',NOW()),('GENERAL','icon-list-alt',NOW()),
('MATERIALES','icon-list-alt',NOW()),('COMPRAS','icon-cog',NOW()),('VENTAS','icon-cog',NOW()),('DEVOLUCIONES','icon-cog',NOW()),
('INVENTARIO','icon-cog',NOW()),('SEGURIDAD','icon-lock',NOW());

insert into seguridad.tformulario (cnombreformulario,nid_modulo,curl,norden,dcreado_desde) values ('FORMULARIOS',8,'FORMULARIO',0,NOW()),('PERFIL',8,'PERFILES',0,NOW());

INSERT INTO seguridad.tservicio (cnombreservicio,nid_formulario,dcreado_desde) values ('PESTAÑAS',1,NOW()),('PERFIL',2,NOW());

insert into seguridad.tdetalleservicio_perfil_opcion (nid_opcion,nid_servicio,nid_perfil,dcreado_desde) values 
(2,1,1,NOW()),
(5,1,1,NOW()),
(2,2,1,NOW()),
(5,2,1,NOW());

INSERT INTO general.tpersona (crif_persona,cnombre,cdireccion,ctelefhab,ctelefmov,cemail,ntipo_persona,nid_rol,dcreado_desde) values 
('v203895867','JORGE LEONARDO COLMENAREZ TORREALBA','URB. EL BOSQUE AV. 1 CASA 004','02556222004','04120560439','JLCT.MASTER@GMAIL.COM',1,1,NOW());

INSERT INTO SEGURIDAD.tusuario (cnombreusuario,ccedula,nid_perfil,dcreado_desde) values ('ADMI-V203895867','V203895867',1,NOW());

INSERT INTO SEGURIDAD.trespuesta_secreta (cnombreusuario,cpregunta,crespuesta,dcreado_desde) values 
('ADMI-V203895867','CUAL ES EL SEGUNDO NOMBRE DE TU PADRE','EUGENIO',NOW()),
('ADMI-V203895867','CUAL ES LA MATERIA FAVORITA EN BACHILLERATO','MATEMATICAS',NOW()),
('ADMI-V203895867','CUAL ES EL SEGUNDO NOMBRE DE TU MADRE','OMAIRA',NOW());

INSERT INTO seguridad.tcontrasena (cnombreusuario,ccontrasena,nestado,dcreado_desde) values ('ADMI-V203895867',md5('12345678'),1,NOW());