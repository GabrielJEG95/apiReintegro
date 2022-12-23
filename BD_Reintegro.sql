select * from fnica.reiSolicitudReintegrodePago;
select * from fnica.reiSolicitudReintegrodePagoDetalle;
select * from fnica.reiEstadoSolicitud;
select * from fnica.reiTipoEmisionPago;
select * from fnica.globalusuario;
select * from fnica.CENTRO_COSTO;
select * from CatConceptoReintegro;
select * from Paises;
select * from relacionUserPais;
select * from registroLog;
select * from cuentaContableReintegro;
select * from centroCostoReintegro;

create table cuentaContableReintegro
(
	IdCuentaContable int primary key identity(1,1),
	CuentaContable varchar(30) not null unique,
	Descripcion varchar(100),
	fechaRegistro datetime default getdate(),
	usuarioRegistro varchar(20),
	status bit default 1
);

create table centroCostoReintegro
(
    IdCentroCosto int primary key identity(1,1),
    CentroCosto varchar(20),
    Descripcion varchar(100),
    Pais int,
    status bit default 1,
    fechaRegistro datetime default getdate(),
    usuarioRegistro varchar(20),
    foreign key (Pais) references Paises (IdPais)
);

insert into centroCostoReintegro (CentroCosto,Descripcion,Pais)
select CENTRO_COSTO,DESCRIPCION,1 from fnica.CENTRO_COSTO;

update centroCostoReintegro
set usuarioRegistro='gespinoza'

