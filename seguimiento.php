<?php require('Redmoon_php/controlSesiones.inc.php'); ?>
<?php 
session_start();
require('Redmoon_php/pebi_cn.inc.php');
require('Redmoon_php/pebi_db.inc.php'); 

define('FPDF_FONTPATH','fpdf16/font/');
require('fpdf16/fpdf.php');

//Debug
$time_start = microtime(true);

$conn = db_connect();

$xID=$_GET['xIDExpe'];


//$xIDExpe=98261;
$sql='SELECT ID,NE,ESTADOS_EXPE,DESCRIPCION,FECHA_MOVIMIENTO,IMPORTE,DH,DOCUMENTO FROM VWSEGUI_ASUNTOHIPOTECA where NE=:xID order by FECHA_MOVIMIENTO';
$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ':xID', $xID, 14, SQLT_CHR);


$r = oci_execute($stid, OCI_DEFAULT);


$sql2='SELECT e.oficina,c.nombre,e.tipo_asunto from expedientes e, colaboradores c where e.colaborador=c.id and e.NE=:xID';
$stid2 = oci_parse($conn, $sql2);

oci_bind_by_name($stid2, ':xID', $xID, 14, SQLT_CHR);


$r2 = oci_execute($stid2, OCI_DEFAULT);

$row2 = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS);

$oficina=$row2['OFICINA'];
$gestor=iconv('Windows-1252', 'UTF-8//TRANSLIT', $row2['NOMBRE']);

if ($row2['TIPO_ASUNTO']==1 or $row2['TIPO_ASUNTO']==null)
	$tipo_asunto='Hipotecario';
else 
	$tipo_asunto='Dacion';
	
	
	
$sql3='SELECT NE, NIF, APENOMBRE, MOVIL, TELEFONO FROM VWCLIENTESHIPO WHERE NE=:xID';
$stid3 = oci_parse($conn, $sql3);

oci_bind_by_name($stid3, ':xID', $xID, 14, SQLT_CHR);
$r3 = oci_execute($stid3, OCI_DEFAULT);
$row3 = oci_fetch_array($stid3, OCI_ASSOC+OCI_RETURN_NULLS);
$nombre=$row3['APENOMBRE'];



$sql4='SELECT descripcion,OPR_IMPORTE,IMP_NOTARIA,IMP_IMPUESTO,IMP_REGISTRO,IMP_GESTORIA,TotalPresupuesto FROM VWASUNTOS_EXPEDIENTES WHERE NE=:xID';
 $stid4 = oci_parse($conn, $sql4);
oci_bind_by_name($stid4, ':xID', $xID, 14, SQLT_CHR);

$r4 = oci_execute($stid4, OCI_DEFAULT);

class PDF extends FPDF
{
	
//Cabecera de p�gina
function Header()
{
	if ($row2['TIPO_ASUNTO']==1 or $row2['TIPO_ASUNTO']==null)
	$tipo_asunto='Hipotecario';
	else 
	$tipo_asunto='Dacion';
	//Logo
	$this->Image('Redmoon_img/imgDoc/logo_pdf.jpg',10,8,40);
	
	//Arial bold 15
	$this->SetFont('Arial','B',15);
	//Movernos a la derecha
	$this->Cell(35);
	//T�tulo
	$this->Cell(10,30,'Seguimiento del expediente '.$tipo_asunto.':'.$_GET["xIDExpe"]);
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
	$w=array(130,20,30,10);
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
		
		$this->Cell($w[0],6,$row['DESCRIPCION'],'LR',0,'L',$fill);
		$this->Cell($w[1],6,$row['FECHA_MOVIMIENTO'],'LR',0,'L',$fill);
		if($row['IMPORTE']!=0)
		$this->Cell($w[2],6,number_format($row['IMPORTE']).' �','LR',0,'R',$fill);
		else 
		$this->Cell($w[2],6,' ','LR',0,'R',$fill);
		$this->Cell($w[3],6,$row['DH'],'LR',0,'L',$fill);
	
		
		
		
		$this->Ln();
		$fill=!$fill;
		
			
	}
	
	
$this->Cell(array_sum($w),0,'','T');
}

