<?php

namespace AppBundle\Service;

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelGenerator
{
    public function getDoc($object){
        $arrayData = [
            ['ID', 'First Name', 'Last Name', 'Email']
        ];

        foreach ($object as $value){
            $objArray = (array)$value;
            array_push($arrayData,$objArray);
        }

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(48);

        try {
            $spreadsheet->getActiveSheet()
                ->fromArray(
                    $arrayData,
                    NULL,
                    'A1'
                );
        } catch (Exception $e) {
            die($e);
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save('employees.xlsx');
        } catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
            die($e);
        }
    }
}