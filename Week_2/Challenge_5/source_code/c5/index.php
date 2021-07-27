<!DOCTYPE html>
<html lang="en">

<head>

    <title>Đăng nhập</title>
    <meta charset="UTF-8">

    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto:300);

        .login-page {
            width: 360px;
            padding: 8% 0 0;
            margin: auto;
        }

        .form {
            position: relative;
            z-index: 1;
            background: #FFFFFF;
            max-width: 360px;
            margin: 0 auto 100px;
            padding: 45px;
            text-align: center;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }

        .form input {
            font-family: "Roboto", sans-serif;
            outline: 0;
            background: #f2f2f2;
            width: 100%;
            border: 0;
            margin: 0 0 15px;
            padding: 15px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .form button {
            font-family: "Roboto", sans-serif;
            text-transform: uppercase;
            outline: 0;
            background: #4e73df;
            width: 100%;
            border: 0;
            padding: 15px;
            color: #FFFFFF;
            font-size: 14px;
            -webkit-transition: all 0.3 ease;
            transition: all 0.3 ease;
            cursor: pointer;
        }

        .form button:hover,
        .form button:active,
        .form button:focus {
            background: #224abe;
        }

        body {
            background: #4e73df;
            font-family: "Roboto", sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>

</head>

<body>

    <div class="login-page">
        <div class="form">
            <form class="login-form" method="post">
                <input type="text" name="username" placeholder="Tên đăng nhập" />
                <input type="password" name="password" placeholder="Mật khẩu" />
                <button type="submit" name="btn_submit">
                    ĐĂNG NHẬP
                </button>
            </form>
        </div>
    </div>

    <!-- XỬ LÝ ĐĂNG NHẬP -->

    <?php
    $lifetime = 60 * 60 * 24 * 365;
    session_set_cookie_params($lifetime, '/');
    session_start();
    require_once('dao/account.php');

    extract($_REQUEST);
    if (array_key_exists('btn_submit', $_REQUEST)) {
        if ($username == "" || $password == "") {
            echo '<script language="javascript">';
            echo 'alert("Tên đăng nhập hoặc mật khẩu không được để trống")';
            echo '</script>';
        } else {
            $username = strip_tags($username);
            $username = addslashes($username);
            $password = strip_tags($password);
            $password = addslashes($password);
            
            $user = select_account_by_username($username);
            if ($user && $user['password'] == $password) {
                if ($user['admin'] == 1) {
                    $_SESSION['user'] = $user;
                    header("location: giao-vien/index.php");
                }
                if ($user['admin'] == 0) {
                    $_SESSION['user'] = $user;
                    header("location: sinh-vien/index.php");
                }
            } else {
                echo '<script language="javascript">';
                echo 'alert("Sai tên đăng nhập hoặc mật khẩu")';
                echo '</script>';
            }
        }
    }
    ?>

    <!-- KẾT THÚC XỬ LÝ ĐĂNG NHẬP -->

</body>

</html>