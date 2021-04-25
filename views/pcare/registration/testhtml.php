<?php

//use app\models\Adjustment;

require __DIR__ . '/../../../reno/tcpdf/tcpdf.php';

require __DIR__ . '/../../../reno/tcpdf/tcpdf_barcodes_1d.php';

define('K_PATH_IMAGES_2', '/../../../reno/');
//K_PATH_IMAGES
//============================================================+
// File name   : example_048.php
// Begin       : 2009-03-20
// Last Update : 2013-05-14
//
// Description : Example 048 for TCPDF class
//               HTML tables and table headers
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: HTML tables and table headers
 * @author Nicola Asuni
 * @since 2009-03-20
 */
// Dummy Variable Data Diri


ob_end_clean();


//require_once('tcpdf_include.php');


class MYPDF extends TCPDF {
    public $wilayah;
    public $kantorcabang;
    public $kabupaten_kota;
    public $clinic_name;

    public function setClinicinfo($clinic_name, $kabupaten_kota, $wilayah, $kantorcabang)
    {
        $this->wilayah = $wilayah;
        $this->kantorcabang = $kantorcabang;
        $this->clinic_name = $clinic_name;
        $this->kabupaten_kota = $kabupaten_kota;
    }
    //Page header
    public function Header() {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = 'https://walkingdocs.gamantha.com/logo_bpjs.png';
//         $img_file = dirname(__FILE__).'\logo-bpjs.png';
//         echo $img_file;
        $this->Image($img_file, 4, 4, 0, 15, '', '', '', false, 300, '', false, false, 0);
//        $pdf->Rect($x, $y, $w, $h, 'F', array(), array(128,255,128));

        $x = 15;
        $y = 35;
        $w = 30;
        $h = 30;
//        $wilayah = 'wilayah';

        $fitbox = 'L';
//        $this->Image($img_file, $x, $y, $w, $h, 'JPG', '', '', false, 300, '', false, false, 0, $fitbox, false, false);
        // restore auto-page-break status

        $html = <<<EOD
<h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
EOD;

        $subtable_header = '<table border="0" cellspacing="0" cellpadding="4">
<tr><td colspan="6">Kedeputian Wilayah</td><td colspan="10">: '.$this->wilayah.'</td></tr>
<tr><td colspan="6">Kantor Cabang</td><td colspan="10">: '.$this->kantorcabang.'</td></tr>
</table>';


// set color for background


// Print text using writeHTMLCell()
        $this->writeHTMLCell(100, 100, 120, '', $subtable_header, 0, 1, 0, true, '', true);
//        $this->SetFillColor(215, 235, 255);

//        $this->Cell(0, 15, '<< RENO HEADER >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }
}


// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


$pdf->setClinicinfo($clinicinfo->clinic_name, $clinicinfo->kabupaten_kota, $clinicinfo->wilayah, $clinicinfo->kantorcabang);



// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));



$style = array(
    'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => true,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 8,
    'stretchtext' => 4
);


// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));


// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);


// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 7, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

//// Set some content to print
//$html = <<<EOD
//<h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
//<i>This is the first example of TCPDF library.</i>
//<p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
//<p>Please check the source code documentation and other examples for further information.</p>
//<p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
//EOD;
//
//
//// Print text using writeHTMLCell()
//$pdf->writeHTMLCell(0, 0, '', '', $html, 1, 1, 0, true, '', true);

$diagnose1 = '';
$diagnose2 = '';
$diagnose3 = '';


if (null != $visitModel->kdDiag1) {
    $diagnose1 = $visitModel->nmDiag1 . '('.$visitModel->kdDiag1 . ')';
}

if (null != $visitModel->kdDiag2) {
    $diagnose2 = ', ' . $visitModel->nmDiag2 . '('.$visitModel->kdDiag2 . ')';
}

if (null != $visitModel->kdDiag3) {
    $diagnose3 = ', '. $visitModel->nmDiag3 . '('.$visitModel->kdDiag3 . ')';
}


$namafktp = isset($clinicinfo->clinic_name) ? $clinicinfo->clinic_name : "";
$kabupatan_kota = isset($clinicinfo->kabupaten_kota) ? $clinicinfo->kabupaten_kota : "";
$namafktprujukan = isset(json_decode($visitModel->meta_rujukan)->name) ? json_decode($visitModel->meta_rujukan)->name : "";
$nmkc = isset(json_decode($visitModel->meta_rujukan)->nmkc) ? json_decode($visitModel->meta_rujukan)->nmkc : "";
$di = "";
$pesertanama = isset($peserta->nama) ? $peserta->nama : "";
$pesertakartu = isset($peserta->noKartu) ? $peserta->noKartu : "";
$nokunjungan = isset($visitModel->noKunjungan) ? $visitModel->noKunjungan : "";
$pesertasex = isset($peserta->sex) ? $peserta->sex : "";

$date=date_create($visitModel->tglEstRujuk);
$tanggalrujuk = date_format($date,"d-M-Y");
$date->add(new DateInterval('P3M')); // P1D means a period of 1 day
$masa_berlaku = date_format($date,"d-M-Y");


$tglrujuk = isset($visitModel->tglEstRujuk) ? $tanggalrujuk : "";
$jadwal = isset(json_decode($visitModel->meta_rujukan)->jadwal)? json_decode($visitModel->meta_rujukan)->jadwal : "";
$namadokter = isset($dokter->nmDokter) ? $dokter->nmDokter : "";


// set document information
$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle($nokunjungan);
$pdf->SetSubject($nokunjungan);
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');


$kepada_yth = isset($visitModel->subSpesialis_nmSubSpesialis1) ? $visitModel->subSpesialis_nmSubSpesialis1 : "";
$subtable = '<div border="1"><table border="0" cellspacing="0" cellpadding="4"><tr><td colspan="1">No Rujukan</td><td colspan="2">: '.$nokunjungan.'</td></tr>
<tr><td colspan="1">FKTP</td><td colspan="2">: '.$namafktp.'</td></tr>
<tr><td colspan="1">Kabupaten/Kota</td><td colspan="2">: '.$kabupatan_kota.'</td></tr></table></div>';
$subtable2 = '<table border="0" cellspacing="2" cellpadding="4">
<tr><td colspan="1">Kepada Yth. TS Dokter</td><td colspan="2">: '.$kepada_yth.'</td></tr>
<tr><td colspan="1">Di</td><td colspan="2">: '.$namafktprujukan.'</td></tr>
</table>';
$subtable3 = '<table border="0" cellspacing="0" cellpadding="4">
<tr><td colspan="1">Nama</td><td colspan="2">: '.$pesertanama.'</td></tr>
<tr><td colspan="1">No Kartu BPJS</td><td colspan="2">: '.$pesertakartu.'</td></tr>
<tr><td colspan="1">Diagnosa</td><td colspan="2">: '.$diagnose1.
    $diagnose2 . $diagnose3 .

'</td></tr>
<tr><td colspan="1">Telah diberikan</td><td colspan="2">: '.$visitModel->terapi.'</td></tr>
</table>';

$subtable4 = '<table border="0" cellspacing="0" cellpadding="4">
<tr><td colspan="2">Umur</td><td colspan="2">: '.intval(substr(date('Ymd') - date('Ymd', strtotime($peserta->tglLahir)), 0, -4)).'</td><td colspan="1">Tahun</td><td colspan="3">: '.date_format(date_create($peserta->tglLahir),"d-M-Y").'</td></tr>
<tr><td colspan="2">Status</td><td colspan="1">: ?</td><td colspan="3">Utama/tanggungan</td><td colspan="1">'.$pesertasex.'</td><td colspan="1">(L/P)</td></tr>
<tr><td colspan="2">Catatan</td><td>: </td></tr>
</table>';

$subtable5 = '<table border="0" cellspacing="0" cellpadding="4">
<tr><td>Tgl. Rencana Berkunjung</td><td>: '.$tglrujuk.'</td></tr>
<tr><td>Jadwal Praktek</td><td>: '.$jadwal.'</td></tr>
<tr><td>Surat rujukan berlaku 1[satu] kali kunjungan, berlaku sampai dengan</td><td>: '.$masa_berlaku.'</td></tr>
</table>';


$subtable6 = '<table border="0" cellspacing="2" cellpadding="4">
<tr><td rowspan="1">Salam Sejawat,</td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td>'.$namadokter.'</td></tr>
</table>';

$params = $pdf->serializeTCPDFtagParameters(array('CODE 39', 'C39', '', '', 80, 30, 0.4, array('position'=>'S', 'border'=>true, 'padding'=>4, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>4), 'N'));
$htmlbarcode = '<tcpdf method="write1DBarcode" params="'.$params.'" />';
$barcodeobj = new TCPDFBarcode('123456', 'C128');
$barcode = $barcodeobj->getBarcodeHTML(2, 30, 'black');
$html = '

<style>
.grid-container {
  display: grid;
  grid-template-columns: 40px 50px auto 50px 40px;
  grid-template-rows: 25% 100px auto;
}

.grid-item-a {
  grid-column-start: 2;
  grid-column-end: five;
  grid-row-start: row1-start;
  grid-row-end: 3;
}
.grid-item-b {
  grid-column-start: 1;
  grid-column-end: span col4-start;
  grid-row-start: 2;
  grid-row-end: span 2;
}

</style>
<div style="text-align: center;"><h1>SURAT RUJUKAN FKTP</h1></div>
<div border="1">
<table border="0" cellspacing="0" cellpadding="4">
<tr>
<td colspan="3">'.$subtable.'</td>
<td colspan="3">';
$barcodeobj = new TCPDFBarcode('http://www.tcpdf.org', 'C128');
//$pdf->write1DBarcode('CODE 39', 'C128', '10', '100', '', 18, 0.4, $style, 'N');
//$barcode = $pdf->serializeTCPDFtagParameters(array('CODE 39', 'C39', '', '', 80, 30, 0.4, array('position'=>'S', 'border'=>true, 'padding'=>4, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>4), 'N'));

//$barcode_png = $barcodeobj->getBarcodePNG(2, 30, array(0,0,0));
//echo $barcode_png;
//$html .= '<tcpdf method="write1DBarcode" params="'.$barcode.'" />';
$params = $pdf->serializeTCPDFtagParameters(array($nokunjungan, 'C128', '', '', 80, 22, 0.4, array('position'=>'S', 'border'=>true, 'padding'=>4, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>4), 'N'));
$html .= '<tcpdf method="write1DBarcode" params="'.$params.'"></tcpdf>';
$html .='</td>
</tr>
<tr>
<td colspan="3">'.$subtable2.'</td>
<td colspan="3"></td>
</tr>
<tr><td colspan="6">Mohon pemeriksaan dan penanganan lebih lanjut pasien :</td></tr>


<tr>
<td colspan="3">'.$subtable3.'</td>
<td colspan="3">'.$subtable4.'</td>
</tr>
<tr><td colspan="6">Atas bantuannya diucapkan terima kasih</td></tr>



<tr>
<td colspan="3">'.$subtable5.'</td>
<td colspan="1"></td>
<td colspan="2">'.$subtable6.'</td>
</tr>

</table></div>';

// output the HTML content
$pdf->SetFont('times', '', 14);
//$pdf->Cell(0, 0, 'SURAT RUJUKAN FKTP', 0, 1, 'C', 0, '', 0);


//$params = $pdf->serializeTCPDFtagParameters(array('CODE 39', 'C39', '', '', 80, 30, 0.4, array('position'=>'S', 'border'=>true, 'padding'=>4, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>4), 'N'));
//$html .= '<tcpdf method="write1DBarcode" params="'.$params.'" />';


$pdf->SetFont('dejavusans', '', 7, '', true);
$pdf->writeHTML($html, true, false, true, false, '');


// PRINT VARIOUS 1D BARCODES

// CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9.
//$pdf->Cell(0, 0, 'CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9', 0, 1);
//$pdf->write1DBarcode('CODE 39', 'C39', '', '', '', 18, 0.4, $style, 'N');

//$pdf->Ln();

//$pdf->writeHTML($html2, true, false, true, false, '');
// Print some HTML Cells

$html = '<span color="red">red</span> <span color="green">green</span> <span color="blue">blue</span><br /><span color="red">red</span> <span color="green">green</span> <span color="blue">blue</span>';

$pdf->SetFillColor(255,255,0);

$y = $pdf->getY();

//$pdf->writeHTMLCell(50, 0, '', $y, $html, 'LRTB', 0, 0, true, 'L', true);
//$pdf->writeHTMLCell(100, 0, '', '', $html, 'LRTB', 1, 1, true, 'C', true);
//$pdf->writeHTMLCell(80, 0, '', '', $html, 'LRTB', 1, 0, true, 'R', true);



// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+