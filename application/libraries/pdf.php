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
        $this->Ln(30);
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
        $this->SetFillColor(255, 149, 20);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        // Cabecera
        $this->Cell(3);
        $w = array(40, 100, 25, 25);
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(255, 215, 179);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos
       $fill = false;
       
        foreach ($data as $row) {
            $this->Cell(3);
            $this->Cell($w[0], 6, utf8_decode($row['nombre']), 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, utf8_decode($row['descripcion']), 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, number_format($row['unidades']), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, $row['precio'] .' '. iconv('UTF-8', 'windows-1252', '€'), 'LR', 0, 'R', $fill);
            $this->Ln();
            if ($this->GetY()>264){
                $this->AddPage();
            }
            $fill = !$fill;
        }
        $this->Cell(3);
        // Línea de cierre
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->Ln(10);
    }
    
    function total($euros){
        $this->SetFont('Arial', 'B', 15);
        // Movernos a la derecha
        $this->Cell(142);
        // Título
        $this->Cell(45, 15, 'TOTAL: '.$euros .' '. iconv('UTF-8', 'windows-1252', '€'), 1, 0, 'C');
        // Salto de línea
        $this->Ln(20);
    }

}
