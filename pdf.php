<?php
require_once('Redmoon_php/controlSesiones.inc.php');

$mi_pdf = $_GET["xFile"];
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="'.$mi_pdf.'"');
readfile($mi_pdf);
?>