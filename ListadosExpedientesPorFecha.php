<?php 
/*
* En los pdf el control de sesiones debe estar encima para que funcione y luego poner
* tambien el session_start
*/
require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');

define('FPDF_FONTPATH','fpdf16/font/');
require('fpdf16/fpdf.php');

//Debug
$time_start = microtime(true);

$conn = db_connect();

$xFecha1=$_GET["xFecha1"];
$xFecha2=$_GET["xFecha2"];

//$xIDExpe=98261;
$sql='SELECT NE,FECHA_APERTURA,TIPO,NIF,APENOMBRE,CUANTIA FROM VWExpeClientesTodos WHERE FECHA_APERTURA between to_date(:xFecha1) and to_date(:xFecha2)';
$stid = oci_parse($conn, $sql);

$xFecha1=$_GET["xFecha1"];
$xFecha2=$_GET["xFecha2"];
oci_bind_by_name($stid, ':xFecha1', $xFecha1, 10, SQLT_CHR);
oci_bind_by_name($stid, ':xFecha2', $xFecha2, 10, SQLT_CHR);
$xFecha1=$_GET["xFecha1"];
$xFecha2=$_GET["xFecha2"];
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
	$this->Cell(10);
	//Título
	$this->Cell(10,30,'Listado de los expediente realizados entre:'.$_GET["xFecha1"].' y '.$_GET["xFecha2"]);
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
	$this->SetFont('','B',10);
	
	//Cabecera
	$w=array(15,15,20,25,20,90);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],6,$header[$i],1,0,'C',1);
	$this->Ln();
	
	//Restauración de colores y fuentes
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	$this->SetFont('');
	
	//Datos
	$fill=false;
	$Total=0;

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		$this->Cell($w[0],6,$row['NE'],'LR',0,'L',$fill);
		$this->Cell($w[1],6,$row['FECHA_APERTURA'],'LR',0,'L',$fill);
		$this->Cell($w[2],6,$row['TIPO'],'LR',0,'L',$fill);
		$this->Cell($w[3],6,number_format($row['CUANTIA']).' €','LR',0,'R',$fill);
		
		$this->Cell($w[4],6,$row['NIF'],'LR',0,'L',$fill);
		$this->Cell($w[5],6,$row['APENOMBRE'],'LR',0,'L',$fill);
		
		
		
		$this->Ln();
		$fill=!$fill;
		
			
	}
	
	
$this->Cell(array_sum($w),0,'','T');
}

}

//Creación del objeto de la clase heredada
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);


	$header=array('NE','Fecha','Tipo','Cuantia','NIF','Nombre');	
	
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
