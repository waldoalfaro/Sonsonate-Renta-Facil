<?php
require_once '../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;
include '../conexion.php';

session_start();

// Verificar usuario logueado
if (!isset($_SESSION['id_usuario'])) {
    die("Acceso denegado");
}

$id_usuario = $_SESSION['id_usuario'];

// Datos del arrendador (usuario logueado)
$sql_arrendador = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
$res_arrendador = $conn->query($sql_arrendador);
$arrendador = $res_arrendador->fetch_assoc();

if (!isset($_GET['id_contrato'])) {
    die("ID de contrato no proporcionado.");
}

$id_contrato = intval($_GET['id_contrato']);
$sql = "SELECT c.*, v.marca, v.modelo, v.anio, v.color, v.placa, v.vin
        FROM contratos c
        INNER JOIN vehiculos v ON c.id_vehiculo = v.id_vehiculo
        WHERE c.id_contrato = $id_contrato";
$res = $conn->query($sql);
if ($res->num_rows === 0) {
    die("Contrato no encontrado.");
}
$data = $res->fetch_assoc();

// ✅ Ruta absoluta del logo (necesario para Dompdf)
$logo_path = realpath('../logo2.png');
$logo_base64 = '';
if ($logo_path && file_exists($logo_path)) {
    $logo_data = file_get_contents($logo_path);
    $logo_base64 = 'data:image/png;base64,' . base64_encode($logo_data);
}


$formatter = new IntlDateFormatter(
    'es_ES',
    IntlDateFormatter::LONG,
    IntlDateFormatter::NONE,
    'America/El_Salvador',
    IntlDateFormatter::GREGORIAN,
    "MMMM 'de' yyyy"
);
$fecha_formateada = $formatter->format(new DateTime());


// 📜 HTML del contrato
$html = '
<html>
<head>
<style>
@page { margin: 50px 60px; }
body {
    font-family: "Times New Roman", serif;
    font-size: 13px;
    line-height: 1.6;
    color: #111;
}
.header {
    text-align: center;
    margin-bottom: 25px;
    border-bottom: 2px solid #e0b000;
    padding-bottom: 10px;
}
.logo {
    width: 90px;
    margin-bottom: 5px;
}
h2 {
    font-size: 18px;
    color: #2c2c2c;
    margin: 5px 0;
    letter-spacing: 1px;
}
p { text-align: justify; margin-bottom: 10px; }
b { color: #000; }
.section-title {
    font-weight: bold;
    text-transform: uppercase;
    color: #333;
    margin-top: 12px;
}
.signature-table {
    width: 100%;
    margin-top: 30px;
}
.signature-table td {
    text-align: center;
    padding-top: 30px;
    font-size: 13px;
}
footer {
    position: fixed;
    bottom: -10px;
    left: 0;
    right: 0;
    text-align: center;
    border-top: 2px solid #e0b000;
    padding-top: 5px;
    font-size: 11px;
    color: #444;
}
</style>
</head>
<body>

<div class="header">
    <img src="' . $logo_base64 . '" class="logo"><br>
    <h2><b>SONSONATE RENTA FÁCIL</b></h2>
</div>

<p>
Nosotros, <b>' . strtoupper($arrendador['nombre']) . '</b>, de domicilio en Sonsonate,
a quien en adelante me llamaré <b>"EL ARRENDANTE"</b>; y por otra parte comparece el señor
<b>' . strtoupper($data['cliente_nombre']) . '</b>, portador del documento único de identidad número
<b>' . $data['cliente_dui'] . '</b>, a quien en adelante me llamaré <b>"EL ARRENDATARIO"</b>,
por medio de este documento celebramos un <b>CONTRATO DE ARRENDAMIENTO SIMPLE DE UN AUTOMÓVIL</b>,
que se regirá por las siguientes cláusulas:
</p>

<p class="section-title">I) OBJETO:</p>
<p>
El arrendador entrega en arrendamiento al arrendatario el vehículo cuyas características son:
Placas <b>' . $data['placa'] . '</b>, Marca <b>' . $data['marca'] . '</b>, Modelo <b>' . $data['modelo'] . '</b>,
Año <b>' . $data['anio'] . '</b>, Color <b>' . $data['color'] . '</b>, VIN <b>' . $data['vin'] . '</b>.
</p>

<p class="section-title">II) FINALIDAD:</p>
<p>
El vehículo arrendado será destinado por el arrendatario para uso particular.
</p>

<p class="section-title">III) PLAZO:</p>
<p>
El plazo del arrendamiento será del <b>' . $data['fecha_inicio'] . '</b> al <b>' . $data['fecha_fin'] . '</b>.
</p>

<p class="section-title">IV) PRECIO DEL ARRENDAMIENTO:</p>
<p>
El precio convenido es de <b>$' . number_format($data['total_contrato'], 2) . ' DÓLARES</b>,
que el arrendatario pagará al arrendante al inicio del contrato.
</p>

<p class="section-title">V) MANTENIMIENTO DEL VEHÍCULO:</p>
<p>
El arrendatario se compromete a mantener el vehículo en buen estado. Cualquier daño causado será responsabilidad del arrendatario.
</p>

<p class="section-title">VI) CLÁUSULA PENAL:</p>
<p>
La mora en el pago por más de tres días consecutivos dará por terminado el contrato sin necesidad de requerimiento judicial.
</p>

<p class="section-title">VII) JURISDICCIÓN:</p>
<p>
Para los efectos legales del presente contrato, las partes señalan como domicilio especial la ciudad de Sonsonate,
sometiéndose a sus tribunales en caso de acción judicial.
</p>

<p>
En fe de lo cual, firmamos el presente documento en la ciudad de Sonsonate,
a los ' . date("d") . ' días del mes de ' . $fecha_formateada . '.
</p>

<table class="signature-table">
<tr>
<td>
_____________________________<br>
<b>' . strtoupper($arrendador['nombre']) . '</b><br>
"EL ARRENDANTE"
</td>
<td>
_____________________________<br>
<b>' . strtoupper($data['cliente_nombre']) . '</b><br>
"EL ARRENDATARIO"
</td>
</tr>
</table>

<footer>
<p> (+503) 7867-8421 &nbsp; | &nbsp; Facebook: /Sonsonate Renta Fácil / Sonsonate-Renta-Facil.com</p>
</footer>

</body>
</html>
';

// 🔧 Configurar Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('letter', 'portrait');
$dompdf->render();
$dompdf->stream("contrato_arrendamiento.pdf", ["Attachment" => false]);
exit;
?>
