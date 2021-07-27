<?php
    require_once('pdo.php');

    function insert_account($admin,$username,$password,$fullname,$email,$tel){
        $sql = "INSERT INTO account(admin,username,password,fullname,email,tel) VALUES(?,?,?,?,?,?)";
        pdo_execute($sql,$admin,$username,$password,$fullname,$email,$tel);
    }

    function update_account($username,$password,$email,$tel){
        $sql = "UPDATE account SET password=?,email=?,tel=? WHERE username=?";
        pdo_execute($sql,$password,$email,$tel,$username);
    }

    function update_account_for_admin($username, $password, $fullname, $email, $tel)
    {
        $sql = "UPDATE account SET password=?,fullname=?,email=?,tel=? WHERE username=?";
        pdo_execute($sql, $password, $fullname, $email, $tel, $username);
    }

    function delete_account($username){
        $sql = "DELETE FROM account WHERE username=?";
        pdo_execute($sql,$username);
    }

    function select_all_account(){
        $sql = "SELECT * FROM account";
        return pdo_query($sql);
    }

    function select_account_by_username($username){
        $sql = "SELECT * FROM account WHERE username=?";
        return pdo_query_one($sql,$username);
    }
?>