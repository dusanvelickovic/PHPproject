<?php
    if(isset($_GET['editId'])){
        $theUserId = $_GET['editId'];
        
        $query = "select * from users where userId = $theUserId";
        $result = mysqli_query($connection, $query);
        
        while($row = mysqli_fetch_assoc($result)){
            $userId = $row['userId'];
            $firstName = $row['userFirstName'];
            $lastName = $row['userLastName'];
            $username = $row['username'];
            $password = $row['userPassword'];
            $email = $row['userEmail'];
            $role = $row['userRole'];
            $userImage = $row['userImage'];
        }
    
        if(isset($_POST['updateUser'])){
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $password = $_POST['password'];
            
            if(!empty($password)){
                $query = "select userPassword from users where userId = $theUserId";
                $get_user = mysqli_query($connection, $query);
                confirmQuery($get_user);
                
                $row = mysqli_fetch_assoc($get_user);
                $dbUserPwd = $row['userPassword'];
                
                if($dbUserPwd != $password){
                    $hashedpwd = password_hash($password, PASSWORD_BCRYPT, array('cost'=> 10));
                }
                    
                $query = "update users set 
                userFirstName = '$firstName',
                userLastName = '$lastName',
                username = '$username',
                userEmail = '$email',
                userRole = '$role',
                userPassword = '$hashedpwd'
                where userId = '$theUserId'";
                
                $update = mysqli_query($connection, $query);
                confirmQuery($update);
                header("Location: users.php");
            }
        }
    } else{
        header("Location: index.php");
    }
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="firstName">First Name</label>
        <input type="text" class="form-control" name="firstName" placeholder="Enter first name"
        value="<?php echo $firstName ?>">
    </div>
    <div class="form-group">
        <label for="lastName">Last Name</label>
        <input type="text" class="form-control" name="lastName" placeholder="Enter last name"
        value="<?php echo $lastName ?>">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Enter email"
        value="<?php echo $email ?>">
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" class="form-control" placeholder="Enter username"
        value="<?php echo $username ?>">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter password" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="role">User Role</label>
        <select name="role" id="">
                <option value="<?php echo $role ?>"><?php echo $role ?></option>
                <?php
                    if($role == 'admin'){
                        echo "<option value='subscriber'>subscriber</option>";
                    } else{
                        echo "<option value='admin'>admin</option>";
                    }
                ?>
        </select>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="updateUser" value="Update User">
    </div>
</form>