<?php
session_start();
if ($_SESSION['user']['admin'] != 1 || !isset($_SESSION['user'])) {
    header("location: ../../403.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Thêm quiz</title>

    <!-- Custom fonts for this template-->
    <link href="../../css/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">


    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                </div>
                <div class="sidebar-brand-text mx-3">TRANG DÀNH CHO GIÁO VIÊN</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- Nav Item - Quản lý sinh viên -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <span><strong>QUẢN LÝ SINH VIÊN</strong></span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="../ql-sv/ds-sv.php">Danh sách sinh viên</a>
                        <a class="collapse-item" href="../ql-sv/them-sv.php">Thêm sinh viên</a>
                        <a class="collapse-item" href="../ql-sv/hop-thu-den.php">Hộp thư đến</a>
                        <a class="collapse-item" href="../ql-sv/thu-da-gui.php">Thư đã gửi</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Quản lý bài tập -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <span><strong>QUẢN LÝ BÀI TẬP</strong></span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="../ql-bt/ds-bt.php">Danh sách bài tập</a>
                        <a class="collapse-item" href="../ql-bt/them-bt.php">Thêm bài tập</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Quiz -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                    <span><strong>QUIZ</strong></span>
                </a>
                <div id="collapsePages" class="collapse show" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="ds-quiz.php">Danh sách quiz</a>
                        <a class="collapse-item active" href="them-quiz.php">Thêm quiz</a>
                    </div>
                </div>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> Xin chào,
                                    <?php
                                    echo $_SESSION['user']['fullname'];
                                    ?>
                                </span>
                                <img class="img-profile rounded-circle" src="../../css/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="../../logout.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Đăng xuất
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->


                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800"><strong>Thêm quiz</strong></h1>
                    <p class="mb-4">Điền đầy đủ thông tin để tiến hành thêm quiz mới.</a>.</p>

                    <!-- Xử lý thông tin  -->
                    <?php
                    require_once('../../dao/quiz.php');
                    extract($_REQUEST);

                    if (array_key_exists("btn_insert", $_REQUEST)) {

                        if ($ten_quiz == "" | $goi_y == "" | $_FILES['tep_dinh_kem']['size'] == "") {
                            echo '<script language="javascript">';
                            echo 'alert("Chưa nhập đủ thông tin!")';
                            echo '</script>';
                        } else {
                            $up_file = save_quiz_file("tep_dinh_kem", "attachments/");
                            $file = strlen($up_file) > 0 ? $up_file : 'attachment';

                            insert_quiz($ten_quiz, $goi_y, $file);
                            echo '<script language="javascript">';
                            echo 'alert("Thêm quiz thành công")';
                            echo '</script>';
                            unset($ten_quiz, $goi_y, $file);
                        }
                    }
                    ?>

                    <!-- /. CONTENT  -->
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="">Tên quiz</label>
                            <input type="text" class="form-control" name="ten_quiz" placeholder="Nhập tên quiz ...">
                        </div>

                        <div class="form-group">
                            <label for="">Gợi ý</label>
                            <input type="text" class="form-control" name="goi_y" placeholder="Nhập gợi ý ...">
                        </div>

                        <div class="form-group">
                            <label for="">Tệp đính kèm</label>
                            <input type="file" class="form-control-file" name="tep_dinh_kem">
                        </div>

                        <button type="submit" name="btn_insert" class="btn btn-primary custom">Thêm mới</button>

                        <a class="btn btn-secondary custom" href="ds-quiz.php">Quay lại</a>
                    </form>

                </div>
                <!-- /.container-fluid -->


            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc chắn muốn đăng xuất?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Chọn "Đăng xuất" để kết thúc phiên làm việc.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Quay lại</button>
                        <a class="btn btn-primary" href="../../logout.php">Đăng xuất</a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Bootstrap core JavaScript-->
        <script src="../../css/vendor/jquery/jquery.min.js"></script>
        <script src="../../css/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="../../css/vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../../css/js/sb-admin-2.min.js"></script>


</body>

</html>