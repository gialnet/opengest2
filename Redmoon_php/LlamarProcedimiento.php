<?php 

require('controlSesiones.inc.php');  
require('pebi_cn.inc.php');
require('pebi_db.inc.php');  


$conn = db_connect();

$sql = 'BEGIN HTMLBuscaNIF(:xNIF, :xRespuesta); END;';

$stmt = oci_parse($conn, $sql);

oci_bind_by_name($stmt, ':xNIF', $xNIF, 14, SQLT_CHR);
oci_bind_by_name($stmt, ':xRespuesta', $xRespuesta, 4000, SQLT_CHR);

$xNIF='23781553J';

oci_execute($stmt);

echo $xRespuesta;

?>
