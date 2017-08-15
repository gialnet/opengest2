<?php

require('../Redmoon_php/pebi_cn.inc.php');
require('../Redmoon_php/pebi_db.inc.php'); 

$conn = db_connect();

$xANIOS=date("Y");
$xANIOS=$xANIOS-4;
$sql = "select sum(e.cuantia)/1000 as Importe,  to_char(e.fecha_apertura,'YYYY') as anio 
from expedientes e, CLIENTES_EXPE s
	where  e.ne= s.ne AND s.sujeto='T' and substr(s.NIF_CLIENTE,1,1) in ('N','W')
   and to_char(e.fecha_apertura,'YYYY')>=:xANIOS
	group by to_char(e.fecha_apertura,'YYYY')
	order by to_char(e.fecha_apertura,'YYYY')";
$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':xANIOS', $xANIOS, 4, SQLT_CHR);
$r = oci_execute($stid, OCI_DEFAULT);

$i=0;
while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
	$vec_solicitudes[$i]= (double)$row['IMPORTE'];
	$vec_anio[$i]=$row['ANIO'];
	$i++;
}

include 'php-ofc-library/open-flash-chart.php';

$title = new title( 'Importe de las solicitudes de empresas extranjeras por anios');

$bar = new bar();
$bar->set_values( $vec_solicitudes );
//$bar->set_tooltip( '#bottom#<br>Valor:#val#' );


$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $bar );


$x_labels = new x_axis_labels();
$x_labels->set_steps( 1 );
//$x_labels->set_vertical();
$x_labels->set_colour( '#000000' );
$x_labels->set_labels( $vec_anio );

$x = new x_axis();
$x->set_colour( '#A2ACBA' );
$x->set_grid_colour( '#D7E4A3' );
//$x->set_offset( false );
$x->set_steps(4);
// Add the X Axis Labels to the X Axis
$x->set_labels( $x_labels );

$chart->set_x_axis( $x );

//
// LOOK:
//
//$x_legend = new x_legend( 'Anios' );
//$x_legend->set_style( '{font-size: 20px; color: #778877}' );
//$chart->set_x_legend( $x_legend );



//creando el eje y

$y = new y_axis();
$y->set_range( 0, 3000,500 );
$chart->set_y_axis( $y );



//leyenda del eje y
$y_legend = new y_legend( 'En miles de euros' );
$y_legend->set_style( '{font-size: 20px; color: #778877}' );
$chart->set_y_legend( $y_legend );

echo $chart->toPrettyString();

?>