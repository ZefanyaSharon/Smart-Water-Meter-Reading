<?php
require_once(APPPATH.'libraries/fpdf/fpdf.php');
// require_once(APPPATH.'libraries/fpdi/fpdi.php');
require_once(APPPATH.'libraries/fpdi/autoload.php');

use \setasign\Fpdi\Fpdi;

class Maskpdf extends FPDI {
	//Page header
	function Header() {
		$this->SetFont('Arial', 'B', 50);
		$this->SetTextColor(195,255,195);
		$this->RotatedText(-20, 50, 'Mahkamah Agung Republik Indonesia', 45);
		$this->RotatedText(-15, 150, 'Mahkamah Agung Republik Indonesia', 45);
		$this->RotatedText(-10, 250, 'Mahkamah Agung Republik Indonesia', 45);
		$this->RotatedText(-5, 350, 'Mahkamah Agung Republik Indonesia', 45);
		$this->RotatedText(0, 450, 'Mahkamah Agung Republik Indonesia', 45);

		//Logo
		$this->Image('./public/logo-ma.jpg',20,6,18);

		$this->SetTextColor(60,60,60);

		$this->Cell(30);
		$this->SetFont('Arial','B',15);
		$this->Cell(0,5,'Direktori Putusan Mahkamah Agung Republik Indonesia',0,0,'L');
		$this->Ln(2);

		$this->Cell(30);
		$this->SetFont('Arial','B',10);
		$this->Cell(0,13,'putusan.mahkamahagung.go.id',0,0,'L');
		$this->Ln(5);
	}

	function RotatedText($x, $y, $txt, $angle) {
		//Text rotated around its origin
		$this->Rotate($angle, $x, $y);
		$this->Text($x, $y, $txt);
		$this->Rotate(0);
	}

	//Page footer
	function Footer() {
		//Position at 1.5 cm from bottom
		$this->SetY(-15);
		$this->SetFont('Arial','I',5);

		$this->Cell(0,0,"Disclaimer", 0, 0, 'L');
		$this->Ln(1);
		$this->Cell(0,3,"Kepaniteraan Mahkamah Agung Republik Indonesia berusaha untuk selalu mencantumkan informasi paling kini dan akurat sebagai bentuk komitmen Mahkamah Agung untuk pelayanan publik, transparansi dan akuntabilitas", 0, 0,'L');
		$this->Ln(1);
		$this->Cell(0,6,"pelaksanaan fungsi peradilan. Namun dalam hal-hal tertentu masih dimungkinkan terjadi permasalahan teknis terkait dengan akurasi dan keterkinian informasi yang kami sajikan, hal mana akan terus kami perbaiki dari waktu kewaktu.", 0, 0,'L');
		$this->Ln(1);
		$this->Cell(0,9,"Dalam hal Anda menemukan inakurasi informasi yang termuat pada situs ini atau informasi yang seharusnya ada, namun belum tersedia, maka harap segera hubungi Kepaniteraan Mahkamah Agung RI melalui :", 0, 0, 'L');
		$this->Ln(1);
		$this->Cell(0,12,"Email : kepaniteraan@mahkamahagung.go.id    Telp : 021-384 3348 (ext.318)", 0, 0, 'L');

		/*$this->Cell(0,0,"Dokumen ini diunduh dari situs http://putusan.mahkamahagung.go.id, sesuai dengan Pasal 33 SK Ketua Mahkamah Agung RI nomor 144 SK/KMA/VII/2007 mengenai Keterbukaan Informasi Pengadilan (SK 144)", 0, 0, 'L');
		$this->Ln(1);
		$this->Cell(0,3," bukan merupakan salinan otentik dari putusan pengadilan, oleh karenanya tidak dapat sebagai alat bukti atau dasar untuk melakukan suatu upaya hukum.", 0, 0,'L');
		$this->Ln(1);
		$this->Cell(0,6,"Sesuai dengan Pasal 24 SK 144, salinan otentik silakan hubungi pengadilan tingkat pertama yang memutus perkara.", 0, 0, 'L');*/

		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//Page number
		$this->Cell(0,10,'Halaman '.$this->PageNo(),0,0,'R');
	}
}

	/* Instanciation of inherited class
	function doConvert($sFile, $sFileName){
		$pdf= new Maskpdf();

		$pagecount = $pdf->setSourceFile('./docs/uploads/c90aea20c9f552e737a56cff9d31241c.dat');
		for($i=1;$i<=$pagecount;$i++){
			//Using template /MediaBox, available template see manual/sample of FPDI
			//$tplidx = $pdf->importPage($i, '/MediaBox');
			$tplidx = $pdf->importPage($i);

			$pdf->addPage();

			//$pdf->useTemplate($tplidx, X POSITION, Y POSITION, ZOOM LEVEL);
			//$pdf->useTemplate($tplidx, 10, 10, 90);
			$pdf->useTemplate($tplidx, 10, 0, 180);
		}
		$pdf->Output();

		//$pdf->Output('newpdf.pdf', 'D');
	}*/
?>