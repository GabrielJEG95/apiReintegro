<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Services\solReintegroService;

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
        $header = array('Concepto','Fecha','Documento','Beneficiario','Monto','Centro de Costo','Cuenta');
        $solicitud = solReintegroService::obtenerSolicitudId($IdSol);
        $detalles = solReintegroService::listarDetalleSolicitudById($IdSol);
        $sumatoria = 0;

        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->SetTitle('FORMUNICA-Solicitud de Pago');

        $this->fpdf->AliasNbPages();
        $this->fpdf->AddPage("L");
        $this->fpdf->Cell(80);
        $this->fpdf->MultiCell(120,10,"FORMUNICA"."\n"."SOLICITUD DE PAGO",1,'C',false);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Text(10,40,"Id Solicitud: ");
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Text(60,40,$IdSol);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Text(10,45,"Unidad Solicitante: ");
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Text(60,45,$solicitud["CENTRO_COSTO"]);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Text(10,50,"A Favor de: ");
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Text(60,50,$solicitud["Beneficiario"]);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Text(10,55,"Por el valor de: ");
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Text(60,55,\number_format($solicitud["Monto"])." (Cordobas C$)");

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Text(10,60,"En Concepto de: ");
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Text(60,60,$solicitud["Concepto"]);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Text(150,40,\utf8_decode("Fecha de Emisión: "));
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Text(190,40,$solicitud["FechaSolicitud"]);

        $this->fpdf->Ln();
        $this->fpdf->Ln();
        $this->fpdf->Ln();
        $this->fpdf->Ln();

        $this->fpdf->SetFillColor(255,255,255);
        $this->fpdf->SetTextColor(0);
        $this->fpdf->SetDrawColor(13,46,7);
        $this->fpdf->SetLineWidth(.3);
        $this->fpdf->SetFont('','B');

        $w = array(60,45,30,35,35,35,35);
        for($i=0;$i<count($header);$i++)
        {
            $this->fpdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
        }
        $this->fpdf->Ln();
        $fill = false;

        foreach ($detalles as $value) {
            $this->fpdf->Cell($w[0],6,$value["Concepto"],'LR',0,'L',$fill);
            $this->fpdf->Cell($w[1],6,$value["FechaFactura"],'LR',0,'L',$fill);
            $this->fpdf->Cell($w[2],6,$value["NumeroFactura"],'LR',0,'C',$fill);
            $this->fpdf->Cell($w[3],6,$value["NombreEstablecimiento_Persona"],'LR',0,'C',$fill);
            $this->fpdf->Cell($w[4],6,$value["Monto"],'LR',0,'R',$fill);
            $this->fpdf->Cell($w[5],6,$value["CENTRO_COSTO"],'LR',0,'C',$fill);
            $this->fpdf->Cell($w[5],6,$value["Cuenta_Contable"],'LR',0,'C',$fill);
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
        $this->fpdf->Text(200,185,\number_format($sumatoria));

        $this->fpdf->SetY(-15);
        $this->fpdf->SetFont('Arial','I',8);

        //$this->fpdf->Cell(0,5,'Page '.$this->fpdf->PageNo().'/{nb}',0,0,'C');

        $this->fpdf->Output();
        exit;
    }
}