function FancyTable2($header, $stid4)
{
	//Colores, ancho de l�nea y fuente en negrita
//Colores, ancho de l�nea y fuente en negrita
	$this->SetFillColor(23,68,87);
	$this->SetTextColor(255);
	$this->SetDrawColor(128,0,0);
	$this->SetLineWidth(.3);
	$this->SetFont('','B',10);
	//Cabecera
	$w=array(65,30,20,20,15,15,25);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
	$this->Ln();
	//Restauraci�n de colores y fuentes
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	$this->SetFont('');
	//Datos
	$fill=false;
	$Total=0;

while ($row4 = oci_fetch_array($stid4, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
	
		$this->Cell($w[0],6,$row4['DESCRIPCION'],'LR',0,'L',$fill);
		$this->Cell($w[1],6,number_format($row4['OPR_IMPORTE']).' �','LR',0,'R',$fill);
		$this->Cell($w[2],6,number_format($row4['IMP_NOTARIA']).' �','LR',0,'R',$fill);
		$this->Cell($w[3],6,number_format($row4['IMP_IMPUESTO']).' �','LR',0,'R',$fill);
		$this->Cell($w[4],6,number_format($row4['IMP_REGISTRO']).' �','LR',0,'R',$fill);
		$this->Cell($w[5],6,number_format($row4['IMP_GESTORIA']).' �','LR',0,'R',$fill);
		$this->Cell($w[6],6,number_format($row4['TOTALPRESUPUESTO']).' �','LR',0,'R',$fill);
		$this->Ln();
		$fill=!$fill;
		$Total+=$row4['TOTALPRESUPUESTO'];
			
	}
	
	$this->Cell($w[0],6,'','LR',0,'L',$fill);
	$this->Cell($w[1],6,'','LR',0,'R',$fill);
	$this->Cell($w[2],6,'','LR',0,'R',$fill);
	$this->Cell($w[3],6,'','LR',0,'R',$fill);
	$this->Cell($w[4],6,'','LR',0,'R',$fill);
	$this->Cell($w[5],6,'','LR',0,'R',$fill);
	$this->Cell($w[6],6,number_format($Total).' �','LR',0,'R',$fill);
	$this->Ln();
	$this->Cell(array_sum($w),0,'','T');
	/*
	foreach($data as $row)
	{
		$this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
		$this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
		$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
		$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
		$this->Cell($w[4],6,number_format($row[4]),'LR',0,'R',$fill);
		$this->Ln();
		$fill=!$fill;
	} */
	//$this->Cell(array_sum($w),0,'','T');
}

}

//Creaci�n del objeto de la clase heredada
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->Line(8, 75, 202,75);//linea horizontal abajo
$pdf->Line(8, 55, 202,55);//linea horizontal arriba
$pdf->Line(8, 55, 8,75);
$pdf->Line(202, 55, 202,75);

	$pdf->Cell(40,10,'N� de Oficina: '.$oficina,0,0);
	$pdf->Cell(40,10,'Colaborador: '.iconv('UTF-8','Windows-1252//TRANSLIT',$gestor),0,0);
	$pdf->Ln(20);
	$pdf->MultiCell(0,5,'Datos del Titular');
	$pdf->Ln(2);
	$pdf->Cell(40,10,'NIF: '.$row3['NIF'],0,0);
	$pdf->Cell(40,10,'Nombre: '.iconv('UTF-8','Windows-1252//TRANSLIT',$nombre),0,0);
	$pdf->Ln(6);
	$pdf->Cell(40,10,'M�vil: '.$row3['MOVIL'],0,0);
	$pdf->Cell(40,10,'Tel�fono: '.$row3['TELEFONO'],0,0);
	$pdf->Ln(20);
	$pdf->MultiCell(0,5,'Importe de las Provisiones de Fondos');



	
	$header2=array('Tipo de Acto','Importe','Notar�a','Impuesto','Registro','Gesti�n','Total Provisi�n');
	
	$pdf->FancyTable2($header2,$stid4);
	$pdf->Ln();
		$pdf->Ln(20);
		
	$pdf->MultiCell(0,5,'Listado del Seguimiento');
	$header=array('Descripci�n','Fecha','Importe','Tipo');	
	
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
=======
<?php
require('Redmoon_php/controlSesiones.inc.php');

require('Redmoon_php/pebi_cn.inc.php');
require('Redmoon_php/pebi_db.inc.php'); 

define('FPDF_FONTPATH','fpdf16/font/');
require('fpdf16/fpdf.php');

//Debug
$time_start = microtime(true);

$conn = db_connect();

$xID=$_GET['xIDExpe'];


