<?php

class pdf extends FPDF {

    function Header() {
        // Logo
        $this->Image('./assets/images/home/logo.png', 10, 8, 83, 12);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 25);
        // Movernos a la derecha
        $this->Cell(115);
        // Título
        $this->Cell(60, 20, 'FACTURA', 1, 0, 'C');
        // Salto de línea
        $this->Ln(20);
    }

// Pie de página
    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function FancyTable($header, $data) {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        // Cabecera
        $this->Cell(15);
        $w = array(35, 70, 25, 25);
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos
        $fill = false;
        $this->Cell(15);
        $this->Cell($w[0], 6, $data['img'], 'LR', 0, 'L', $fill);
        $this->Cell($w[1], 6, $data['nombre'], 'LR', 0, 'L', $fill);
        $this->Cell($w[2], 6, $data['unidades'], 'LR', 0, 'R', $fill);
        $this->Cell($w[3], 6, $data['precio'], 'LR', 0, 'R', $fill);
        $this->Ln();
        $fill = !$fill;

        // Línea de cierre
        $this->Cell(15);
        $this->Cell(array_sum($w), 0, '', 'T');
    }

}
