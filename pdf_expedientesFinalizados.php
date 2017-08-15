<?php 
require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');

define('FPDF_FONTPATH','fpdf16/font/');
require('fpdf16/fpdf.php');

//Debug
$time_start = microtime(true);

$conn = db_connect();



$pasa=0;

if(isset($_GET["xNIF"])){
	$xNIF = $_GET["xNIF"].'%';
 $sql= 'SELECT NE,NIF,APENOMBRE FROM VWCierreExpediente WHERE NIF like :xNIF order by nif,ne';
  $stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':xNIF', $xNIF, 14, SQLT_CHR);
$r = oci_execute($stid, OCI_DEFAULT);
$pasa=1;
}
if(isset($_GET["xNombre"])){
	$xNombre = '%'.$_GET["xNombre"].'%';
  $sql='SELECT NE,NIF,APENOMBRE FROM VWCierreExpediente  WHERE APENOMBRE like :xNombre order by APENOMBRE,ne';
$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':xNombre', $xNombre, 40, SQLT_CHR);
$r = oci_execute($stid, OCI_DEFAULT);
$pasa=1;
}
if(isset($_GET["xExpe"])){
	$xExpe = $_GET["xExpe"];
 $sql= 'SELECT NE,NIF,APENOMBRE FROM VWCierreExpediente  WHERE NE=:xExpe';
  $stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':xExpe', $xExpe, 38, SQLT_INT);
$r = oci_execute($stid, OCI_DEFAULT);
$pasa=1;
}
if($pasa==0){
 $sql= 'SELECT NE,NIF,APENOMBRE FROM VWCierreExpediente';

$stid = oci_parse($conn, $sql);

$r = oci_execute($stid, OCI_DEFAULT);
}






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
	$this->Cell(10,30,'Expedientes Finalizados Pendientes de Facturación a fecha de:'.date("d/m/y"));
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
	
	//Cabecera
	$w=array(25,25,140);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],6,$header[$i],1,0,'C',1);
	$this->Ln();
	
	//Restauración de colores y fuentes
	$this->SetFillColor(224,235,300);
	$this->SetTextColor(0);
	$this->SetFont('Times','',10);
	
	//Datos
	$fill=false;
	$Total=0;

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		$this->Cell($w[0],8,$row['NE'],'LR',0,'L',$fill);
		$this->Cell($w[1],8,$row['NIF'],'LR',0,'L',$fill);	
		$this->Cell($w[2],8,$row['APENOMBRE'],'LR',0,'L',$fill);

	
	

		
		
		$this->Ln();
		$fill=!$fill;
		
			
	}
	
	
$this->MultiCell(array_sum($w),0,'','T');
}

}

//Creación del objeto de la clase heredada
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);


	$header=array('NE','NIF','Nombre y Apellidos');	
	
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