//$xIDExpe=98261;
$sql='SELECT ID,NE,ESTADOS_EXPE,DESCRIPCION,FECHA_MOVIMIENTO,IMPORTE,DH,DOCUMENTO FROM VWSEGUI_ASUNTOHIPOTECA where NE=:xID order by FECHA_MOVIMIENTO';
$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ':xID', $xID, 14, SQLT_CHR);


$r = oci_execute($stid, OCI_DEFAULT);


$sql2='SELECT e.oficina,c.nombre,e.tipo_asunto from expedientes e, colaboradores c where e.colaborador=c.id and e.NE=:xID';
$stid2 = oci_parse($conn, $sql2);

oci_bind_by_name($stid2, ':xID', $xID, 14, SQLT_CHR);


$r2 = oci_execute($stid2, OCI_DEFAULT);

$row2 = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS);

$oficina=$row2['OFICINA'];
$gestor=$row2['NOMBRE'];

if ($row2['TIPO_ASUNTO']==1 or $row2['TIPO_ASUNTO']==null)
	$tipo_asunto='Hipotecario';
else 
	$tipo_asunto='Dacion';
	
	
	
$sql3='SELECT NE, NIF, APENOMBRE, MOVIL, TELEFONO FROM VWCLIENTESHIPO WHERE NE=:xID';
$stid3 = oci_parse($conn, $sql3);

oci_bind_by_name($stid3, ':xID', $xID, 14, SQLT_CHR);
$r3 = oci_execute($stid3, OCI_DEFAULT);
$row3 = oci_fetch_array($stid3, OCI_ASSOC+OCI_RETURN_NULLS);
$nombre=$row3['APENOMBRE'];



$sql4='SELECT descripcion,OPR_IMPORTE,IMP_NOTARIA,IMP_IMPUESTO,IMP_REGISTRO,IMP_GESTORIA,TotalPresupuesto FROM VWASUNTOS_EXPEDIENTES WHERE NE=:xID';
 $stid4 = oci_parse($conn, $sql4);
oci_bind_by_name($stid4, ':xID', $xID, 14, SQLT_CHR);

$r4 = oci_execute($stid4, OCI_DEFAULT);

class PDF extends FPDF
{
	
//Cabecera de página
function Header()
{
	if ($row2['TIPO_ASUNTO']==1 or $row2['TIPO_ASUNTO']==null)
	$tipo_asunto='Hipotecario';
	else 
	$tipo_asunto='Dacion';
	//Logo
	$this->Image('Redmoon_img/imgDoc/logo_pdf.jpg',10,8,40);
	
	//Arial bold 15
	$this->SetFont('Arial','B',15);
	//Movernos a la derecha
	$this->Cell(35);
	//Título
	$this->Cell(10,30,'Seguimiento del expediente '.iconv('UTF-8', 'windows-1252', $tipo_asunto).': '.$_GET["xIDExpe"]);
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
	$this->Cell(0,10,iconv('UTF-8', 'windows-1252', 'Página ').$this->PageNo().'/{nb}',0,0,'C');
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
	$w=array(130,20,30,10);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],6,iconv('UTF-8', 'windows-1252', $header[$i]),1,0,'C',1);
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
		
		$this->Cell($w[0],6,iconv('UTF-8', 'windows-1252', $row['DESCRIPCION']),'LR',0,'L',$fill);
		$this->Cell($w[1],6,iconv('UTF-8', 'windows-1252', $row['FECHA_MOVIMIENTO']),'LR',0,'L',$fill);
		if($row['IMPORTE']!=0)
		$this->Cell($w[2],6,number_format($row['IMPORTE']).iconv('UTF-8', 'windows-1252', " €"),'LR',0,'R',$fill);
		else 
		$this->Cell($w[2],6,' ','LR',0,'R',$fill);
		$this->Cell($w[3],6,iconv('UTF-8', 'windows-1252', $row['DH']),'LR',0,'L',$fill);
	
		
		
		
		$this->Ln();
		$fill=!$fill;
		
			
	}
	
	
$this->Cell(array_sum($w),0,'','T');
}

function FancyTable2($header, $stid4)
{
	//Colores, ancho de línea y fuente en negrita
//Colores, ancho de línea y fuente en negrita
	$this->SetFillColor(23,68,87);
	$this->SetTextColor(255);
	$this->SetDrawColor(128,0,0);
	$this->SetLineWidth(.3);
	$this->SetFont('','B',10);
	//Cabecera
	$w=array(65,30,20,20,15,15,25);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,iconv('UTF-8', 'windows-1252', $header[$i]),1,0,'C',1);
	$this->Ln();
	//Restauración de colores y fuentes
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	$this->SetFont('');
	//Datos
	$fill=false;
	$Total=0;

