<?php require('Redmoon_php/controlSesiones.inc.php');  ?>
<?php 

require('Redmoon_php/pebi_cn.inc.php');
require('Redmoon_php/pebi_db.inc.php'); 

define('FPDF_FONTPATH','fpdf16/font/');
require('fpdf16/fpdf.php');

$conn = db_connect();

$xIDExpe=$_GET["xIDExpe"];
//$xIDExpe=98261;
$sql='SELECT NIF, APENOMBRE, TELEFONO,PROVINCIA,DOMICILIO, poblacion, numerocuenta FROM VWCLIENTESHIPO WHERE NE=:xIDExpe';
$stid = oci_parse($conn, $sql);


oci_bind_by_name($stid, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);

$r = oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
	$xCuenta=$row['NUMEROCUENTA'];
	$xEntidad=substr($xCuenta,0,4);
	$xOficina=substr($xCuenta,4,4);
	$xNCuenta=substr($xCuenta,10,10);
	$xDControl=substr($xCuenta,8,2);




$sql2='select o.oficina,o.telefono,o.fax,o.persona_contacto,e.num_prestamo,e.fecha_firma
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

$sql5='SELECT N.NOMBRE,n.cod_notario
	FROM NOTARIOS N ,EXPEDIENTES E
	WHERE  E.NE=:xIDExpe AND E.COD_NOTARIO=N.COD_NOTARIO';
 $stid5 = oci_parse($conn, $sql5);
oci_bind_by_name($stid5, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);

$r5 = oci_execute($stid5, OCI_DEFAULT);
$row5 = oci_fetch_array($stid5, OCI_ASSOC+OCI_RETURN_NULLS);

$sql6='select ID,CALLE,MUNICIPIO,REGISTRO from FINCAS where NE=:xIDExpe';
 $stid6 = oci_parse($conn, $sql6);
oci_bind_by_name($stid6, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);

