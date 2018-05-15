<?php

namespace AppBundle\Service;

use AppBundle\MYPDF;

class PdfService extends MYPDF
{
    public function generateTable($pdf, $object){
        $pdf->SetTitle(('Darbuotojų Lentelė'));
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('freeserif', '', 11, '', true);
        $pdf->AddPage();

        $arrayData = array();
        foreach ($object as $value){
            $objArray = (array)$value;
            array_push($arrayData,$objArray);
        }

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $header = array('ID', 'First Name', 'Last Name', 'Email');
        $filename = 'darbuotojai';
        $pdf->coloredTable($header,$arrayData);

        $pdf->Output($filename.".pdf",'I'); // This will output the PDF as a response directly
    }
}