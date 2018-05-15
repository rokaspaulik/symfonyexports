<?php

namespace AppBundle;

use TCPDF;

class MYPDF extends TCPDF
{
    // Colored table
    public function ColoredTable($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(15, 35, 50, 95);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;

        foreach ($data as $row){
            $i = 0;
            foreach ($row as $value){
                $this->Cell($w[$i], 6, $value, 'LR', 0, 'L', $fill);
                $i++;
            }
            $this->Ln();
            $fill=!$fill;
        }

        $this->Cell(array_sum($w), 0, '', 'T');
    }
}