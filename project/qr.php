<?php
// Requiere la biblioteca TCPDF
require_once('tcpdf/tcpdf.php');

// Crea una instancia de TCPDF
$pdf = new TCPDF();

// Agrega una página
$pdf->AddPage();

// Define el contenido del menú
$menu = "
Menú:
- Entrada
- Plato principal
- Postre
";

// Agrega el contenido del menú al PDF
$pdf->writeHTML($menu, true, false, false, false, '');

// Salva el PDF
$pdf->Output('archivo.pdf', 'D');
?>
