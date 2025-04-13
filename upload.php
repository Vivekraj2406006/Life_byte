<?php
session_start();
require 'vendor/autoload.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: loginindex.html");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['userfile'])) {
    $file = $_FILES['userfile'];
    $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];

    // Validate file
    if ($file['error'] === UPLOAD_ERR_OK && in_array($file['type'], $allowed_types)) {
        $filename = $file['name'];
        $upload_dir = 'uploads/';
        $filepath = $upload_dir . $user_id . '_' . time() . '_' . $filename;

        // Create uploads directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Move file to uploads directory
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            try {
                $client = new MongoDB\Client("mongodb://localhost:27017");
                $db = $client->mydb; // Replace 'mydb' with your database name
                $collection = $db->users;

                // Append file metadata to the user's files array
                $collection->updateOne(
                    ['_id' => new MongoDB\BSON\ObjectId($user_id)],
                    ['$push' => [
                        'files' => [
                            'filename' => $filename,
                            'filetype' => $file['type'],
                            'filepath' => $filepath,
                            'upload_date' => new MongoDB\BSON\UTCDateTime()
                        ]
                    ]]
                );

                header("Location: vault.php");
                exit;
            } catch (Exception $e) {
                $error = "Database error: " . $e->getMessage();
            }
        } else {
            $error = "Failed to move uploaded file.";
        }
    } else {
        $error = "Invalid file type or upload error.";
    }
} else {
    $error = "No file uploaded.";
}

// Redirect with error if something went wrong
$_SESSION['error'] = $error;
header("Location: vault.php");
exit;