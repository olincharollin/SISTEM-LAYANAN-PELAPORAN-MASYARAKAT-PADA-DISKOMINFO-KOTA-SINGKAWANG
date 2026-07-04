<?php
session_start();
include "config.php";

if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];

    mysqli_query($conn,"
        INSERT INTO audit_log (user_id, aktivitas)
        VALUES ('$id','Logout')
    ");
}

session_unset();
session_destroy();

header("Location: login.php");
exit;
?>