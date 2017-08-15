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
$sql='SELECT NE,FECHA_APERTURA,NIF,APENOMBRE,CUANTIA FROM VWCLIENTESHIPO WHERE entra_gestoria between to_date(:xFecha1) and to_date(:xFecha2)';
$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ':xFecha1', $xFecha1, 10, SQLT_CHR);
oci_bind_by_name($stid, ':xFecha2', $xFecha2, 10, SQLT_CHR);

$r = oci_execute($stid, OCI_DEFAULT);


class PDF extends FPDF
{
	
//Cabecera de p�gina
function Header()
{
	//Logo
	$this->Image('Redmoon_img/imgDoc/logo_pdf.jpg',10,8,40);
	
	//Arial bold 15
	$this->SetFont('Arial','B',12);
	//Movernos a la derecha
	$this->Cell(10);
	//T�tulo
	$this->Cell(10,30,'Listado de los expedientes que entraron a la gestoria entre:'.$_GET["xFecha1"].' y '.$_GET["xFecha2"]);
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
	$this->SetFont('','B',10);
	
	//Cabecera
	$w=array(15,15,25,20,90);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],6,$header[$i],1,0,'C',1);
	$this->Ln();
	
	//Restauraci�n de colores y fuentes
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
		
		$this->Cell($w[2],6,number_format($row['CUANTIA']).' ','LR',0,'R',$fill);
		
		$this->Cell($w[3],6,$row['NIF'],'LR',0,'L',$fill);
		$this->Cell($w[4],6,$row['APENOMBRE'],'LR',0,'L',$fill);
		
		
		
		$this->Ln();
		$fill=!$fill;
		
			
	}
	
	
$this->Cell(array_sum($w),0,'','T');
}

}

//Creaci�n del objeto de la clase heredada
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);


	$header=array('NE','Fecha','Cuantia','NIF','Nombre');	
	
	$pdf->FancyTable($header, $stid);
	


	
$pdf->Output();

// descomentar para grabar estadisticas de medici�n de caudal

// A configurar en cada m�dulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;
	
$numero_bytes=0;
$url='ListadosEntradaSalida.php';
$opcion='Listado de expedientes que ha entrado a la gestoria entre fechas a pdf';

include 'Redmoon_php/Test_Medicion_Datos.inc';

?>
