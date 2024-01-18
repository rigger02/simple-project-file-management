<?php
if (isset($_GET['filename'])) {
    $filename = $_GET['filename'];
    $filepath = "./gambar/$filename";
    if (file_exists($filepath)) {
        unlink($filepath);
    }
}
?>