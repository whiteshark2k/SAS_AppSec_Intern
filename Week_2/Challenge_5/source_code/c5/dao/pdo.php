<?php

   function pdo_get_connection(){
        $pdo = new PDO("mysql:host=localhost;dbname=c5",'root','');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } 

    // Hàm thêm dữ liệu
    function pdo_execute($sql){
        $sql_args = array_slice(func_get_args(),1);
        try{
            $conn = pdo_get_connection();
            $stmt = $conn -> prepare($sql);
            $stmt -> execute($sql_args);
        }catch(PDOException $e){
            throw $e;
        }finally{
            unset($conn);
        }
    }
    
    // Hàm truy xuất trả về mảng dữ liệu
    function pdo_query($sql){
        $sql_args = array_slice(func_get_args(),1);
        try{
            $conn = pdo_get_connection();
            $stmt = $conn ->prepare($sql);
            $stmt -> execute($sql_args);
            $rows = $stmt -> fetchAll();
            return $rows;
        }catch(PDOException $e){
            throw $e;
        }finally{
            unset($conn);
        }
    }

    // Hàm truy xuất trả về 1 hàng dữ liệu
    function pdo_query_one($sql){ 
        $sql_args = array_slice(func_get_args(),1);
        try{
            $conn = pdo_get_connection();
            $stmt = $conn ->prepare($sql);
            $stmt -> execute($sql_args);
            $row = $stmt -> fetch();
            return $row;
        }catch(PDOException $e){
            throw $e;
        }finally{
            unset($conn);
        }
    }

    // Hàm truy xuất trả về 1 giá trị trong mảng - tl_quiz
    function pdo_query_value($sql)
    {
        $sql_args = array_slice(func_get_args(), 1);
        try {
            $conn = pdo_get_connection();
            $stmt = $conn->prepare($sql);
            $stmt->execute($sql_args);
            $row = $stmt->fetch();
            return $row[0];
        } catch (PDOException $e) {
            throw $e;
        } finally {
            unset($conn);
        }
    }


    function save_file($fieldname, $target_dir){
        $file_uploaded = $_FILES[$fieldname];
        $username = $_SESSION['user']['username'];
        $file_name = "$username." . basename($file_uploaded["name"]);
        $target_path = $target_dir . $file_name;
        move_uploaded_file($file_uploaded["tmp_name"], $target_path);
        return $file_name;
    }

    function save_quiz_file($fieldname, $target_dir)
    {
        $file_uploaded = $_FILES[$fieldname];
        $file_name = basename($file_uploaded["name"]);
        $target_path = $target_dir . $file_name;
        move_uploaded_file($file_uploaded["tmp_name"], $target_path);
        return $file_name;
    }
?>