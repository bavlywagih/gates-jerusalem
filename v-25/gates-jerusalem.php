<?php
session_start();
if (isset($_SESSION['username'])) {
    require_once "./includes/layout/header.php"; // إدراج الهيدر
    require_once 'connect.php'; // الاتصال بقاعدة البيانات

    // استعلام لاسترداد جميع البيانات من جدول "gates"
    $query = "SELECT * FROM gates ORDER BY id desc";
    $stmt = $pdo->query($query);
    $row_count = $stmt->rowCount();
?>

<div class="container my-3 no-print">
    <div id="message"></div> <!-- سيتم عرض الرسائل هنا -->
    
    <?php if ($row_count < 12 && $_SESSION['group-id'] >= 1) { ?>
        <div class="card rounded-3 card-w-90 w-m" style="width: 60%; margin: auto;">
            <div class="card-body m-auto">
                <h5 class="card-title text-center cairo f-w-b">إنشاء باب من أبواب أورشليم</h5>
                <form id="gateForm">
                    <div class="form-group">
                        <label for="name" class="form-label cairo-semibold">اسم الباب:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="اكتب اسم الباب هنا">
                    </div>
                    <div class="my-2">
                        <label for="post-editor" class="form-label cairo-semibold">الشرح:</label>
                        <textarea class="form-control" name="text" id="post-editor" rows="5"></textarea>
                    </div>
                    <div class="my-2">
                        <label for="id_select" class="form-label cairo-semibold">اختيار ال ID:</label>
                        <select class="form-select" name="id_select" id="id_select">
                            <option value="">اختر ID</option>
                            <?php
                            $id_sql = "SELECT id FROM gates";
                            $stmt_id = $pdo->query($id_sql);
                            $existing_ids = $stmt_id->fetchAll(PDO::FETCH_COLUMN);
                            for ($i = 1; $i <= 12; $i++) {
                                if (!in_array($i, $existing_ids)) {
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">إرسال</button>
                </form>
            </div>
        </div>
    <?php } ?>
</div>

<div class="map-container m-auto my-2" id="gatesList">
    <?php
    if ($row_count != 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="gate"><a href="details.php?gates-jerusalem-Id=' . $row['id'] . '" class="cairo-semibold f-w-b">' . $row['name'] . '</a></div>';
        }
    }
    ?>
    <div class="gate-pdf"><a class="no-print" onclick="printPage()">حفظ PDF</a></div>
</div>

<script>
// إرسال البيانات باستخدام Fetch API
document.getElementById('gateForm').addEventListener('submit', function(event) {
    event.preventDefault(); // منع الإرسال العادي

    const formData = new FormData(this); // جمع بيانات النموذج
    fetch('process_form.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const messageDiv = document.getElementById('message');
        messageDiv.innerHTML = ''; // تفريغ الرسائل السابقة
        if (data.success) {
            messageDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
            // تحديث قائمة الأبواب
            updateGatesList();
        } else {
            data.errors.forEach(error => {
                messageDiv.innerHTML += `<div class="alert alert-danger">${error}</div>`;
            });
        }
    })
    .catch(error => console.error('Error:', error));
});

// دالة لتحديث قائمة الأبواب
function updateGatesList() {
    fetch('fetch_gates.php')
    .then(response => response.text())
    .then(html => {
        document.getElementById('gatesList').innerHTML = html;
        // إعادة التحقق من عدد الأبواب وإزالة النموذج إذا لزم الأمر
        checkGateCount();
    })
    .catch(error => console.error('Error:', error));
}

// دالة للتحقق من عدد الأبواب وإزالة النموذج إذا كان العدد 12
function checkGateCount() {
    fetch('fetch_gate_count.php')
    .then(response => response.json())
    .then(data => {
        if (data.count >= 12) {
            document.getElementById('gateForm').style.display = 'none';
        }
    })
    .catch(error => console.error('Error:', error));
}

function printPage() {
    window.print();
}
</script>

<?php
    require_once './includes/layout/footer.php'; // إدراج الفوتر
} else {
    header('location: login.php');
    exit();
}
?>
