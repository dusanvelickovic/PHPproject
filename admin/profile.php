<?php include "includes/adminHeader.php"; ?>
    <?php
        if(isset($_SESSION['user'])){
            $username = $_SESSION['user'];

            $query1 = "select * from users where username = '$username'";
            $userProfile = mysqli_query($connection, $query1);

            while($row = mysqli_fetch_assoc($userProfile)){
                $userId = $row['userId'];
                $firstName = $row['userFirstName'];
                $lastName = $row['userLastName'];
                $username = $row['username'];
                $password = $row['userPassword'];
                $email = $row['userEmail'];
                $role = $row['userRole'];
                $userImage = $row['userImage'];
            }
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
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" name="firstName" placeholder="Enter first name"
                                value="<?php echo $firstName; ?>">
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" name="lastName" placeholder="Enter last name"
                                value="<?php echo $lastName; ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter email"
                                value="<?php echo $email; ?>">
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Enter username"
                                value="<?php echo $username; ?>">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter password"
                                autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="updateProfile" value="Update Profile">
                            </div>
                            <?php
                                if(isset($_POST['updateProfile'])){
                                    $firstName = $_POST['firstName'];
                                    $lastName = $_POST['lastName'];
                                    $username = $_POST['username'];
                                    $email = $_POST['email'];
                                    $password = $_POST['password'];
                                    
                                    $query = "update users set 
                                    userFirstName = '$firstName',
                                    userLastName = '$lastName',
                                    username = '$username',
                                    userEmail = '$email',
                                    userRole = '$role',
                                    userPassword = '$password'
                                    where userId = '$userId'";

                                    $update = mysqli_query($connection, $query);
                                    confirmQuery($update);

                                    $_SESSION['user'] = $username;
                                    header("Location: users.php");
                                }
                            ?>
                        </form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
<?php include "includes/adminFooter.php"; ?>