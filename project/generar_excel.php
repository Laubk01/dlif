<?php
// Incluir la librería PhpSpreadsheet
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Crear una instancia de la clase Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Conectar a la base de datos MySQL
$servername = 'localhost';
$username = 'dlif';
$password = '123';
$dbname = 'dlif';

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// Obtener los datos de la tabla
$query = $conn->query('SELECT * FROM ordenes');
$data = $query->fetchAll(PDO::FETCH_ASSOC);

// Escribir los datos en las celdas del archivo de Excel
$row = 1;
foreach ($data as $row_data) {
    $col = 1;
    foreach ($row_data as $value) {
        $sheet->setCellValueByColumnAndRow($col, $row, $value);
        $col++;
    }
    $row++;
}

// Guardar el archivo de Excel
$writer = new Xlsx($spreadsheet);
$writer->save('documentos/ordenes_reporte.xlsx');

// Cerrar la conexión a la base de datos
$conn = null;


?>