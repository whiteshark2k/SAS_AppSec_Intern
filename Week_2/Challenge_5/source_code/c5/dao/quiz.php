<?php
    require_once('pdo.php');

    // Quiz
    function insert_quiz($ten_quiz,$goi_y,$tep_dinh_kem){
        $sql = "INSERT INTO quiz(ten_quiz,goi_y,tep_dinh_kem) VALUES(?,?,?)";
        pdo_execute($sql,$ten_quiz,$goi_y,$tep_dinh_kem);
    }

    function select_all_quiz(){
        $sql = "SELECT * FROM quiz";
        return pdo_query($sql);
    }

    function select_quiz_by_id($id_quiz){
        $sql = "SELECT * FROM quiz WHERE id_quiz=?";
        return pdo_query_one($sql, $id_quiz);
    }

    // tl_quiz
    function insert_tl_quiz($id_quiz,$username,$trang_thai){
        $sql = "INSERT INTO tl_quiz(id_quiz,username,trang_thai) VALUES(?,?,?)";
        pdo_execute($sql,$id_quiz,$username,$trang_thai);
    }

    function select_tl_quiz($id_quiz,$username){
        $sql = "SELECT trang_thai FROM tl_quiz WHERE id_quiz=? AND username=?";
        return pdo_query_value($sql,$id_quiz,$username);
    }

    function select_username_tl_quiz($id_quiz){
        $sql = "SELECT account.username FROM account JOIN tl_quiz ON account.username = tl_quiz.username WHERE id_quiz=?";
        return pdo_query($sql,$id_quiz);
    }
?>