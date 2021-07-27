<?php
    session_start();
    if ($_SESSION['user']['admin'] != 1 || !isset($_SESSION['user'])) {
        header("location: ../../403.php");
    }
    else{
        require_once('../../dao/account.php');
        extract($_REQUEST);
        delete_account($username);
        header('location: ds-sv.php');
    }  
?>
