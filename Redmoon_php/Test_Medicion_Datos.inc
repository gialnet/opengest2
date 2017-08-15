
<?php 
$sql="insert into METRICASENVIODATOS (url, numero_bytes, opcion, tiempo) values (:url,:numero_bytes,:opcion,:time) ";

$stmt = oci_parse($conn, $sql);
if (!$stmt)
	echo "************Error*************";

oci_bind_by_name($stmt, ':url', $url, 50, SQLT_CHR);
oci_bind_by_name($stmt, ':numero_bytes', $numero_bytes, 20, SQLT_CHR);
oci_bind_by_name($stmt, ':opcion', $opcion, 100, SQLT_CHR);
oci_bind_by_name($stmt, ':time', $time, 20, SQLT_CHR);

oci_execute($stmt);
if (!$stmt)
	echo "************Error ejecucion******";

?>
