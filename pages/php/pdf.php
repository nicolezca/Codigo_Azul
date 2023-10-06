<?php
// generar_pdf.php
include('../../conexion/conexion.php');
require('../../conexion/pdf/fpdf.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_paciente"])) {
    $id_paciente = $_POST["id_paciente"];
    
    // Recupera los datos del paciente desde la base de datos
    $sql = "SELECT * FROM paciente WHERE id = $id_paciente"; // Asegúrate de que la tabla se llama "paciente"
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $paciente = $result->fetch_assoc();


        class PDF extends FPDF {
            // Cabecera de página
            function Header() {
                $this->SetFont('Arial', 'B', 12);
                $this->SetTextColor(255, 0, 0);
                $this->Cell(0, 10, "Hospital PixelPionners",0,1);
                $this->SetTextColor(0); 
                $this->Cell(0, 10, 'Expediente de Paciente', 0, 1, 'C');
                $this->Ln(10);
            }

            // Pie de página
            function Footer() {
                $this->SetY(-15);
                $this->SetFont('Arial', 'I', 8);
                $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
            }

            // Contenido del expediente
            function PatientRecord($data) {
                $this->Cell(0, 10, 'Informacion del Paciente', 0, 1);
                $this->Ln(5);

                // Datos personales del paciente
                $this->Cell(50, 10,'Nombre: ' . mb_convert_encoding($data['nombre'], 'UTF-8'), 0, 0);
                $this->Cell(50, 10,'Apellido: ' . mb_convert_encoding($data['apellido'], 'UTF-8'), 0, 1);
                $this->Cell(50, 10, 'DNI: ' . $data['dni'], 0, 0);
                $this->Cell(50, 10,  'Telefono: ' . $data['telefono'], 0, 1);
                $this->Cell(30, 10, 'Obra Social: ' . mb_convert_encoding($data['obraSocial'], 'UTF-8'), 0, 1);
                $this->Ln(10);

                // Historia clínica
                $this->Cell(0, 10,'Historia Clinica', 0, 1, 'C');
                $this->SetFont('Arial', 'I',12);
                $this->MultiCell(0, 10, mb_convert_encoding($data['historiaClinica'], 'UTF-8'));
                $this->Ln(5);
            }
        }

        // Crear una instancia de la clase PDF
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->PatientRecord($paciente);

        $pdf->Output(  'Paciente_Historial_Clinico.pdf', 'D'); // Descargar el PDF
        
    } 
    
    else {
        echo "Error al generar el PDF: No se encontraron datos del paciente.";
    }
}
?>
