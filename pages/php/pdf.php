<?php
// generar_pdf.php
include('../../conexion/conexion.php');
require('../../conexion/pdf/fpdf.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_paciente"])) {
    $id_paciente = $_POST["id_paciente"];

    $sql = "SELECT * FROM paciente WHERE id = $id_paciente";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $paciente = $result->fetch_assoc();


        class PDF extends FPDF
        {
            // Cabecera de página
            function Header()
            {
                $this->SetFont('Arial', 'B', 18);
                $this->SetTextColor(0, 0, 255);
                $this->Cell(0, 10, "Hospital PixelPionners", 0, 1);
                $this->Ln(5);

                $this->SetTextColor(0);
                $this->SetFont('Arial', 'B', 14);
                $this->Cell(0, 10, 'Expediente de Paciente', 0, 1, 'C');
                $this->Ln(30);
            }

            // Pie de página
            function Footer()
            {
                $this->SetY(-15);
                $this->SetFont('Arial', 'I', 8);
                $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
            }

            // Contenido del expediente
            function PatientRecord($data)
            {

                $this->Image('../../img/fondo_incial.jpg', 10, 40, 40);
                $this->SetY(40);

                // Datos personales del paciente
                $this->SetFont('Arial', '', 12);
                $this->SetX(55);
                $this->Cell(60, 10, 'Paciente: ' . $data['id'], 0, 1);
                $this->SetX(55);
                $this->Cell(40, 10, 'Nombre: ' . mb_convert_encoding($data['nombre'], 'UTF-8'), 0, 0);
                $this->Cell(40, 10, 'Apellido: ' . mb_convert_encoding($data['apellido'], 'UTF-8'), 0, 1);

                $this->SetX(55);
                $this->Cell(35, 10, 'DNI: ' . $data['dni'], 0, 0);
                $this->Cell(50, 10, 'Telefono: ' . $data['telefono'], 0, 0);
                $this->Cell(50, 10, 'Obra Social: ' . mb_convert_encoding($data['obraSocial'], 'UTF-8'), 0, 1);
                $this->Ln(8);

                // Línea divisoria
                $this->SetX(10);
                $this->Cell(0, 0, '', 'T');
                $this->Ln(10);

                // Historia clínica
                $this->SetFont('Arial', 'B', 14);
                $this->Cell(0, 10, 'Historia Clinica', 0, 1, 'C');
                $this->SetFont('Arial', '', 12);
                $this->MultiCell(0, 10, mb_convert_encoding($data['historiaClinica'], 'UTF-8'));
            }
        }

        // Crear una instancia de la clase PDF
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->PatientRecord($paciente);
        $nombreArchivo = $paciente['nombre'] . '_' . $paciente['apellido'] . '_Historial_Clinico.pdf';
        $pdf->Output($nombreArchivo, 'D'); // Descargar el PDF con el nombre del paciente
    } else {
        echo "Error al generar el PDF: No se encontraron datos del paciente.";
    }
}
