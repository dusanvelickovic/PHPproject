<?php include "includes/adminHeader.php"; ?>
<?php 
    if(!isAdmin($_SESSION['user'])){
        header("Location: index.php");
    } 
?>
    <div id="wrapper">
        <!-- Navigation -->
        <?php include "includes/adminNavigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small>Author</small>
                        </h1>
                        <?php
                            if(isset($_GET['source'])){
                                $source = $_GET['source'];
                            } else{
                                $source = '';
                            }
                            switch($source){
                                case 'addUser': include 'includes/addUser.php'; break;
                                case 'editUser': include 'includes/editUser.php'; break;
                                case '34': echo 'Nice'; break;
                                case '34': echo 'Nice'; break;
                                default: include 'includes/viewAllUsers.php'; break;
                            }

                        ?>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php include "includes/adminFooter.php"; ?>