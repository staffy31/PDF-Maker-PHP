<?php
ini_set('memory_limit', '500M');
ini_set('max_execution_time', 0);
error_reporting(1 | 0);

// Include the main TCPDF library (search for installation path).
require_once('config/tcpdf_config.php');
require_once('tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nkubito Moustafa');
$pdf->SetTitle('freelansoft');
$pdf->SetSubject('List of Name');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
  require_once(dirname(__FILE__) . '/lang/eng.php');
  $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 16);

// add a page
$pdf->AddPage();

$pdf->SetFont('helvetica', '', 12);
// -----------------------------------------------------------------------------

function LoadList()
{
  $clinfo = json_decode(file_get_contents('data/clients.json'));
  $output = '';
  $c = 0;

  foreach ($clinfo as $cli) {
    $c++;
    if ($c == 20) {
      $output .= '
        <tbody>
          <tr>
            <td>'.$cli->client_id.'</td>
            <td>'.$cli->insurance.'</td>
            <td>'.$cli->chef.'</td>
            <td>'.$cli->sex.'</td>
            <td>'.$cli->categorie.'</td>
            <td>'.$cli->beneficiary.'</td>
            <td>'.$cli->insurance_code.'</td>
            <td>'.$cli->age.'</td>
            <td>'.$cli->date.'</td>
            <td>'.$cli->period.'</td>
          </tr>
        </tbody>
      ';
      $c=1;      
    } else {
      $output .= '
      <tbody>
        <tr>
          <td>'.$cli->client_id.'</td>
          <td>'.$cli->insurance.'</td>
          <td>'.$cli->chef.'</td>
          <td>'.$cli->sex.'</td>
          <td>'.$cli->categorie.'</td>
          <td>'.$cli->beneficiary.'</td>
          <td>'.$cli->insurance_code.'</td>
          <td>'.$cli->age.'</td>
          <td>'.$cli->date.'</td>
          <td>'.$cli->period.'</td>
        </tr>
      </tbody>
    ';
    }
  }
  return $output;

}

$content = '';
$content .= '
<table border="1" cellpadding="10">
  <thead>
    <tr>
      <th>Client ID</th>
      <th>Insurance</th>
      <th>Chef</th>
      <th>Sex</th>
      <th>Category</th>
      <th>Beneficiary</th>
      <th>Insurance Code</th>
      <th>Age</th>
      <th>Date</th>
      <th>Period</th>
    </tr>
  </thead>
';
$content .= LoadList();
$content .= '</table>';

$pdf->writeHTML($content);

//Close and output PDF document
$pdf->Output('List.pdf', 'I');
