<?php
// For file upload, use appropriate POST handling code
if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] === UPLOAD_ERR_OK) {
    $file_tmp_name = $_FILES['receipt']['tmp_name'];
    $file_type = $_FILES['receipt']['type'];

    // Define allowed file types
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (in_array($file_type, $allowed_types)) {
        $receipt_content = file_get_contents($file_tmp_name);
        // Continue with database insertion or other processing
    } else {
        die("Invalid file type.");
    }
} else {
    if ($_FILES['receipt']['error'] != UPLOAD_ERR_NO_FILE) {
        die("File upload error: " . $_FILES['receipt']['error']);
    }
}
?>
