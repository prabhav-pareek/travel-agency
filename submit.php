<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $fullName      = filter_input(INPUT_POST, 'fullName', FILTER_SANITIZE_STRING);
    $numPeople     = filter_input(INPUT_POST, 'numPeople', FILTER_VALIDATE_INT) ?: '';
    $contactNumber = filter_input(INPUT_POST, 'contactNumber', FILTER_SANITIZE_STRING);
    $purpose       = filter_input(INPUT_POST, 'purpose', FILTER_SANITIZE_STRING);
    $email         = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL) ?: '';
    $timestamp     = date('Y-m-d H:i:s');

    // CSV file path
    $file = __DIR__ . '/submissions.csv';
    $isNew = !file_exists($file);
    $fp = fopen($file, 'a');
    if ($isNew) {
        fputcsv($fp, ['Full Name','Number of People','Contact Number','Purpose','Email','Submitted At']);
    }
    fputcsv($fp, [$fullName, $numPeople, $contactNumber, $purpose, $email, $timestamp]);
    fclose($fp);
    header('Location: thank_you.html');
    exit;
}
?>