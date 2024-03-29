USE [prueba]
GO
/****** Object:  Table [dbo].[cuentaContableReintegro]    Script Date: 21/12/2022 09:58:51 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

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

CREATE TABLE [dbo].[cuentaContableReintegro](
	[IdCuentaContable] [int] IDENTITY(1,1) NOT NULL,
	[CuentaContable] [varchar](30) NOT NULL,
	[Descripcion] [varchar](100) NULL,
	[fechaRegistro] [datetime] NULL,
	[usuarioRegistro] [varchar](20) NULL,
	[status] [bit] NULL,
PRIMARY KEY CLUSTERED
(
	[IdCuentaContable] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
UNIQUE NONCLUSTERED
(
	[CuentaContable] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Paises]    Script Date: 21/12/2022 09:58:51 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Paises](
	[IdPais] [int] IDENTITY(1,1) NOT NULL,
	[Pais] [varchar](50) NULL,
	[Status] [bit] NULL,
	[UsuarioRegistro] [varchar](20) NULL,
	[UsuarioAnulo] [varchar](20) NULL,
	[FechaRegistro] [datetime] NULL,
	[FechaAnulacion] [datetime] NULL,
PRIMARY KEY CLUSTERED
(
	[IdPais] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[registroLog]    Script Date: 21/12/2022 09:58:51 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[registroLog](
	[IdLog] [int] IDENTITY(1,1) NOT NULL,
	[TableName] [varchar](50) NULL,
	[Users] [varchar](20) NULL,
	[Action] [varchar](200) NULL,
	[setValue] [varchar](200) NULL,
	[IP] [varchar](30) NULL,
	[App] [int] NULL,
	[RegisterDate] [datetime] NULL,
PRIMARY KEY CLUSTERED
(
	[IdLog] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[relacionUserPais]    Script Date: 21/12/2022 09:58:51 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[relacionUserPais](
	[IdRelacion] [int] IDENTITY(1,1) NOT NULL,
	[Users] [varchar](20) NULL,
	[IdPais] [int] NULL,
	[fechaRegistro] [datetime] NULL,
	[usuarioRegistro] [varchar](20) NULL,
	[status] [bit] NULL,
	[fechaAnulacion] [datetime] NULL,
	[UsuarioAnulacion] [varchar](20) NULL,
PRIMARY KEY CLUSTERED
(
	[IdRelacion] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [fnica].[CENTRO_COSTO]    Script Date: 21/12/2022 09:58:51 a. m. ******/
