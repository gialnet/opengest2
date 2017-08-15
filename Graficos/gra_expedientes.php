<?php
require('../Redmoon_php/pebi_cn.inc.php');
require('../Redmoon_php/pebi_db.inc.php'); 

$conn = db_connect();

$sql = "select COUNT(*) as solicitudes,to_char(fecha_apertura,'YYYY') as anio from expedientes
group by to_char(fecha_apertura,'YYYY')
order by to_char(fecha_apertura,'YYYY')";

$stid = oci_parse($conn, $sql);
$r = oci_execute($stid, OCI_DEFAULT);

$i=0;
while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
	$vec_solicitudes[$i]= (int)$row['SOLICITUDES'];
	$vec_anio[$i]=$row['ANIO'];
	$i++;
}

include 'php-ofc-library/open-flash-chart.php';


$bar = new bar();
$bar->set_values( $vec_solicitudes );
//$bar->set_tooltip( '#bottom#<br>Valor:#val#' );


$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $bar );


$x_labels = new x_axis_labels();
$x_labels->set_steps( 1 );
$x_labels->set_vertical();
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
$y->set_range( 0, 15000,2000);
$chart->set_y_axis( $y );

//leyenda del eje y
$y_legend = new y_legend( 'N expedientes' );
$y_legend->set_style( '{font-size: 20px; color: #778877}' );
$chart->set_y_legend( $y_legend );

echo $chart->toPrettyString();

?>