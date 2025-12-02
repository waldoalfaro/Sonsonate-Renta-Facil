<?php
include "../conexion.php";

$fecha = date("Ymd_His");
$archivo = "respaldos/bd_$fecha.sql";

exec("mysqldump -u $username -p$password $dbname > $archivo");

header("Location: index_respaldo.php");
?>