SET ANSI_NULLS OFF
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [fnica].[CENTRO_COSTO](
	[CENTRO_COSTO] [varchar](25) NOT NULL,
	[DESCRIPCION] [varchar](60) NOT NULL,
	[ACEPTA_DATOS] [varchar](1) NOT NULL,
	[TIPO] [varchar](1) NOT NULL,
	[NoteExistsFlag] [dbo].[FlagNyType] NOT NULL,
	[RecordDate] [dbo].[CurrentDateType] NOT NULL,
	[RowPointer] [dbo].[RowPointerType] NOT NULL,
	[CreatedBy] [dbo].[UsernameType] NOT NULL,
	[UpdatedBy] [dbo].[UsernameType] NOT NULL,
	[CreateDate] [dbo].[CurrentDateType] NOT NULL,
 CONSTRAINT [CENTROCOSTOPK] PRIMARY KEY NONCLUSTERED
(
	[CENTRO_COSTO] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [CENTRO_COSTORPIx] UNIQUE NONCLUSTERED
(
	[RowPointer] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [fnica].[globalUSUARIO]    Script Date: 21/12/2022 09:58:51 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [fnica].[globalUSUARIO](
	[USUARIO] [nvarchar](20) NOT NULL,
	[DESCR] [nvarchar](200) NULL,
	[ACTIVO] [bit] NULL,
	[PASSWORD] [nvarchar](20) NULL,
	[SUCURSAL] [nvarchar](4) NULL,
	[AllBodega] [smallint] NULL,
	[CodVendedor] [nvarchar](4) NULL,
	[VePrecioSPV] [smallint] NULL,
	[Empleado] [varchar](20) NULL,
	[flgRestriccionAprobPricing] [bit] NULL,
	[email] [nvarchar](100) NULL,
 CONSTRAINT [PK_globalUSUARIO] PRIMARY KEY CLUSTERED
(
	[USUARIO] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [fnica].[reiEstadoSolicitud]    Script Date: 21/12/2022 09:58:51 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [fnica].[reiEstadoSolicitud](
	[CodEstado] [nvarchar](4) NOT NULL,
	[Descripcion] [nvarchar](50) NOT NULL,
	[Prioridad] [smallint] NOT NULL,
 CONSTRAINT [PK_reiEstadoSolicitud] PRIMARY KEY CLUSTERED
(
	[CodEstado] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [fnica].[reiSolicitudReintegroDePago]    Script Date: 21/12/2022 09:58:51 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [fnica].[reiSolicitudReintegroDePago](
	[IdSolicitud] [int] NOT NULL,
	[CENTRO_COSTO] [varchar](25) NOT NULL,
	[FechaSolicitud] [datetime] NOT NULL,
	[Monto] [decimal](18, 4) NOT NULL,
	[EsDolar] [smallint] NOT NULL,
	[CodEstado] [nvarchar](4) NOT NULL,
	[TipoPago] [smallint] NOT NULL,
	[Beneficiario] [nvarchar](100) NOT NULL,
	[Concepto] [nvarchar](500) NOT NULL,
	[CUENTA_BANCO] [nvarchar](50) NOT NULL,
	[NumCheque] [nvarchar](20) NULL,
	[Anulada] [smallint] NOT NULL,
	[EnviarDocA] [nvarchar](100) NULL,
	[EntregadoA] [nvarchar](100) NULL,
	[USUARIO] [nvarchar](20) NOT NULL,
	[FECHAREGISTRO] [datetime] NOT NULL,
	[USUARIO1] [nvarchar](20) NOT NULL,
	[FECHAUPDATE] [datetime] NOT NULL,
	[Asiento] [nvarchar](50) NULL,
	[flgAsientoGenerado] [bit] NULL,
	[FechaAsientoContable] [datetime] NULL,
	[Pais] [int] NULL,
 CONSTRAINT [PK_reiSolicitudReintegroDePago] PRIMARY KEY CLUSTERED
(
	[IdSolicitud] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [fnica].[reiSolicitudReintegroDePagoDetalle]    Script Date: 21/12/2022 09:58:51 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [fnica].[reiSolicitudReintegroDePagoDetalle](
	[IdSolicitud] [int] NOT NULL,
	[CENTRO_COSTO] [varchar](25) NOT NULL,
	[Cuenta_Contable] [varchar](25) NOT NULL,
	[Linea] [int] NOT NULL,
	[Concepto] [nvarchar](500) NOT NULL,
	[FechaFactura] [datetime] NOT NULL,
	[NumeroFactura] [nvarchar](20) NOT NULL,
	[NombreEstablecimiento_Persona] [nvarchar](100) NOT NULL,
	[Monto] [decimal](18, 4) NOT NULL,
 CONSTRAINT [PK_reiSolicitudReintegroDePagoDetalle] PRIMARY KEY CLUSTERED
(
	[IdSolicitud] ASC,
	[CENTRO_COSTO] ASC,
	[Cuenta_Contable] ASC,
	[Linea] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [fnica].[reiTipoEmisionPago]    Script Date: 21/12/2022 09:58:51 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [fnica].[reiTipoEmisionPago](
	[TipoPago] [smallint] NOT NULL,
	[Descripcion] [nvarchar](50) NOT NULL,
 CONSTRAINT [PK_reiTipoEmisionPago] PRIMARY KEY CLUSTERED
(
	[TipoPago] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[cuentaContableReintegro] ADD  DEFAULT (getdate()) FOR [fechaRegistro]
GO
ALTER TABLE [dbo].[cuentaContableReintegro] ADD  DEFAULT ((1)) FOR [status]
GO
ALTER TABLE [dbo].[Paises] ADD  DEFAULT ((1)) FOR [Status]
GO
ALTER TABLE [dbo].[Paises] ADD  DEFAULT (getdate()) FOR [FechaRegistro]
GO
ALTER TABLE [dbo].[registroLog] ADD  DEFAULT (getdate()) FOR [RegisterDate]
GO
ALTER TABLE [dbo].[relacionUserPais] ADD  DEFAULT (getdate()) FOR [fechaRegistro]
GO
ALTER TABLE [dbo].[relacionUserPais] ADD  DEFAULT ((1)) FOR [status]
GO
ALTER TABLE [fnica].[CENTRO_COSTO] ADD  DEFAULT ((0)) FOR [NoteExistsFlag]
GO
ALTER TABLE [fnica].[CENTRO_COSTO] ADD  DEFAULT (getdate()) FOR [RecordDate]
GO
ALTER TABLE [fnica].[CENTRO_COSTO] ADD  DEFAULT (newid()) FOR [RowPointer]
GO
ALTER TABLE [fnica].[CENTRO_COSTO] ADD  DEFAULT (suser_sname()) FOR [CreatedBy]
GO
ALTER TABLE [fnica].[CENTRO_COSTO] ADD  DEFAULT (suser_sname()) FOR [UpdatedBy]
GO
ALTER TABLE [fnica].[CENTRO_COSTO] ADD  DEFAULT (getdate()) FOR [CreateDate]
GO
ALTER TABLE [fnica].[globalUSUARIO] ADD  CONSTRAINT [DF__globalUSU__AllBo__2F10007B]  DEFAULT ((0)) FOR [AllBodega]
GO
ALTER TABLE [fnica].[globalUSUARIO] ADD  DEFAULT ((0)) FOR [VePrecioSPV]
GO
ALTER TABLE [fnica].[globalUSUARIO] ADD  DEFAULT ((0)) FOR [flgRestriccionAprobPricing]
GO
ALTER TABLE [fnica].[globalUSUARIO] ADD  DEFAULT ('') FOR [email]
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePago] ADD  CONSTRAINT [DF_reiSolicitudReintegroDePago_FechaSolicitud]  DEFAULT (getdate()) FOR [FechaSolicitud]
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePago] ADD  CONSTRAINT [DF_SolicitudReintegroDePago_EsDolar]  DEFAULT ((0)) FOR [EsDolar]
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePago] ADD  CONSTRAINT [DF_SolicitudReintegroDePago_CodEstado]  DEFAULT ((0)) FOR [CodEstado]
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePago] ADD  CONSTRAINT [DF_SolicitudReintegroDePago_TipoPago]  DEFAULT ((0)) FOR [TipoPago]
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePago] ADD  CONSTRAINT [DF_reiSolicitudReintegroDePago_Anulada]  DEFAULT ((0)) FOR [Anulada]
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePago] ADD  CONSTRAINT [DF_reiSolicitudReintegroDePago_FECHAREGISTRO]  DEFAULT (getdate()) FOR [FECHAREGISTRO]
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePago] ADD  CONSTRAINT [DF_reiSolicitudReintegroDePago_FECHAUPDATE]  DEFAULT (getdate()) FOR [FECHAUPDATE]
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePago] ADD  DEFAULT ((0)) FOR [flgAsientoGenerado]
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePagoDetalle] ADD  CONSTRAINT [DF_reiSolicitudReintegroDePagoDetalle_Linea]  DEFAULT ((1)) FOR [Linea]
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePagoDetalle] ADD  CONSTRAINT [DF_SolicitudReintegroDePagoDetalle_Monto]  DEFAULT ((0)) FOR [Monto]
GO
ALTER TABLE [dbo].[registroLog]  WITH CHECK ADD FOREIGN KEY([App])
REFERENCES [dbo].[Aplicaciones] ([IdApp])
GO
ALTER TABLE [dbo].[relacionUserPais]  WITH CHECK ADD FOREIGN KEY([IdPais])
REFERENCES [dbo].[Paises] ([IdPais])
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePago]  WITH CHECK ADD FOREIGN KEY([Pais])
REFERENCES [dbo].[Paises] ([IdPais])
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePago]  WITH CHECK ADD  CONSTRAINT [FK_reiSolicitudReintegroDePago_reiEstadoSolicitud1] FOREIGN KEY([CodEstado])
REFERENCES [fnica].[reiEstadoSolicitud] ([CodEstado])
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePago] CHECK CONSTRAINT [FK_reiSolicitudReintegroDePago_reiEstadoSolicitud1]
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePago]  WITH CHECK ADD  CONSTRAINT [FK_reiSolicitudReintegroDePago_reiTipoEmisionPago] FOREIGN KEY([TipoPago])
REFERENCES [fnica].[reiTipoEmisionPago] ([TipoPago])
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePago] CHECK CONSTRAINT [FK_reiSolicitudReintegroDePago_reiTipoEmisionPago]
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePago]  WITH CHECK ADD  CONSTRAINT [FK_SolicitudReintegroDePago_CENTRO_COSTO] FOREIGN KEY([CENTRO_COSTO])
REFERENCES [fnica].[CENTRO_COSTO] ([CENTRO_COSTO])
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePago] CHECK CONSTRAINT [FK_SolicitudReintegroDePago_CENTRO_COSTO]
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePagoDetalle]  WITH CHECK ADD  CONSTRAINT [FK_reiSolicitudReintegroDePagoDetalle_reiSolicitudReintegroDePago] FOREIGN KEY([IdSolicitud])
REFERENCES [fnica].[reiSolicitudReintegroDePago] ([IdSolicitud])
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePagoDetalle] CHECK CONSTRAINT [FK_reiSolicitudReintegroDePagoDetalle_reiSolicitudReintegroDePago]
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePagoDetalle]  WITH CHECK ADD  CONSTRAINT [FK_SolicitudReintegroDePagoDetalle_CENTRO_COSTO] FOREIGN KEY([CENTRO_COSTO])
REFERENCES [fnica].[CENTRO_COSTO] ([CENTRO_COSTO])
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePagoDetalle] CHECK CONSTRAINT [FK_SolicitudReintegroDePagoDetalle_CENTRO_COSTO]
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePagoDetalle]  WITH CHECK ADD  CONSTRAINT [FK_SolicitudReintegroDePagoDetalle_CUENTA_CONTABLE] FOREIGN KEY([Cuenta_Contable])
REFERENCES [fnica].[CUENTA_CONTABLE] ([CUENTA_CONTABLE])
GO
ALTER TABLE [fnica].[reiSolicitudReintegroDePagoDetalle] CHECK CONSTRAINT [FK_SolicitudReintegroDePagoDetalle_CUENTA_CONTABLE]
GO
