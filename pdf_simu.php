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
$sql='select asunto,cuantia,notaria,impuesto,registro,gestoria,(notaria+impuesto+registro+gestoria) AS TOTAL from tmp_simu where usuario=:xUser order by id';
$stid = oci_parse($conn, $sql);

$xUser=$_SESSION["usuario"];
	oci_bind_by_name($stid, ':xUser', $xUser, 30, SQLT_CHR);

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
	$this->Cell(60);
	//T�tulo
	$this->Cell(10,30,'Simulaci�n de Provisi�n de Fondos');
	$this->Cell(80);
	$this->Cell(10,30,'Fecha:'.date("d/m/y"));
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
	$w=array(67,20,20,20,20,20,28);
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
		$this->Cell($w[0],6,$row['ASUNTO'],'LR',0,'L',$fill);
		$this->Cell($w[1],6,number_format($row['CUANTIA']).' �','LR',0,'L',$fill);
		$this->Cell($w[2],6,number_format($row['NOTARIA']).' �','LR',0,'L',$fill);
		$this->Cell($w[3],6,number_format($row['IMPUESTO']).' �','LR',0,'R',$fill);
		
		$this->Cell($w[4],6,number_format($row['REGISTRO']).' �','LR',0,'L',$fill);
		$this->Cell($w[5],6,number_format($row['GESTORIA']).' �','LR',0,'L',$fill);
		$this->Cell($w[6],6,number_format($row['TOTAL']).' �','LR',0,'R',$fill);
		
		
		
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


	$header=array('Concepto','Cuant�a','Notar�a','Impuesto','Registro','Gestor�a','Total Provisi�n');	
	
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
