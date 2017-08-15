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
$sql='SELECT NE,FASE,TARIFA,COSTE_REAL,IMPORTE FROM VWErrorCalculoProvision';

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
	$this->SetFont('Arial','B',12);
	//Movernos a la derecha
	$this->Cell(5);
	//Título
	$this->Cell(10,30,'Coste Real del Servicio, Superior al Presupuestado a fecha de:'.date("d/m/y"));
	$this->Cell(140);
	$this->Cell(10,30,'Hora:'.date("H.i.s"));
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
	$this->SetFont('','B',12);
	$this->Cell(20);
	//Cabecera
	$w=array(25,30,30,30,30);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],6,$header[$i],1,0,'C',1);
	$this->Ln();
	
	//Restauración de colores y fuentes
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	$this->SetFont('Times','',12);
	
	//Datos
	$fill=false;
	$Total=0;

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{	$this->Cell(20);
		$this->Cell($w[0],6,$row['NE'],'LR',0,'L',$fill);
		$this->Cell($w[1],6,$row['FASE'],'LR',0,'L',$fill);	
		$this->Cell($w[2],6,number_format($row['TARIFA']).' €','LR',0,'L',$fill);
		$this->Cell($w[3],6,number_format($row['COSTE_REAL']).' €','LR',0,'L',$fill);
		$this->Cell($w[4],6,number_format($row['IMPORTE']).' €','LR',0,'L',$fill);
		
	
	

		
		
		$this->Ln();
		$fill=!$fill;
		
			
	}
	
	$this->Cell(20);
$this->MultiCell(array_sum($w),0,'','T');
}

}

//Creación del objeto de la clase heredada
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

	$header=array('NE','Fase','Tarifa','Coste Real','Diferencia');	
	
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
