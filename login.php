<?php
session_start();
require 'vendor/autoload.php';

use MongoDB\Client;

try {
    $client = new Client("mongodb://localhost:27017");
    $collection = $client->mydb->users;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        
        if (empty($email) || empty($password)) {
            die("Email and password are required.");
        }


        $user = $collection->findOne(['email' => $email]);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = (string) $user['_id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.html");
            exit;
        } else {
            echo "Invalid email or password. <a href='loginindex.html'>Try again</a>";
        }
    }
    else{
        echo "Invalid path. Please <a href='loginindex.html'>login here</a> .";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>