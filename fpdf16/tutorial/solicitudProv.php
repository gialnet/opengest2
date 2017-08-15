<?php 

require('../../Redmoon_php/pebi_cn.inc');
require('../../Redmoon_php/pebi_db.inc'); 

define('FPDF_FONTPATH','../font/');
require('../fpdf.php');

$conn = db_connect();

//$xIDExpe=$_GET["xIDExpe"];
$xIDExpe=98261;
$sql='SELECT NIF, APENOMBRE, TELEFONO,PROVINCIA,DOMICILIO, poblacion, numerocuenta
FROM VWCLIENTESEXPE WHERE NE=:xIDExpe';
$stid = oci_parse($conn, $sql);


oci_bind_by_name($stid, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);

$r = oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
	$xCuenta=$row['NUMEROCUENTA'];
	$xEntidad=substr($xCuenta,0,4);
	$xOficina=substr($xCuenta,4,4);
	$xNCuenta=substr($xCuenta,10,10);
	$xDControl=substr($xCuenta,8,2);




$sql2='select o.oficina,o.telefono,o.fax,o.persona_contacto,e.num_prestamo
from oficinas o,expedientes e
where o.oficina=e.oficina and e.ne=:xIDExpe';
$stid2 = oci_parse($conn, $sql2);


oci_bind_by_name($stid2, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);

$r2 = oci_execute($stid2, OCI_DEFAULT);
$row2 = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS);

$sql3='select sum(IMP_NOTARIA+IMP_IMPUESTO+IMP_REGISTRO+IMP_GESTORIA+IMP_PLUSVALIA) AS IMP_PROVISION from asuntos_expediente where NE=:xIDExpe';
$stid3 = oci_parse($conn, $sql3);
oci_bind_by_name($stid3, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);


$r3 = oci_execute($stid3, OCI_DEFAULT);
$row3 = oci_fetch_array($stid3, OCI_ASSOC+OCI_RETURN_NULLS);


$sql4='SELECT descripcion,OPR_IMPORTE,IMP_NOTARIA,IMP_IMPUESTO,IMP_REGISTRO,IMP_GESTORIA,TotalPresupuesto FROM VWASUNTOS_EXPEDIENTES WHERE NE=:xIDExpe';
 $stid4 = oci_parse($conn, $sql4);
oci_bind_by_name($stid4, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);

$r4 = oci_execute($stid4, OCI_DEFAULT);


class PDF extends FPDF
{
//Cabecera de página
function Header()
{
	//Logo
	$this->Image('../../Redmoon_img/logo_lgs.jpg',10,8,40);
	//Arial bold 15
	$this->SetFont('Arial','B',15);
	//Movernos a la derecha
	$this->Cell(40);
	//Título
	$this->Cell(10,30,'Solicitud Provisión de Fondos y Tramitación');
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
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
function FancyTable($header,$stid4)
{
	//Colores, ancho de línea y fuente en negrita
	$this->SetFillColor(255,0,0);
	$this->SetTextColor(255);
	$this->SetDrawColor(128,0,0);
	$this->SetLineWidth(.3);
	$this->SetFont('','B',10);
	//Cabecera
	$w=array(65,30,20,20,15,15,25);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
	$this->Ln();
	//Restauración de colores y fuentes
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	$this->SetFont('');
	//Datos
	$fill=false;
	

while ($row4 = oci_fetch_array($stid4, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
	
		$this->Cell($w[0],6,$row4['DESCRIPCION'],'LR',0,'L',$fill);
		$this->Cell($w[1],6,number_format($row4['OPR_IMPORTE']).'€','LR',0,'R',$fill);
		$this->Cell($w[2],6,number_format($row4['IMP_NOTARIA']).'€','LR',0,'R',$fill);
		$this->Cell($w[3],6,number_format($row4['IMP_IMPUESTO']).'€','LR',0,'R',$fill);
		$this->Cell($w[4],6,number_format($row4['IMP_REGISTRO']).'€','LR',0,'R',$fill);
		$this->Cell($w[5],6,number_format($row4['IMP_GESTORIA']).'€','LR',0,'R',$fill);
		$this->Cell($w[6],6,number_format($row4['TOTALPRESUPUESTO']).'€','LR',0,'R',$fill);
		$this->Ln();
		$fill=!$fill;
			
	}
	
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

	$pdf->Cell(40,10,'Nº de Oficina: '.$row2['OFICINA'],0,0);
	$pdf->Cell(50,10,'Telefono: '.$row2['TELEFONO'],0,0);
	
	$pdf->Cell(33,10,'Contacto: '.$row2['PERSONA_CONTACTO'],0,1);
	$pdf->Cell(40,10,'NIF: '.$row['NIF'],0,0);
	$pdf->Cell(0,10,iconv ('UTF-8//TRANSLIT','Windows-1252',$row['APENOMBRE']),0,1);
	$pdf->Cell(90,10,'Domicilio: '.$row['DOMICILIO'],0,0);
	$pdf->Cell(40,10,'Población: '.iconv ('UTF-8//TRANSLIT','Windows-1252', $row['POBLACION']),0,1);
	$pdf->Cell(90,10,'Número de Cuenta: '.$xEntidad.'-'.$xOficina.'-'.$xDControl.'-'.$xNCuenta,0,0);
	$pdf->Cell(40,10,'Número de Prestamo: '.$row2['NUM_PRESTAMO'],0,1);
	
	$header=array('Tipo de Acto','Importe del Acto','Notaría','Impuesto','Registro','Gestión','Total Provisión');
//Carga de datos
//$data=$pdf->LoadData('paises.txt');
	$pdf->FancyTable($header,$stid4);
$pdf->Output();
?>
