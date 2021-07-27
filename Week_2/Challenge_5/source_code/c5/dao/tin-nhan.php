<?php
    require_once('pdo.php');

    function insert_tin_nhan($nguoi_gui,$nguoi_nhan,$thoi_gian,$noi_dung){
        $sql = "INSERT INTO tin_nhan(nguoi_gui,nguoi_nhan,thoi_gian,noi_dung) VALUES(?,?,?,?)";
        pdo_execute($sql,$nguoi_gui,$nguoi_nhan,$thoi_gian,$noi_dung);
    }

    function update_tin_nhan($id_tn,$noi_dung){
        $sql = "UPDATE tin_nhan SET noi_dung=? WHERE id_tn=?";
        pdo_execute($sql,$noi_dung,$id_tn);
    }

    function delete_tin_nhan($id_tn){
        $sql = "DELETE FROM tin_nhan WHERE id_tn=?";
        pdo_execute($sql,$id_tn);
    }

    function select_tin_nhan_da_gui($nguoi_gui){
        $sql = "SELECT * FROM tin_nhan WHERE nguoi_gui=?";
        return pdo_query($sql, $nguoi_gui);
    }

    function select_tin_nhan_by_id($id_tn){
        $sql = "SELECT * FROM tin_nhan WHERE id_tn=?";
        return pdo_query_one($sql,$id_tn);
    }

    function select_tin_nhan_da_nhan($nguoi_nhan)
    {
        $sql = "SELECT * FROM tin_nhan WHERE nguoi_nhan=?";
        return pdo_query($sql, $nguoi_nhan);
    }
?>