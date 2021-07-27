<?php
    session_start();
    if ($_SESSION['user']['admin'] != 0 || !isset($_SESSION['user'])) {
        header("location: ../../403.php");
    }
    else{
        require_once('../../dao/tin-nhan.php');
        extract($_REQUEST);
        delete_tin_nhan($id_tn);
        header('location: thu-da-gui.php');
    }
?>