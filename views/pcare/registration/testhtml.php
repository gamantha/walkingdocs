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

    public function setClinicinfo($rujukanObj)
    {
        $this->wilayah = $rujukanObj->response->ppk->kc->kdKR->nmKR;
        $this->kantorcabang = $rujukanObj->response->ppk->kc->nmKC;
        $this->clinic_name = $rujukanObj->response->ppk->nmPPK;
        $this->kabupaten_kota = $rujukanObj->response->ppk->kc->dati->nmDati;
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


$pdf->setClinicinfo($rujukanObj);



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

$diagnose1 = '';
$diagnose2 = '';
$diagnose3 = '';


if (null != $rujukanObj->response->diag1) {
    $diagnose1 = $rujukanObj->response->diag1->nmDiag . '('.$rujukanObj->response->diag1->kdDiag . ')';
}

if (null != $rujukanObj->response->diag2) {
    $diagnose2 = $rujukanObj->response->diag2->nmDiag . '('.$rujukanObj->response->diag2->kdDiag . ')';
}

if (null != $rujukanObj->response->diag3) {
    $diagnose3 = $rujukanObj->response->diag3->nmDiag . '('.$rujukanObj->response->diag3->kdDiag . ')';
}


$namafktp = isset($rujukanObj->response->ppk->nmPPK) ? $rujukanObj->response->ppk->nmPPK : "";
$kabupatan_kota = isset($rujukanObj->response->ppk->kc->dati->nmDati) ? $rujukanObj->response->ppk->kc->dati->nmDati : "";
$namafktprujukan = isset($visitModel->nmppk_subSpesialis) ? $visitModel->nmppk_subSpesialis : "";
$nmkc = isset($rujukanObj->response->ppk->kc->nmKC) ? $rujukanObj->response->ppk->kc->nmKC : "";
$di = "";
$pesertanama = isset($rujukanObj->response->nmPst) ? $rujukanObj->response->nmPst : "";
$pesertakartu = isset($rujukanObj->response->nokaPst) ? $rujukanObj->response->nokaPst : "";
$nokunjungan = isset($rujukanObj->response->noRujukan) ? $rujukanObj->response->noRujukan : "";
$pesertasex = isset($rujukanObj->response->sex) ? $rujukanObj->response->sex : "";
$pisa = isset($rujukanObj->response->pisa) ? $rujukanObj->response->pisa : "";
$catatan = isset($rujukanObj->response->catatan) ? $rujukanObj->response->catatan : "";
$catatanRujuk = isset($rujukanObj->response->catatanRujuk) ? $rujukanObj->response->catatanRujuk : "";

$date=date_create($rujukanObj->response->tglEstRujuk);
$tanggalrujuk = date_format($date,"d-M-Y");
$date2=date_create($rujukanObj->response->tglAkhirRujuk);
$date3 = date_create($visitModel->pendaftaran->tglDaftar);
$masa_berlaku = date_format($date2,"d-M-Y");


$tglrujuk = isset($rujukanObj->response->tglEstRujuk) ? $tanggalrujuk : "";
$jadwal = isset($rujukanObj->response->jadwal)? $rujukanObj->response->jadwal : "";
$namadokter = isset($rujukanObj->response->dokter->nmDokter) ? $rujukanObj->response->dokter->nmDokter : "";


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
<tr><td colspan="1">Di lokasi</td><td colspan="2">: '.$namafktprujukan.'</td></tr>
</table>';
$subtable3 = '<table border="0" cellspacing="0" cellpadding="4">
<tr><td colspan="1">Nama</td><td colspan="2">: '.$pesertanama.'</td></tr>
<tr><td colspan="1">No Kartu BPJS</td><td colspan="2">: '.$pesertakartu.'</td></tr>
<tr><td colspan="1">Diagnosa</td><td colspan="2">: '.$diagnose1.
    $diagnose2 . $diagnose3 .

'</td></tr>
<tr><td colspan="1">Telah diberikan</td><td colspan="2">: '.$catatan.'</td></tr>
</table>';

$subtable4 = '<table border="0" cellspacing="0" cellpadding="4">
<tr><td colspan="2">Umur</td><td colspan="2">: '.intval(substr(date('Ymd') - date('Ymd', strtotime($rujukanObj->response->tglLahir)), 0, -4)).'</td><td colspan="1">Tahun</td><td colspan="3">: '.date_format(date_create($rujukanObj->response->tglLahir),"d-M-Y").'</td></tr>
<tr><td colspan="2">Status</td><td colspan="1">: '.$pisa.'</td><td colspan="3">Utama/tanggungan</td><td colspan="1">'.$pesertasex.'</td><td colspan="1">(L/P)</td></tr>
<tr><td colspan="2">Catatan</td><td colspan="6">: '.$catatanRujuk.'</td></tr>
</table>';

$subtable5 = '<table border="0" cellspacing="0" cellpadding="4">
<tr><td>Tgl. Rencana Berkunjung</td><td>: '.$tglrujuk.'</td></tr>
<tr><td>Jadwal Praktek</td><td>: '.$jadwal.'</td></tr>
<tr><td>Surat rujukan berlaku 1[satu] kali kunjungan, berlaku sampai dengan</td><td>: '.$masa_berlaku.'</td></tr>
</table>';


$subtable6 = '<table border="0" cellspacing="2" cellpadding="4">
<tr><td rowspan="1" colspan="1">Salam Sejawat, <br/>'.date_format($date3 ,"d-M-Y") .'</td></tr>
<tr><td></td></tr>
<br/>
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

$pdf->SetFont('dejavusans', '', 7, '', true);
$pdf->writeHTML($html, true, false, true, false, '');



$html = '<span color="red">red</span> <span color="green">green</span> <span color="blue">blue</span><br /><span color="red">red</span> <span color="green">green</span> <span color="blue">blue</span>';

$pdf->SetFillColor(255,255,0);

$y = $pdf->getY();

$pdf->Output($nokunjungan . '.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+