$r6 = oci_execute($stid6, OCI_DEFAULT);
$row6 = oci_fetch_array($stid6, OCI_ASSOC+OCI_RETURN_NULLS);

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
	$this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
}
function FancyTable($header,$stid4)
{
	//Colores, ancho de línea y fuente en negrita
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
	//Restauración de colores y fuentes
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	$this->SetFont('');
	//Datos
	$fill=false;
	$Total=0;

while ($row4 = oci_fetch_array($stid4, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
	
		$this->Cell($w[0],6,$row4['DESCRIPCION'],'LR',0,'L',$fill);
		$this->Cell($w[1],6,number_format($row4['OPR_IMPORTE']).' €','LR',0,'R',$fill);
		$this->Cell($w[2],6,number_format($row4['IMP_NOTARIA']).' €','LR',0,'R',$fill);
		$this->Cell($w[3],6,number_format($row4['IMP_IMPUESTO']).' €','LR',0,'R',$fill);
		$this->Cell($w[4],6,number_format($row4['IMP_REGISTRO']).' €','LR',0,'R',$fill);
		$this->Cell($w[5],6,number_format($row4['IMP_GESTORIA']).' €','LR',0,'R',$fill);
		$this->Cell($w[6],6,number_format($row4['TOTALPRESUPUESTO']).' €','LR',0,'R',$fill);
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
	$this->Cell($w[6],6,number_format($Total).' €','LR',0,'R',$fill);
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
$pdf->SetFont('Times','',9);


$pdf->Line(8, 97, 202,97);//linea horizontal abajo
$pdf->Line(8, 40, 202,40);//linea horizontal arriba
$pdf->Line(8, 40, 8,97);
$pdf->Line(202, 40, 202,97);
$pdf->Cell(40,10,'Fecha: '.date("d/m/y"),0,0);
$pdf->Cell(50,10,'Hora: '.date( "h:i:s"),0,1);
	
	$pdf->Cell(90,8,'Notario: '.iconv('UTF-8','Windows-1252//TRANSLIT',$row5['NOMBRE']),0,0);
	$pdf->Cell(40,8,'Fecha de Firma: '.$row2['FECHA_FIRMA'],0,1);
	
	$pdf->Cell(40,8,'Registro de la Propiedad: '.iconv('UTF-8','Windows-1252//TRANSLIT',$row6['REGISTRO']),0,1);
	$pdf->Cell(40,8,'Nº de Oficina: '.$row2['OFICINA'],0,0);
	$pdf->Cell(50,8,'Telefono: '.$row2['TELEFONO'],0,0);
	
	$pdf->Cell(33,8,'Contacto: '.$row2['PERSONA_CONTACTO'],0,1);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(40,8,'DATOS DEL TITULAR ',0,1);
	$pdf->SetFont('Times','',10);
	$pdf->Cell(40,8,'NIF: '.$row['NIF'],0,0);
	$pdf->Cell(0,8,iconv ('UTF-8//TRANSLIT','Windows-1252',$row['APENOMBRE']),0,1);
	$pdf->Cell(90,8,'Domicilio: '.iconv('UTF-8','Windows-1252//TRANSLIT',$row['DOMICILIO']),0,0);
	$pdf->Cell(40,8,'Población: '.iconv ('UTF-8//TRANSLIT','Windows-1252', $row['POBLACION']),0,1);
	$pdf->Cell(90,8,'Número de Cuenta: '.$xEntidad.'-'.$xOficina.'-'.$xDControl.'-'.$xNCuenta,0,0);
	$pdf->Cell(40,8,'Número de Prestamo: '.$row2['NUM_PRESTAMO'],0,1);
	$pdf->Ln(4);
	$header=array('Tipo de Acto','Importe del Acto','Notaría','Impuesto','Registro','Gestión','Total Provisión');
	
	$pdf->FancyTable($header,$stid4);
	$pdf->SetFont('Times','',9);
	$pdf->Ln(4);
	/*$pdf->MultiCell(0,5,'Los intervienientes han sido informados de forma previa e inequivoca de la existencia de un fichero de datos, según lo establecido en la Ley Orgánica 15/1999, de 13 de diciembre, sobre protección de datos de carácter personal y a tal efecto, autorizan expresamente a la Caja General de Ahorros de Granada para incluir los datos que se obtengan en esta solicitud en dicho fichero. Los intervinientes podrán ejercitar los derechos de acceso, rectificación, cancelación y oposición dirigiéndose al responsable del fichero, Caja General de Ahorros de Granada, con domicilio en Carretera de Armilla nº6, C.P.:18006, Granada.');
	$pdf->Ln(4);
	$pdf->MultiCell(0,5,'Igualmente los intervinientes autorizan expresamente a la Caja General de Ahorros de Granada para que ceda los datos personales que constan en el presente documento a la empresa o firma de servicios que se dirá, la cual se encargará de la tramitación y gestión necesarias para la oportuna liquidación de impuestos e inscripción registral de las escrituras, pólizas y demás documentos que se suscriban los intevinientes con motivo de la operación de la que es objeto el presente documento y ello a los solos fines de facilitar la citada tramitación y gestión, pudiendo no obstante ejercitar los derechos de acceso, rectificación, cancelación y oposición dirigiéndose al responsable de la citada firma, en le domicilio que seguidamente se expresará:');
	$pdf->Ln(4);
	$pdf->MultiCell(0,5,'Empresa o firma encargada de la tramitación y gestión de los documentos de la operación de la que es objeto el presente documento: La General Servicios S.L. Calle Reyes Católicos 51-2º Dcha. 18005 Granada');
	$pdf->Ln(4);
	$pdf->MultiCell(0,5,'Reponsable del fichero y domicilio: Caja General de Ahorros. Carretera de Armilla nº6 C.P. 18006 Granada');
	*/$pdf->Ln(2);
	$pdf->SetFont('Times','B',9);
	$pdf->Cell(0,10,'AUTORIZACIÓN PARA CARGO Y TRAMITACIÓN DE LA OPERACIÓN:',0,1);
	$pdf->Ln(4);
	$pdf->SetFont('Times','',9);
	$pdf->Cell(40,10,'FDO.',0,1);
	$pdf->Ln(4);
	$pdf->Cell(120);
	$pdf->Cell(70,10,'EL/LOS TITULARES PRESTATARIOS',0,1);
	$pdf->Ln(4);
	$pdf->SetFont('Times','',7);
	//$pdf->MultiCell(0,3,'En el caso de que la provisión de fondos efectuada sea insuficiente, el solicitante se compromete a completar la diferencia de forma inmediata, facultando irrevocablemente a L.G.S, S.L. para que cargue el importe de dicha diferencia en su cuenta número 2031-0077-31-3015497606, abierta en la Oficina 77 de la Caja General de Ahorros de Granada, quedando L.G.S, S.L. obligada a justificar cumplidamenteante ante el solicitante dicho cargo o, en su caso, la petición de abono de la diferencia, con entrega al mismo de los documentos que acrediten uno y otro extremo.');
	$pdf->Ln(4);
	$pdf->SetFont('Times','B',9);
	$pdf->Cell(0,10,'IMPORTANTE: ADJUNTESE A ESTE IMPRESO LA FOTOCOPIA DEL DNI/NIF/CIF',0,1);
	
	

	
$pdf->Output();
?>
