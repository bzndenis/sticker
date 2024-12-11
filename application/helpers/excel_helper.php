<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('create_sticker_template')) {
    function create_sticker_template() {
        require_once APPPATH . 'third_party/PHPExcel/PHPExcel.php';
        
        $objPHPExcel = new PHPExcel();
        
        // Set properties
        $objPHPExcel->getProperties()
                    ->setCreator("Admin")
                    ->setTitle("Template Import Sticker")
                    ->setDescription("Template untuk import data sticker");
        
        // Add header
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Nama Sticker')
                    ->setCellValue('B1', 'ID Kategori')
                    ->setCellValue('C1', 'Deskripsi');
        
        // Add style to header
        $styleArray = array(
            'font' => array(
                'bold' => true,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'CCCCCC'),
            )
        );
        
        $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($styleArray);
        
        // Add example data
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A2', 'Contoh Sticker')
                    ->setCellValue('B2', '1')
                    ->setCellValue('C2', 'Deskripsi sticker');
        
        // Set column width
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        
        // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('Data Sticker');
        
        // Save file
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('./assets/templates/sticker_import_template.xlsx');
    }
} 