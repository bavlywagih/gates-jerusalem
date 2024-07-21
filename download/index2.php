<?php
require_once '../connect.php';
require_once '../tcpdf/tcpdf.php';

// Fetch data from database
$sql = "SELECT id, name, text FROM gates";
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Create new PDF document
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Exported Data');
$pdf->SetSubject('Data export');
$pdf->SetKeywords('TCPDF, PDF, export, arabic');

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set font
$pdf->SetFont('dejavusans', '', 12);

// Add a page
$pdf->AddPage();

// Create HTML content
$html = '<h1 style="text-align:right;">تصدير البيانات</h1>';
$html .= '<table border="1" cellpadding="4" cellspacing="0" style="text-align:right;">';
$html .= '<thead><tr><th>النص</th><th>الاسم</th><th>معرف</th></tr></thead>';
$html .= '<tbody>';
foreach ($results as $row) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($row['text']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['name']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['id']) . '</td>';
    $html .= '</tr>';
}
$html .= '</tbody></table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('data_export.pdf', 'D');
