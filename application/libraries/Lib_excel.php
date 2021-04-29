<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// End load library phpspreadsheet

class Lib_excel{

	protected $CI;

	public function __construct()
	{
		$this->CI =& get_instance();

		$this->CI->load->helper('date');
	}

	// Export ke excel
	public function export($data_table, $list_data, $nama_file) {
		// Create new Spreadsheet object
		$spreadsheet = new Spreadsheet();

		// Set document properties
		$spreadsheet->getProperties()->setCreator(config_item('app_name'))
		->setLastModifiedBy(config_item('app_name'))
		->setTitle('Office 2007 XLSX Test Document')
		->setSubject('Office 2007 XLSX Test Document')
		->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
		->setKeywords('office 2007 openxml php')
		->setCategory('File Mahkamah Agung');


		$letter = 'B';
		$sheet = $spreadsheet->getActiveSheet();
		foreach ($list_data as $list_idx => $list) {
			$x = 2;
			$sheet->setCellValue($letter.$x , $list['label']);
			$spreadsheet->getActiveSheet()->getStyle($letter.$x)
				->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$spreadsheet->getActiveSheet()->getStyle($letter.$x)
				->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$spreadsheet->getActiveSheet()->getStyle($letter.$x)
				->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$spreadsheet->getActiveSheet()->getStyle($letter.$x)
				->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$spreadsheet->getActiveSheet()->getStyle($letter.$x)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle($letter.$x)
				->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
			$spreadsheet->getActiveSheet()->getStyle($letter.$x)
				->getFill()->getStartColor()->setARGB('FFFFFF');


			// echo $list['field'];

			// Miscellaneous glyphs, UTF-8
			foreach ($data_table as $data_idx => $data_list) {
				if (is_array($data_list)) {
					$i=3;
					foreach ($data_list as $result_idx => $result) {
						$sheet->setCellValue($letter . $i, strip_tags($result->{$list['field']}));
						$spreadsheet->getActiveSheet()->getStyle($letter . $i)
							->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

						$spreadsheet->getActiveSheet()->getStyle($letter . $i)
										->getAlignment()->setWrapText(true);
						$i++;
					}
				}
			}
			$spreadsheet->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
			$styleArray = [
				'borders' => [
					'outline' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
					],
				],
			];

			$line = $i-1;

			$spreadsheet->getActiveSheet()->getStyle('B2:'.$letter.$line)->applyFromArray($styleArray);
			$x++;
			$letter++;
		}

		// Rename worksheet
		$spreadsheet->getActiveSheet()->setTitle('Sheet 1');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$spreadsheet->setActiveSheetIndex(0);

		// Redirect output to a client’s web browser (Xls)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $nama_file . '_' . date('YmdHis') . '.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0

		$writer = IOFactory::createWriter($spreadsheet, 'Xls');
		$writer->save('php://output');
		exit;
	}
}

/* End of file Lib_excel.php */
/* Location: ./application/libraries/Lib_excel.php */