insert into cuentaContableReintegro (CuentaContable,Descripcion)
values
('5-02-01-001-005',	'Viáticos'),
('5-02-01-001-011',	'Capacitación al Personal'),
('5-02-01-001-012',	'Transporte'),
('5-02-01-001-013',	'Atención al Personal'),
('5-02-01-001-014',	'Gastos de Representación'),
('5-02-01-001-016',	'Hospedaje'),
('5-02-01-001-017',	'Uniformes'),
('5-02-01-001-021',	'Energía Eléctrica'),
('5-02-01-001-022',	'Agua'),
('5-02-01-001-023',	'Teléfonos'),
('5-02-01-001-024',	'Correos'),
('5-02-01-001-025',	'Teléfonos Celulares'),
('5-02-01-001-026',	'Internet'),
('5-02-01-001-027',	'Serv. Legales y Profesionales'),
('5-02-01-001-029',	'Fletes y Acarreos / Fertilizantes'),
('5-02-01-001-031',	'Mant. y Rep. de Mobiliario y Equipo'),
('5-02-01-001-032',	'Mant. y Rep.  de Edificios'),
('5-02-01-001-033',	'Mant. y Rep. de Vehículos'),
('5-02-01-001-034',	'Arrendamiento de Inmuebles'),
('5-02-01-001-035',	'Vigilancia'),
('5-02-01-001-037',	'Publicidad y Propaganda'),
('5-02-01-001-038',	'Impresiones Litográficas'),
('5-02-01-001-039',	'Atenciones a Clientes'),
('5-02-01-001-040',	'Muestras'),
('5-02-01-001-041',	'Suscripciones, Publicaciones'),
('5-02-01-001-042',	'Fotocopias'),
('5-02-01-001-043',	'Análisis y Refrendas de Agroq'),
('5-02-01-001-044',	'Comisiones x Tarjetas Crédito'),
('5-02-01-001-045',	'Recolección de Basura'),
('5-02-01-001-047',	'Mant. y Rep. de Otros Equipos'),
('5-02-01-001-048',	'Seguros de Vehiculos'),
('5-02-01-001-049',	'Análisis de suelo'),
('5-02-01-001-050',	'Empaque y Reempaque'),
('5-02-01-001-051',	'Reparacion (Armado) de Eq. Agricolas'),
('5-02-01-001-053',	'Servicio de Maquila'),
('5-02-01-001-054',	'Almacenaje'),
('5-02-01-001-055',	'Parqueos'),
('5-02-01-001-057',	'Materiales y Suministros'),
('5-02-01-001-058',	'Artículos de Cafetería'),
('5-02-01-001-059',	'Aseo y Limpieza'),
('5-02-01-001-060',	'Papelería y Utiles de Oficina'),
('5-02-01-001-061',	'Repuestos y Accesorios'),
('5-02-01-001-062',	'Llantas, Neumáticos y Baterias'),
('5-02-01-001-063',	'Combustibles y Lubricantes'),
('5-02-01-001-064',	'Útiles y Herramientas'),
('5-02-01-001-066',	'Matrícula e Impuestos Municipales'),
('5-02-01-001-067',	'Mat. Didáctico Educativo'),
('5-02-01-001-068',	'Materiales para Formulación de Agroquími'),
('5-02-01-001-069',	'Formatos, Timbres'),
('5-02-01-001-072',	'Donaciones'),
('5-02-01-001-073',	'Permisos, Registros y Lic'),
('5-02-01-001-074',	'Promoción y Desarrollo'),
('5-02-01-001-076',	'Multas, Recargos'),
('5-02-01-001-077',	'Gastos No Deducibles'),
('5-02-01-001-084',	'Seguro de Edificios'),
('5-02-01-001-085',	'Seguro contra incendio'),
('5-02-01-001-086',	'Depreciacion (Empleados)'),
('5-02-01-001-087',	'Depreciacion (Edificios)'),
('5-02-01-001-088',	'Depreciacion ( Mob. y Equipo de Oficina)'),
('5-02-01-001-089',	'Depreciacion ( Vehiculos)'),
('5-02-01-001-090',	'Depreciacion ( Otros Equipos)'),
('5-02-01-001-091',	'Licencias y Software'),
('5-02-01-001-092',	'Salud, Botiquin y Seguridad Industrial'),
('5-02-01-001-093',	'Reclutamiento de personal'),
('5-02-01-001-094',	'Gastos de Viajes al Exterior'),
('5-02-01-001-096',	'Aporte de Campo Limpio'),
('5-02-01-001-097',	'Mantto y Reparacion de Equipo de A/C'),
('5-02-01-001-098',	'Estiba y Movimientos de Bodega'),
('5-02-01-001-099',	'Reempaque: Etiquetas y Panfletos'),
('5-02-01-001-100',	'Reempaque: Dilleros'),
('5-02-01-001-101',	'Carga y Descarga de productos'),
('5-02-01-001-102',	'Garantia de repuestos y Eq. a Clientes'),
('5-02-01-001-103',	'Fletes y Acarreos / Agroquimicos'),
('5-02-01-001-104',	'Fletes y Acarreos / Semillas'),
('5-02-01-001-105',	'Fletes y Acarreos / Equipos'),
('5-02-01-001-106',	'Garantia de Semillas'),
('5-02-01-001-108',	'Fletes y Acarreos/ Maquinaria Agricola'),
('5-02-01-001-110',	'Reempaque: Cajas'),
('5-02-01-001-111',	'Reempaque: Envases'),
('5-02-01-001-115',	'Mantto de Redes telefonicas, plantas'),
('5-02-01-001-117',	'Gastos de Convenciones'),
('5-02-01-001-118',	'GPS (Sist.Posicionamiento Global)'),
('5-02-01-001-119',	'Mejoras a Propiedades Arrendadas'),
('5-02-01-001-122',	'Canasta Navideña'),
('5-02-01-001-123',	'Fumigaciones'),
('5-02-01-001-124',	'Amortizacion (Licencias y Software)'),
('5-02-01-001-126',	'Arrendamientos vivienda p/empleados'),
('5-02-01-001-137',	'Celebraciones'),
('5-02-01-002-004',	'Timbres Fiscales'),
('5-02-01-003-009',	'Donaciones'),
('5-02-01-003-015',	'Gastos de Representación'),
('5-02-01-003-021',	'Gastos No Deducibles'),
('5-02-01-003-030',	'Garantias de Equipos (Repuestos)'),
('5-02-01-001-130',	'Fletes Agricultura Protegida'),
('5-02-01-003-129',	'COMBUSTIBLES Y LUBRICANTES (TALLER)'),
('5-02-01-001-133',	'Servicios Generales')