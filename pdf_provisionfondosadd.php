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
  $sql='SELECT NE,NIF,APENOMBRE,PROVISION,PROINGRE FROM VWPENDIENTES_PROVISION WHERE NIF like :xNIF order by nif,ne';
  $stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':xNIF', $xNIF,14, SQLT_CHR);
$r = oci_execute($stid, OCI_DEFAULT);
$pasa=1;
}

if(isset($_GET["xNombre"])){
	$xNombre = '%'.$_GET["xNombre"].'%';
 $sql= 'SELECT NE,NIF,APENOMBRE,PROVISION,PROINGRE FROM VWPENDIENTES_PROVISION  WHERE APENOMBRE like :xNombre order by APENOMBRE,ne';
$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ':xNombre', $xNombre,40, SQLT_CHR);
$r = oci_execute($stid, OCI_DEFAULT);
$pasa=1;
}

if(isset($_GET["xExpe"])){
	$xExpe = $_GET["xExpe"];
  $sql= 'SELECT NE,NIF,APENOMBRE,PROVISION,PROINGRE FROM VWPENDIENTES_PROVISION  WHERE NE=:xExpe';
  $stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':xExpe', $xExpe,38, SQLT_INT);
$r = oci_execute($stid, OCI_DEFAULT);
$pasa=1;
}

if($pasa==0){
 $sql='SELECT NE,NIF,APENOMBRE,PROVISION,PROINGRE FROM VWPENDIENTES_PROVISION';

$stid = oci_parse($conn, $sql);

$r = oci_execute($stid, OCI_DEFAULT);
}






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
	$this->Cell(10);
	//T�tulo
	$this->Cell(10,30,'Expedientes Pendientes de Provisiones de Fondos a fecha de:'.date("d/m/y"));
	$this->Cell(200);
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
	$w=array(25,30,120,52,50);
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
	$Total2=0;
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		$this->Cell($w[0],6,$row['NE'],'LR',0,'L',$fill);
		$this->Cell($w[1],6,$row['NIF'],'LR',0,'L',$fill);	
		$this->Cell($w[2],6,$row['APENOMBRE'],'LR',0,'L',$fill);
		$this->Cell($w[3],6,number_format($row['PROVISION']).' �','LR',0,'R',$fill);
		$this->Cell($w[4],6,number_format($row['PROINGRE']).' �','LR',0,'R',$fill);
	
	

		
		
		$this->Ln();
		$fill=!$fill;
		$Total+=$row['PROINGRE'];
		$Total2+=$row['PROVISION'];	
	}
	
	
$this->Cell($w[0],6,'','LR',0,'L',$fill);
	$this->Cell($w[1],6,'','LR',0,'R',$fill);
	$this->Cell($w[2],6,'TOTAL','LR',0,'R',$fill);
	$this->Cell($w[3],6,number_format($Total2).' �','LR',0,'R',$fill);
	$this->Cell($w[4],6,number_format($Total).' �','LR',0,'R',$fill);
	$this->Ln();
	$this->Cell(array_sum($w),0,'','T');
}

}

//Creaci�n del objeto de la clase heredada
$pdf=new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',15);


	$header=array('NE','NIF','Nombre','Provisi�n','Ingresado');	
	
	$pdf->FancyTable($header, $stid);
	


	
$pdf->Output();

// descomentar para grabar estadisticas de medici�n de caudal

// A configurar en cada m�dulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;
	
$numero_bytes=0;
$url='pdf_provisionfondosadd.php';
$opcion='Listado de expedientes entre fechas a pdf';

include 'Redmoon_php/Test_Medicion_Datos.inc';

?>
