
                <h2 class="card-title opacity-75"><?php echo $row['text']; ?></h2>
            </div>
        </div>


        <?php
        require_once '../connect.php';
        require_once 'pdf_downloader/tcpdf.php';

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

        $html = '<h1 style="text-align:right;">تصدير البيانات</h1>';
        $html .= '<div class="patriarch-details-container  p-3 shadow-lg  rounded border" style="width: 75%; margin: 120px auto; min-height: 415px;"><div class="content">';
        $html .= '<h3 class="text-black"><b>' . htmlspecialchars($row['name']) . '</b></h3>';
        $html .= '<h3 class="text-black"><b>' . htmlspecialchars($row['name']) . '</b></h3>';
        
        $html .= '</div>';
        $html .= '<h2 style="text-align:right;">http://localhost/gates-jerusalem/gates-jerusalem.php</h2>';


        // Output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // Close and output PDF document
        $pdf->Output('data_export.pdf', 'D');
