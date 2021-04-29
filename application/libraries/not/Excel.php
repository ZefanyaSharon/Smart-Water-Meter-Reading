<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Excel Reader Library
 * Version:  1.0
 * Author: Chenri Jano
 * Date: 2012 12 15
 *
 * Feature:
 * 1. Read excel file and return array variable
 * - read_file($filename);
 *   row 1 as header
 *   row 2 to ... as data
 * - read_file($filename,$data_array,$key_header_begin);
 *   $data_array=array('Column Name 1'=>'$field_name_1, 'Column Name 2'=>'$field_name_2);
 *   $key_header_begin='Column Name 2';  //Data will be processed starting from Column Name 2, Column Name 1 won't be processed
 */
class Excel{
	public function __Construct()
	{

	}

	function read_file($filename, $data_mapping=array(), $key_header_begin=''){
		//require_once 'Excel/excel_reader.php';
        require_once 'Excel/PHPExcel.php';
        /**  Identify the type of $inputFileName  **/
        $input_file_type = PHPExcel_IOFactory::identify($filename);
        /**  Create a new Reader of the type defined in $input_file_type  **/
        $obj_reader = PHPExcel_IOFactory::createReader($input_file_type);
        /**  Advise the Reader that we only want to load cell data  **/
        $obj_reader->setReadDataOnly(true);
        /**  Load $inputFileName to a PHPExcel Object  **/
        $obj_php_excel = $obj_reader->load($filename);

        $obj_worksheet = $obj_php_excel->getActiveSheet();
        $value=array();
        $x=1;
        $row_count=1;
		
        foreach ($obj_worksheet->getRowIterator() as $row) {
            $y=1;
            $cell_iterator = $row->getCellIterator();
            $cell_iterator->setIterateOnlyExistingCells(false);
            if(!isset($value['header'])){
                foreach ($cell_iterator as $cell) {
                    $cell_value=$cell->getValue();
                    $header=trim($cell_value);
                    if(count($data_mapping) || $key_header_begin<>''){
                        if($header==$key_header_begin || isset($value['header']) || ($key_header_begin=='' && count($data_mapping))){
                            if(!empty($data_mapping[$header])){
                                $field=$data_mapping[$header];
                                $value['header'][$field]=$y;
                                $index[$y]=$field;
                            }
                        }
                    }else{
                        $value['header'][$header]=$y;
                        $index[$y]=$header;
                    }
                    $y++;
                }
            }else{
                foreach ($cell_iterator as $cell) {
                    $cell_value=$cell->getValue();
                    if(!empty($index[$y])){
                        $field=$index[$y];
                        $value['data'][$row_count][$field]=$cell_value;
                    }
                    $y++;
                }
                $row_count++;
            }
            $x++;
        }
        return $value;
    }

    function write_file($filename, $data_mapping=array(), $data){
        require_once 'Excel/PHPExcel.php';

        // Create new PHPExcel object
        $obj_php_excel = new PHPExcel();

        // Set properties
        $obj_php_excel->getProperties()->setCreator("Name")
                                     ->setLastModifiedBy("Name")
                                     ->setTitle("Title")
                                     ->setSubject("Subject")
                                     ->setDescription("Description")
                                     ->setKeywords("Keywords")
                                     ->setCategory("Category");

        $obj_php_excel->setActiveSheetIndex(0);

        // Rename sheet
        $obj_php_excel->getActiveSheet()->setTitle('Sheet 1');

		// Data mapping inverse
        if(!empty($data) && count($data)){
            $col = 0;
            $row = 0;
			$data_mapping=array_flip($data_mapping);
			if(count($data_mapping)){
				foreach($data_mapping as $key=>$name){
					$obj_php_excel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $data_mapping[$key]);
					$col++;
				}
			}else{
				foreach($data[0] as $key=>$value){
					$obj_php_excel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $key);
					$col++;
				}
			}            

            $row=2;
            foreach($data as $record){
                $col = 0;
				if(count($data_mapping)){
					foreach($data_mapping as $key=>$name){
						if(isset($record->$key)){
							$obj_php_excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $record->$key);
							$obj_php_excel->getActiveSheet()->getStyle('D1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);												
						}
						$col++;					
					}
				}else{
					foreach($record as $key=>$value) {
						$obj_php_excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
						$obj_php_excel->getActiveSheet()->getStyle('D1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
						$col++;
					}
				}                
                $row++;
            }
        }

        $obj_php_excel->setActiveSheetIndex(0);

        $obj_writer = PHPExcel_IOFactory::createWriter($obj_php_excel, 'Excel5');

        //Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'_'.date('dMy').'.xls"');
        header('Cache-Control: max-age=0');

        $obj_writer->save('php://output');

    }
}