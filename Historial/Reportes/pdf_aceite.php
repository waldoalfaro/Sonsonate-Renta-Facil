<?php
require '../../vendor/autoload.php';
use Dompdf\Dompdf;
include '../../conexion.php';

// Crear el HTML base
$html = '
<h2 style="text-align:center;">Historial de Cambios de Aceite</h2>
<img src= "../../../logo2.png" alt="logo"/>
<table border="1" cellspacing="0" cellpadding="5" width="100%">
    <thead>
        <tr style="background-color:#f2f2f2; text-align:center;">
            <th>Modelo</th>
            <th>Placa</th>
            <th>Kilometraje actual</th>
            <th>Próximo cambio</th>
            <th>Aceite</th>
            <th>Realizado por</th>
            <th>Teléfono</th>
            <th>Costo</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>';

// Consulta a la base de datos
$sql = "SELECT 
            v.modelo,
            v.placa,
            h.kilometraje_actual,
            h.proximo_cambio_km,
            h.tipo_aceite,
            h.realizado_por_aceite,
            h.telefono_aceite,
            h.costo_aceite,
            h.obs_aceite
        FROM historial_cambios_aceite h
        INNER JOIN vehiculos v ON h.id_vehiculo = v.id_vehiculo
        ORDER BY h.fecha_registro DESC";

$result = $conn->query($sql);

// Verificamos si hay registros
if ($result && $result->num_rows > 0) {
    while ($fila = $result->fetch_assoc()) {
        $html .= '
        <tr>
            <td style="text-align:center;">' . htmlspecialchars($fila['modelo']) . '</td>
            <td style="text-align:center;">' . htmlspecialchars($fila['placa']) . '</td>
            <td style="text-align:center;">' . htmlspecialchars($fila['kilometraje_actual']) . ' km</td>
            <td style="text-align:center;">' . htmlspecialchars($fila['proximo_cambio_km']) . ' km</td>
            <td style="text-align:center;">' . htmlspecialchars($fila['tipo_aceite']) . '</td>
            <td style="text-align:center;">' . htmlspecialchars($fila['realizado_por_aceite']) . '</td>
            <td style="text-align:center;">' . htmlspecialchars($fila['telefono_aceite']) . '</td>
            <td style="text-align:center;">$' . number_format($fila['costo_aceite'], 2) . '</td>
            <td>' . htmlspecialchars($fila['obs_aceite']) . '</td>
        </tr>';
    }
} else {
    $html .= '<tr><td colspan="9" style="text-align:center;">No hay registros de cambios de aceite.</td></tr>';
}

$html .= '</tbody></table>';

// Cerrar conexión
$conn->close();

// Crear instancia de Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape'); // Horizontal
$dompdf->render();

// Enviar al navegador
$dompdf->stream("reporte_cambios_aceite.pdf", ["Attachment" => false]); // false = se abre en navegador
exit;
?>
