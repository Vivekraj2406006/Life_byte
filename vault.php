<?php
session_start();
require 'vendor/autoload.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: loginindex.html");
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $db = $client->mydb; // Replace 'mydb' with your database name
    $collection = $db->users;

    // Fetch the user document using _id
    $user = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($user_id)]);
    $files = isset($user['files']) ? $user['files'] : [];
} catch (Exception $e) {
    $error = "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="vaultstyle.css">
    <link rel="stylesheet" href="style.css">

</head>
<body>

<div class="side-bar" id="side-bar">
        <ul>
            <li><a><i class="fa-solid fa-circle-user"></i>  Hello<i class="fa-solid fa-chevron-right r-arrow "></i></a></li><hr>
            <li><a><i class="fa-solid fa-house"></i>  Home <i class="fa-solid fa-chevron-right r-arrow "></i></a></li><hr>
            <li><a href="vault.php"><i class="fa-solid fa-vault"></i>  Health Records <i class="fa-solid fa-chevron-right r-arrow "></i></a></li><hr>
            <li><a href="Loginindex.html"><i class="fa-solid fa-right-from-bracket"></i>  Log in/Log out <i class="fa-solid fa-chevron-right r-arrow "></i></a></li><hr>
            <li><a><i class="fa-solid fa-truck-medical"></i>  Emergency <i class="fa-solid fa-chevron-right r-arrow "></i></a></li><hr>
            <li><a><i class="fa-solid fa-headset"></i>  Customer Support <i class="fa-solid fa-chevron-right r-arrow "></i></a></li><hr>
            <li id="last-li"><a>  Terms & Condition</a></li>
            <!-- <li></li>
            <li></li>
            <li></li> -->
        </ul>
    </div>

    <header>

        <div class="header-container" >
            <div class="user-logo" id="user-logo" onclick="showNav()">
                <i title="Account" class="fa-solid fa-user" style="cursor: pointer;"></i>
            </label>
            </div>
            <div class="company-logo">
                <img src="logo.png" alt="Chalo Logo Home" >
            </div>
        </div>
    </header>

    <main onclick="hideNav()">
    <h2>Welcome to your Vault, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <!-- <a href="logout.php">Logout</a> -->

    <h3>Upload File</h3>
    <form method="POST" action="upload.php" enctype="multipart/form-data">
        <input type="file" name="userfile" accept="image/*,application/pdf" required>
        <button type="submit">Upload</button>
    </form>

    <h3>Your Files</h3>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <ul>
        <?php foreach ($files as $file): ?>
            <li>
                <a href="<?php echo htmlspecialchars($file['filepath']); ?>" download>
                    <?php echo htmlspecialchars($file['filename']); ?>
                </a>
                (Uploaded: <?php echo $file['upload_date']->toDateTime()->format('Y-m-d H:i:s'); ?>)
            </li>
        <?php endforeach; ?>
    </ul>
    </main>

    <footer>
        <div class="foot-panal2">
            <div class="foot-panal2-c1">
                <p><b>Get to Know Us</b></p>
                <a>Facebook</a>
                <a>Instagram</a>
                <a>Twitter</a>
                <a href="logout.html">Log Out</a>
            </div>

            <div class="foot-panal2-c2">
                <p><b>Make Money with Us</b></p>
                <a>Protect and Build Your Brand</a>
                <a>Help</a>
                <a href="feedback.html" style="text-decoration: none;">Feedback</a>
                <a>Careers</a>
                <a>Press Releases</a>
            </div>
            
        </div>
       <hr>
        <div class="foot-panel4">
            <div class="pages">
                <a>Terms & Conditions</a>
                <a>Privacy Notice</a>
                <a>Intrest-Based Ads</a>
            </div>
            <div class="copyright">
                ©2025, <i>Life<sup>+</sup>.com</i>, Inc. or its affiliates
            </div>
        </div>
    </footer>
</body>
</html>