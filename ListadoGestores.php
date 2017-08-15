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
$sql="SELECT * FROM colaboradores where tipo=0 and activo='SI' and (interno='si' or interno='SI')";

$stid = oci_parse($conn, $sql);

$r = oci_execute($stid, OCI_DEFAULT);


class PDF extends FPDF
{
	
//Cabecera de página
function Header()
{
	//Logo
	$this->Image('Redmoon_img/imgDoc/logo_pdf.jpg',10,8,40);
	
	//Arial bold 15
	$this->SetFont('Arial','B',15);
	//Movernos a la derecha
	$this->Cell(70);
	//Título
	$this->Cell(10,30,'Gestores activos internos a fecha de: '.date("d/m/y"));
	//Salto de línea
	$this->Ln(20);
	
	
}

//Pie de página
function Footer()
{
	//Posición: a 1,5 cm del final
	$this->SetY(-15);
	//Arial italic 8
	$this->SetFont('Arial','I',8);
	//Número de página
	$this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
}
function FancyTable($header, $stid)
{
	//Colores, ancho de línea y fuente en negrita
	$this->SetFillColor(23,68,87);
	$this->SetTextColor(255);
	$this->SetDrawColor(128,0,0);
	$this->SetLineWidth(.3);
	$this->SetFont('','B',7);
	
	//Cabecera
	$w=array(10,45,15,42,40,27,10,15,15,15,15,15);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],12,$header[$i],1,0,'C',1);
	$this->Ln();
	
	//Restauración de colores y fuentes
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	$this->SetFont('Times','',7);
	
	//Datos
	$fill=false;
	$Total=0;

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		$this->Cell($w[0],12,$row['NIF'],'LR',0,'L',$fill);
		$this->Cell($w[1],12,$row['NOMBRE'],'LR',0,'L',$fill);	
		$this->Cell($w[2],12,$row['EMAIL'],'LR',0,'L',$fill);
		$this->Cell($w[3],12,$row['DIRECCION'],'LR',0,'L',$fill);
		$this->Cell($w[4],12,$row['POBLACION'],'LR',0,'L',$fill);
		$this->Cell($w[5],12,$row['PROVINCIA'],'LR',0,'L',$fill);
		$this->Cell($w[6],12,$row['COD_POSTAL'],'LR',0,'L',$fill);
		$this->Cell($w[7],12,$row['TELEFONO'],'LR',0,'L',$fill);
		$this->Cell($w[8],12,$row['FECHA_ALTA'],'LR',0,'L',$fill);
		$this->Cell($w[9],12,$row['ASEGURADORA'],'LR',0,'L',$fill);
		$this->Cell($w[10],12,$row['NPOLIZA'],'LR',0,'L',$fill);
		$this->Cell($w[11],12,$row['FECHA_SEGURO'],'LR',0,'L',$fill);
		

		
		
		$this->Ln();
		$fill=!$fill;
		
			
	}
	
	
$this->MultiCell(array_sum($w),0,'','T');
}

}

//Creación del objeto de la clase heredada
$pdf=new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',15);


	$header=array('NIF','Nombre','EMail','Dirección','Población','Provincia','CP','TLF','Alta','Aseguradora','NºPoliza','F.Seguro');	
	
	$pdf->FancyTable($header, $stid);
	


	
$pdf->Output();

// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;
	
$numero_bytes=0;
$url='ListadosExpedientesPorFecha.php';
$opcion='Listado de expedientes entre fechas a pdf';

include 'Redmoon_php/Test_Medicion_Datos.inc';

?>
