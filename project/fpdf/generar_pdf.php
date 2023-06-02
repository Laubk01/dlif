<?php
require('fpdf.php');

class PDF extends FPDF
{
 
// ...

    function Header()
    {
        $this->SetFont('Arial', 'B', 16); // Configura la fuente (Arial, negrita, tamaño 16)
        $this->Cell(0, 10, 'REPORTE DE VENTAS', 0, 3, 'C');
        $this->Ln(10);
    }

    // ...


    // Pie de página
    function Footer()
    {
        // Número de página
        $this->SetY(-15);
        $this->Cell(0, 10, 'Página '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }

    // Función para generar el contenido del PDF
    function GenerarPDF()
    {
        // Configuración de la conexión PDO
        $dsn = 'mysql:host=localhost;dbname=dlif';
        $usuario = 'dlif';
        $contraseña = '123';

        // Crear la conexión PDO
        $conexion = new PDO($dsn, $usuario, $contraseña);

        // Consulta para obtener los datos de la tabla
        $consulta = "SELECT * FROM ordenes";
        $resultado = $conexion->query($consulta);

        // Crear el documento PDF
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12); // Configura la fuente para los títulos
        $pdf->Cell(40, 10, 'Id Orden', 1, 0, 'C');
        $pdf->Cell(60, 10, 'Correo', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Fecha', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Total', 1, 1, 'C');

        // Agregar los datos al PDF
        while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $pdf->Cell(40, 10, $fila['id'], 1, 0, 'C');
            $pdf->Cell(60, 10, $fila['correo'], 1, 0, 'C');
            $pdf->Cell(40, 10, $fila['pedido'], 1, 0, 'C');
            $pdf->Cell(40, 10, $fila['total_precio'], 1, 1, 'C');
        }
        // Cerrar la conexión PDO
        $conexion = null;

        // Salida del PDF
        $pdf->Output();
    }
}

// Crear instancia de la clase PDF y generar el PDF
$pdf = new PDF();
$pdf->GenerarPDF();
?>
