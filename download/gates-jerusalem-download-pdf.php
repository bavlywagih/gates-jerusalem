
                <h2 class="card-title opacity-75"><?php echo $row['text']; ?></h2>
            </div>
        </div>


        <?php
        require_once '../connect.php';
        require_once 'pdf_downloader/tcpdf.php';

        $sql = "SELECT id, name, text FROM gates";
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pdf = new TCPDF();

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Exported Data');
        $pdf->SetSubject('Data export');
        $pdf->SetKeywords('TCPDF, PDF, export, arabic');

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetFont('dejavusans', '', 12);

        $pdf->AddPage();

        $html = '<h1 style="text-align:right;">تصدير البيانات</h1>';
        $html .= '<div class="patriarch-details-container  p-3 shadow-lg  rounded border" style="width: 75%; margin: 120px auto; min-height: 415px;"><div class="content">';
        $html .= '<h3 class="text-black"><b>' . htmlspecialchars($row['name']) . '</b></h3>';
        $html .= '<h3 class="text-black"><b>' . htmlspecialchars($row['name']) . '</b></h3>';
        
        $html .= '</div>';
        $html .= '<h2 style="text-align:right;">http://localhost/gates-jerusalem/gates-jerusalem.php</h2>';

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('data_export.pdf', 'D');
