<?php

require('../Redmoon_php/pebi_cn.inc.php');
require('../Redmoon_php/pebi_db.inc.php'); 

$conn = db_connect();

$sql = "select COUNT(*) as solicitudes,to_char(fecha_apertura,'MM') as anio from expedientes
where to_char(fecha_apertura,'YYYY')=2007 
group by to_char(fecha_apertura,'MM')
order by to_char(fecha_apertura,'MM')";
$stid = oci_parse($conn, $sql);
$r = oci_execute($stid, OCI_DEFAULT);

$i=0;
while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
	$vec_solicitudes07[$i]= (int)$row['SOLICITUDES'];
	$vec_anio07[$i]=$row['ANIO'];
	$i++;
}

$sql2 = "select COUNT(*) as solicitudes,to_char(fecha_apertura,'MM') as anio from expedientes
where to_char(fecha_apertura,'YYYY')=2008 
group by to_char(fecha_apertura,'MM')
order by to_char(fecha_apertura,'MM')";

$stid2 = oci_parse($conn, $sql2);
$r = oci_execute($stid2, OCI_DEFAULT);


$b=0;
while($row = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS)){
	$vec_solicitudes08[$b]= (int)$row['SOLICITUDES'];
	
	$vec_anio08[$b]=$row['ANIO'];
	$b++;
}



include 'php-ofc-library/open-flash-chart.php';

//$title = new title( 'Comparativa numero de solicitudes por mes 07/08');


$bar1 = new bar();
$bar1->set_values( $vec_solicitudes07 );
$bar1->set_key( '2007', 12 );
$bar1->set_tooltip( '#bottom#<br>Valor:#val#' );

$bar2 = new bar();
$bar2->set_values( $vec_solicitudes08 );
$bar2->set_colour( '#FF0000');
$bar2->set_key( '2008', 12 );
$bar2->set_tooltip( '#bottom#<br>Valor:#val#' );




$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $bar1 );
$chart->add_element( $bar2 );


$x_labels = new x_axis_labels();
$x_labels->set_steps( 1 );
$x_labels->set_vertical();
$x_labels->set_colour( '#000000' );
$x_labels->set_labels( $vec_anio07 );

$x = new x_axis();
$x->set_colour( '#A2ACBA' );
$x->set_grid_colour( '#D7E4A3' );
//$x->set_offset( false );
$x->set_steps(1);
// Add the X Axis Labels to the X Axis
$x->set_labels( $x_labels );

$chart->set_x_axis( $x );

//
// LOOK:
//
$x_legend = new x_legend( 'Enero a Diciembre' );
$x_legend->set_style( '{font-size: 20px; color: #778877}' );
$chart->set_x_legend( $x_legend );



//creando el eje y

$y = new y_axis();
$y->set_range( 0, 2000,200 );
$chart->set_y_axis( $y );



//leyenda del eje y
$y_legend = new y_legend( 'Numero de solicitudes' );
$y_legend->set_style( '{font-size: 20px; color: #778877}' );
$chart->set_y_legend( $y_legend );

echo $chart->toPrettyString();
?>