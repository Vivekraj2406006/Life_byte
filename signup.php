<?php
require 'vendor/autoload.php';

use MongoDB\Client;

try {
    $client = new Client("mongodb://localhost:27017");
    $collection = $client->mydb->users;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        if (empty($username) || empty($email) || empty($password)) {
            die("All fields are required.");
        }

        $existingUser = $collection->findOne(['email' => $email]);
        if ($existingUser) {
            die("Email already registered. Use another email to <a href='loginindex.html'>register</a>.");
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        
        $result = $collection->insertOne([
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);

        if ($result->getInsertedCount() > 0) {
            echo "Signup successful! <a href='loginindex.html'>Login here</a>";
        } else {
            echo "Signup failed! This could be a bug at our end. Please <a href='loginindex.html'>Try again</a>";
        }
    }
    else{
        echo "Invalid path. Please <a href='loginindex.html'>login here</a> .";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>