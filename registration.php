<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "admin/functions.php"; ?>
<?php session_start(); ?>
    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    <!-- SETTING LANGUAGE -->
    <?php 
        if(isset($_GET['lang']) && !empty($_GET['lang'])){
            $_SESSION['lang'] = $_GET['lang'];
            if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
                echo "<script type='text/javascript'>location.reload();</script>";
            }
        }
        if(isset($_SESSION['lang'])){
            include "includes/languages/" . $_SESSION['lang']. ".php";
        } else{
            include "includes/languages/en.php";
        }
    ?>
    <?php
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $username = trim( $_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $errors = [
                'username' => '',
                'email' => '',
                'password' => ''
            ];
            if(strlen($username) < 4){
                $errors['username'] = 'Username it too short';
            } 
            if(empty($username)){
                $errors['username'] = 'Username cannot be empty';
            } 
            if(usernameExists($username)){
                $errors['username'] = 'Username already exists';
            } 
            if(empty($email)){
                $errors['email'] = 'Email cannot be empty';
            } 
            if(emailExists($email)){
                $errors['email'] = "Email already exists, <a href='index.php'>Please log in</a>";
            } 
            if(empty($password)){
                $errors['password'] = "Password cannot be empty";
            }
            foreach($errors as $key => $value){
                if(empty($value)){
                    unset($errors[$key]);
                }
            }
            if(empty($errors)){
                registerUser($username, $email, $password);
                loginUser($username, $password);
            }
        }
    ?>
<!-- Page Content -->
<div class="container">
    <form method="get" action="" class="navbar-form navbar-right" id="language-form">
        <div class="form-group">
            <select name="lang"  class="form-control" onchange="changeLanguage()">
                <option value="en" <?php echo isset($_SESSION['lang']) && $_SESSION['lang'] == 'en' ?  "selected" : null; ?>>English</option>
                <option value="es" <?php echo isset($_SESSION['lang']) && $_SESSION['lang'] == 'es' ?  "selected" : null; ?>>Spanish</option>
            </select>            
        </div>
    </form>
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1><?php echo _REGISTER ?></h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <!-- <h6 class="text-center"><?php echo $message; ?></h6> -->
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo _USERNAME ?>"
                            autocomplete="on" value="<?php echo isset($username) ? $username : '' ?>">
                            <p><?php echo isset($errors['username']) ? $errors['username'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo _EMAIL ?>" autocomplete="on" value="<?php echo isset($email) ? $email : '' ?>">
                            <p><?php echo isset($errors['email']) ? $errors['email'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="<?php echo _PASSWORD ?>">
                            <p><?php echo isset($errors['password']) ? $errors['password'] : '' ?></p>

                        </div>
                        <input type="submit" name="register" id="btn-login" class="btn btn-primary btn-lg btn-block" value="<?php echo _REGISTER ?>">
                    </form>
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>
<hr>
<script>
    function changeLanguage(){
        document.getElementById('language-form').submit();
    }
</script>
<?php include "includes/footer.php";?>