while ($row4 = oci_fetch_array($stid4, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
	
		$this->Cell($w[0],6,iconv('UTF-8', 'windows-1252', $row4['DESCRIPCION']),'LR',0,'L',$fill);
		$this->Cell($w[1],6,number_format($row4['OPR_IMPORTE']).iconv('UTF-8', 'windows-1252', " €"),'LR',0,'R',$fill);
		$this->Cell($w[2],6,number_format($row4['IMP_NOTARIA']).iconv('UTF-8', 'windows-1252', " €"),'LR',0,'R',$fill);
		$this->Cell($w[3],6,number_format($row4['IMP_IMPUESTO']).iconv('UTF-8', 'windows-1252', " €"),'LR',0,'R',$fill);
		$this->Cell($w[4],6,number_format($row4['IMP_REGISTRO']).iconv('UTF-8', 'windows-1252', " €"),'LR',0,'R',$fill);
		$this->Cell($w[5],6,number_format($row4['IMP_GESTORIA']).iconv('UTF-8', 'windows-1252', " €"),'LR',0,'R',$fill);
		$this->Cell($w[6],6,number_format($row4['TOTALPRESUPUESTO']).iconv('UTF-8', 'windows-1252', " €"),'LR',0,'R',$fill);
		$this->Ln();
		$fill=!$fill;
		$Total+=$row4['TOTALPRESUPUESTO'];
			
	}
	
	$this->Cell($w[0],6,'','LR',0,'L',$fill);
	$this->Cell($w[1],6,'','LR',0,'R',$fill);
	$this->Cell($w[2],6,'','LR',0,'R',$fill);
	$this->Cell($w[3],6,'','LR',0,'R',$fill);
	$this->Cell($w[4],6,'','LR',0,'R',$fill);
	$this->Cell($w[5],6,'','LR',0,'R',$fill);
	$this->Cell($w[6],6,number_format($Total).iconv('UTF-8', 'windows-1252', " €"),'LR',0,'R',$fill);
	$this->Ln();
	$this->Cell(array_sum($w),0,'','T');
	/*
	foreach($data as $row)
	{
		$this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
		$this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
		$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
		$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
		$this->Cell($w[4],6,number_format($row[4]),'LR',0,'R',$fill);
		$this->Ln();
		$fill=!$fill;
	} */
	//$this->Cell(array_sum($w),0,'','T');
}

}

//Creación del objeto de la clase heredada
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->Line(8, 75, 202,75);//linea horizontal abajo
$pdf->Line(8, 55, 202,55);//linea horizontal arriba
$pdf->Line(8, 55, 8,75);
$pdf->Line(202, 55, 202,75);

	$pdf->Cell(40,10, iconv('UTF-8', 'windows-1252', 'Nº de Oficina: ').$oficina,0,0);
	$pdf->Cell(40,10,'Colaborador: '.iconv('UTF-8', 'windows-1252', $gestor),0,0);
	$pdf->Ln(20);
	$pdf->MultiCell(0,5,'Datos del Titular');
	$pdf->Ln(2);
	$pdf->Cell(40,10,'NIF: '.$row3['NIF'],0,0);
	$pdf->Cell(40,10,'Nombre: '.iconv('UTF-8', 'windows-1252', $nombre),0,0);
	$pdf->Ln(6);
	$pdf->Cell(40,10,iconv('UTF-8', 'windows-1252', 'Móvil: ').$row3['MOVIL'],0,0);
	$pdf->Cell(40,10,iconv('UTF-8', 'windows-1252', 'Teléfono: ').$row3['TELEFONO'],0,0);
	$pdf->Ln(20);
	$pdf->MultiCell(0,5,'Importe de las Provisiones de Fondos');



	
	$header2=array('Tipo de Acto','Importe', 'Notaría','Impuesto','Registro', 'Gestión', 'Total Provisión');
	
	$pdf->FancyTable2($header2,$stid4);
	$pdf->Ln();
		$pdf->Ln(20);
		
	$pdf->MultiCell(0,5,'Listado del Seguimiento');
	$header=array('Descripción' ,'Fecha','Importe','Tipo');	
	
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
>>>>>>> .r60
