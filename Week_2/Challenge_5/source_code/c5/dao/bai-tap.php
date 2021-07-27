<?php
    require_once('pdo.php');

    // Bài tập
    function insert_bai_tap($ten_bt,$do_kho,$thoi_gian,$mo_ta,$tep_dinh_kem){
        $sql = "INSERT INTO bai_tap(ten_bt,do_kho,thoi_gian,mo_ta,tep_dinh_kem) VALUES(?,?,?,?,?)";
        pdo_execute($sql,$ten_bt, $do_kho, $thoi_gian, $mo_ta, $tep_dinh_kem);
    }

    function select_all_bai_tap(){
        $sql = "SELECT * FROM bai_tap ORDER BY id_bt DESC";
        return pdo_query($sql);
    }

    function select_bai_tap_by_id($id_bt){
        $sql = "SELECT * FROM bai_tap WHERE id_bt=?";
        return pdo_query_one($sql,$id_bt);
    }

    // Bài nộp
    function insert_nop_bai($id_bt,$username,$thoi_gian_nop,$bai_nop){
        $sql = "INSERT INTO nop_bai(id_bt,username,thoi_gian_nop,bai_nop) VALUES(?,?,?,?)";
        pdo_execute($sql, $id_bt, $username, $thoi_gian_nop, $bai_nop);
    }

    function select_bai_nop_by_username($username){
        $sql = "SELECT bai_tap.ten_bt, bai_tap.do_kho, nop_bai.thoi_gian_nop, nop_bai.bai_nop FROM bai_tap JOIN nop_bai ON bai_tap.id_bt = nop_bai.id_bt WHERE nop_bai.username=?";
        return pdo_query($sql, $username);
    }

    function select_bai_nop_by_id($id_bt){
        $sql = "SELECT bai_tap.ten_bt, bai_tap.do_kho,nop_bai.username, nop_bai.thoi_gian_nop, nop_bai.bai_nop FROM bai_tap JOIN nop_bai ON bai_tap.id_bt = nop_bai.id_bt WHERE nop_bai.id_bt=?";
        return pdo_query($sql, $id_bt);
    }
?>