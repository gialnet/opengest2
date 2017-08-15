<?php

require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');

define('FPDF_FONTPATH','fpdf16/font/');
require('fpdf16/fpdf.php');

//Debug
$time_start = microtime(true);

$conn = db_connect();



//$xIDExpe=98261;
$sql='SELECT NE,NIF,APENOMBRE,CUANTIA,IMP_PROVISION,IMPORTE FROM VWCerradoSaldoDeudor';

$stid = oci_parse($conn, $sql);

$r = oci_execute($stid, OCI_DEFAULT);


class PDF extends FPDF
{
	
//Cabecera de p�gina
function Header()
{
	//Logo
	$this->Image('Redmoon_img/imgDoc/logo_pdf.jpg',10,8,40);
	
	//Arial bold 15
	$this->SetFont('Arial','B',15);
	//Movernos a la derecha
	$this->Cell(40);
	//T�tulo
	$this->Cell(10,30,'Expedientes Terminados con Saldo DEUDOR a fecha de:'.date("d/m/y"));
	$this->Cell(160);
	$this->Cell(10,30,'Hora:'.date("H.i.s"));

	//Salto de l�nea
	$this->Ln(20);
	
	
}

//Pie de p�gina
function Footer()
{
	//Posici�n: a 1,5 cm del final
	$this->SetY(-15);
	//Arial italic 8
	$this->SetFont('Arial','I',8);
	//N�mero de p�gina
	$this->Cell(0,10,'P�gina '.$this->PageNo().'/{nb}',0,0,'C');
}
function FancyTable($header, $stid)
{
	//Colores, ancho de l�nea y fuente en negrita
	$this->SetFillColor(23,68,87);
	$this->SetTextColor(255);
	$this->SetDrawColor(128,0,0);
	$this->SetLineWidth(.3);
	$this->SetFont('','B',14);
	
	//Cabecera
	$w=array(25,25,120,50,30,30);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],8,$header[$i],1,0,'C',1);
	$this->Ln();
	
	//Restauraci�n de colores y fuentes
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	$this->SetFont('Times','',12);
	
	//Datos
	$fill=false;
	$Total=0;

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		$this->Cell($w[0],8,$row['NE'],'LR',0,'L',$fill);
		$this->Cell($w[1],8,$row['NIF'],'LR',0,'L',$fill);	
		$this->Cell($w[2],8,$row['APENOMBRE'],'LR',0,'L',$fill);
		$this->Cell($w[3],8,number_format($row['CUANTIA']).' �','LR',0,'L',$fill);
		$this->Cell($w[4],8,number_format($row['IMP_PROVISION']).' �','LR',0,'L',$fill);
		$this->Cell($w[4],8,number_format($row['IMPORTE']).' �','LR',0,'L',$fill);
	
	

		
		
		$this->Ln();
		$fill=!$fill;
		
			
	}
	
	
$this->MultiCell(array_sum($w),0,'','T');
}

}

//Creaci�n del objeto de la clase heredada
$pdf=new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',15);


	$header=array('NE','NIF','Nombre','Cuant�a','Provisi�n','Gestor�a');	
	
	$pdf->FancyTable($header, $stid);
	


	
$pdf->Output();

// descomentar para grabar estadisticas de medici�n de caudal

// A configurar en cada m�dulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;
	
$numero_bytes=0;
$url='ListadosExpedientesPorFecha.php';
$opcion='Listado de expedientes entre fechas a pdf';

include 'Redmoon_php/Test_Medicion_Datos.inc';

?>
