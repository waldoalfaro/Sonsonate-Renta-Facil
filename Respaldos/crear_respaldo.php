<?php
include "../conexion.php";

$fecha = date("Ymd_His");
$zipFile = "respaldos/respaldo_$fecha.zip";
$sqlFile = "respaldos/backup_$fecha.sql";

exec("mysqldump -u $username -p$password $dbname > $sqlFile");

$zip = new ZipArchive();
$zip->open($zipFile, ZipArchive::CREATE);

// Agregar BD
$zip->addFile($sqlFile, basename($sqlFile));

// Agregar archivos del sistema
function agregarCarpeta($zip, $ruta, $carpetaZip = "") {
    $archivos = scandir($ruta);

    foreach ($archivos as $archivo) {
        if ($archivo == "." || $archivo == "..") continue;

        $rutaCompleta = $ruta . "/" . $archivo;

        if (is_dir($rutaCompleta)) {
            agregarCarpeta($zip, $rutaCompleta, $carpetaZip . $archivo . "/");
        } else {
            $zip->addFile($rutaCompleta, $carpetaZip . $archivo);
        }
    }
}

agregarCarpeta($zip, "..");

$zip->close();

unlink($sqlFile);

header("Location: index_respaldo.php");
?>
