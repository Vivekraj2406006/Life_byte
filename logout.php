<?php
session_start();
session_unset();
session_destroy();
header("Location: loginindex.html");
exit;
?>