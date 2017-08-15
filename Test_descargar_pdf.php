<?php
$mi_pdf = $_GET["xFile"];
$descarga=file_get_contents($mi_pdf);
echo $descarga;
unset ($descarga);
?>