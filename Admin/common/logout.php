<?php
echo "helo";
session_start();
session_unset();

session_destroy();
header("Location: ../LoginView.php");
exit;
?>