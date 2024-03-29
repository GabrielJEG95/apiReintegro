<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Services\solReintegroService;
use App\Services\centroCostoService;
use App\Services\cuentaContableService;

class aprobacionPDFController extends Controller
{
    protected  $fpdf;

    public function __construct()
    {
        $this->fpdf = new Fpdf;
    }

    public function createPDF(Request $request)
    {
        $IdSol = $request["IdSolicitud"];
        $paises = $request["Pais"];
        $user = $request["user"];

        $header = array('Concepto','Fecha','Doc','Beneficiario','Monto','Centro de Costo','Cuenta');
        $solicitud = solReintegroService::obtenerSolicitudId($IdSol,0,$paises,$user);
        $detalles = solReintegroService::listarDetalleSolicitudById($IdSol);
        $ceco = centroCostoService::obtenerCentroCosto($solicitud[0]["CENTRO_COSTO"]);
        $sumatoria = 0;

        if($solicitud[0]["EsDolar"] === '0'){
            $moneda = "Cordobas C$";
        } else {
            $moneda = "Dolares $";
        }

        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->SetTitle('FORMUNICA-Solicitud de Pago');

        $this->fpdf->AliasNbPages();
        $this->fpdf->AddPage("P");
        //$this->fpdf->Image('../resources/views/Logo.png',10,13,33);
        $this->fpdf->Cell(80);
        $this->fpdf->MultiCell(120,10,"FORMUNICA"."\n"."SOLICITUD DE PAGO",1,'C',false);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Text(10,40,"Id Solicitud: ");
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Text(60,40,$IdSol);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Text(10,45,"Unidad Solicitante: ");
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Text(60,45,$solicitud[0]["CENTRO_COSTO"]." ".$ceco[0]["Descripcion"]);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Text(10,50,"A Favor de: ");
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Text(60,50,utf8_decode($solicitud[0]["Beneficiario"]));

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Text(10,55,"Por el valor de: ");
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Text(60,55,\number_format($solicitud[0]["Monto"],2)." (".$moneda.")");

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Text(10,60,"En Concepto de: ");
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Text(60,60, \utf8_decode($solicitud[0]["Concepto"]));

        if($solicitud[0]["TipoPago"] === "2") {
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->Text(10,65,"Tipo de Pago: ");
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Text(60,65, \utf8_decode("Transferencia"));
        } else if ($solicitud[0]["TipoPago"] === "1") {
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->Text(10,65,"Tipo de Pago: ");
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Text(60,65, \utf8_decode("Cheque"));
        }

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Text(150,40,\utf8_decode("Fecha de Emisión: "));
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Text(190,40,date("Y-m-d", \strtotime($solicitud[0]["FechaSolicitud"])));

        $this->fpdf->Ln();
        $this->fpdf->Ln();
        $this->fpdf->Ln();
        $this->fpdf->Ln();

        $this->fpdf->SetFillColor(255,255,255);
        $this->fpdf->SetTextColor(0);
        $this->fpdf->SetDrawColor(13,46,7);
        $this->fpdf->SetLineWidth(.3);
        $this->fpdf->SetFont('','B');

        $w = array(72,20,15,40,18,47,65);
        for($i=0;$i<count($header);$i++)
        {
            $this->fpdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
        }
        $this->fpdf->Ln();
        $fill = false;

        foreach ($detalles as $value) {
            $centroCo = centroCostoService::obtenerCentroCosto($value["CENTRO_COSTO"]);
            $cuentaCon= cuentaContableService::obtenerCuentaContableByCodigo($value["Cuenta_Contable"]);

            $this->fpdf->SetFont('','B',8);
            $this->fpdf->Cell($w[0],6,$value["Concepto"],'LR',0,'L',$fill);
            $this->fpdf->SetFont('','B');
            $this->fpdf->Cell($w[1],6,date("Y-m-d",\strtotime($value["FechaFactura"])),'LR',0,'L',$fill);
            $this->fpdf->Cell($w[2],6,$value["NumeroFactura"],'LR',0,'C',$fill);
            $this->fpdf->Cell($w[3],6,$value["NombreEstablecimiento_Persona"],'LR',0,'C',$fill);
            $this->fpdf->Cell($w[4],6,$value["Monto"],'LR',0,'R',$fill);
            $this->fpdf->Cell($w[5],6,$value["CENTRO_COSTO"]." ".utf8_decode($centroCo[0]["Descripcion"]),'LR',0,'L',$fill);
            $this->fpdf->SetFont('','B',8);
            $this->fpdf->Cell($w[6],6,$value["Cuenta_Contable"]." ".utf8_decode($cuentaCon[0]["Descripcion"]),'LR',0,'L',$fill);
            $this->fpdf->Ln();
            $fill = !$fill;
            $sumatoria = $sumatoria+$value["Monto"];
        }
        $this->fpdf->Cell(array_sum($w),0,'','T');

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Text(10,195,"Elaborado Por ");

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Text(130,195,"Revisado Por ");

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Text(230,195,"Autorizado Por ");

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Text(150,185,"SUMATORIA ==>");

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Text(200,185,\number_format($sumatoria,2));

        $this->fpdf->SetY(-15);
        $this->fpdf->SetFont('Arial','I',8);

        //$this->fpdf->Cell(0,5,'Page '.$this->fpdf->PageNo().'/{nb}',0,0,'C');

        $this->fpdf->Output();
        exit;
    }
}
