USE [EXACTUS]
GO
/****** Object:  StoredProcedure [dbo].[SP_Prorrateo]    Script Date: 15/02/2023 04:26:36 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER procedure [dbo].[SP_Prorrateo] @monto decimal(10,2), @concepto int, @pais int

as
begin

select b.IdConcepto,
b.strDescripcion as strDescripcionConcepto,
a.CentroCosto as strCeCo,
ROW_NUMBER() OVER(PARTITION BY b.IdConcepto ORDER BY c.CentroCosto ASC) as IdLinea,
c.Descripcion as strDescripcionCeco,
NoEmpleado as intEmpleados,
porcentaje,
--CAST (round((@monto * porcentaje)/100,2)AS decimal(10,2) ) as decMontoPro,
CAST (@monto * porcentaje)/100, AS decimal(10,2) as decMontoPro,
strCuentaContable = '',
strEstablecimiento = '',
datFechaFactura = '',
(select sum(NoEmpleado) as intTotalEmpleados from empCountReintegro where Concepto =@concepto group by Concepto) as intTotalEmpleados
from empCountReintegro a
join CatConceptoReintegro b
on a.Concepto = b.IdConcepto
join centroCostoReintegro c
on a.CentroCosto = c.CentroCosto
where Concepto= @concepto and c.Pais = @pais

end
