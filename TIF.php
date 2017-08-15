<?php
require('Redmoon_php/controlSesiones.inc.php'); 
$mi_pdf = $_GET["xFile"];
header('Content-type: image/tiff');
header('Content-Disposition: inline; filename="'.$mi_pdf.'"');
readfile($mi_pdf);
?>