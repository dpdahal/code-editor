<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['file']) && isset($_POST['code'])) {
    $code = $_POST['code'];
    $filename = $_POST['file'];

    if (file_put_contents($filename, $code) !== false) {
        echo "File saved successfully.";
    } else {
        echo "Error saving file.";
    }
}
