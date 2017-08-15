<?php

require('../Redmoon_php/pebi_cn.inc.php');
require('../Redmoon_php/pebi_db.inc.php'); 

$conn = db_connect();


//$conn = oci_connect('dbo_lgs_db','dbo_lgs_db','//cajalgs.no-ip.org/lgs');
$sql = "select COUNT(*) as solicitudes,to_char(fecha_apertura,'MM') as anio from expedientes
where to_char(fecha_apertura,'YYYY')=2005 
group by to_char(fecha_apertura,'MM')
order by to_char(fecha_apertura,'MM')";
$stid = oci_parse($conn, $sql);
$r = oci_execute($stid, OCI_DEFAULT);

$i=0;
while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
	$vec_solicitudes05[$i]= (int)$row['SOLICITUDES'];
	$vec_anio05[$i]=$row['ANIO'];
	$i++;
}

$sql2 = "select COUNT(*) as solicitudes,to_char(fecha_apertura,'MM') as anio from expedientes
where to_char(fecha_apertura,'YYYY')=2004 
group by to_char(fecha_apertura,'MM')
order by to_char(fecha_apertura,'MM')";
$stid2 = oci_parse($conn, $sql2);
$r = oci_execute($stid2, OCI_DEFAULT);


$b=0;
while($row = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS)){
	$vec_solicitudes04[$b]= (int)$row['SOLICITUDES'];
	
	$vec_anio06[$b]=$row['ANIO'];
	$b++;
}



include 'php-ofc-library/open-flash-chart.php';

$title = new title( 'Comparativa numero de solicitudes por mes 05/06');


$bar1 = new bar();
$bar1->set_values( $vec_solicitudes04 );
$bar1->set_key( '2004', 12 );
$bar1->set_tooltip( '#bottom#<br>Valor:#val#' );

$bar2 = new bar();
$bar2->set_values( $vec_solicitudes05 );
$bar2->set_colour( '#d0d030');
$bar2->set_key( '2005', 12 );
$bar2->set_tooltip( '#bottom#<br>Valor:#val#' );




$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $bar1 );
$chart->add_element( $bar2 );


$x_labels = new x_axis_labels();
$x_labels->set_steps( 1 );
$x_labels->set_vertical();
$x_labels->set_colour( '#000000' );
$x_labels->set_labels( $vec_anio04 );

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
$y->set_range( 0, 1400,200 );
$chart->set_y_axis( $y );



//leyenda del eje y
$y_legend = new y_legend( 'Numero de solicitudes' );
$y_legend->set_style( '{font-size: 20px; color: #778877}' );
$chart->set_y_legend( $y_legend );

echo $chart->toPrettyString();
?>