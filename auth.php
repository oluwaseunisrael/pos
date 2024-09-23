<?php 

if (!isset($_SESSION['loginInUser']) || $_SESSION['loginInUser'] == False) {
    $_SESSION['status'] = "You must login first";
    // Optionally, redirect the user to the login page
    header("Location:../login.php");
    exit();
}

?>