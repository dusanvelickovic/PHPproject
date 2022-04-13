<?php
    if(isset($_POST['createUser'])){
        $firstName = escape($_POST['firstName']);
        $lastName = escape($_POST['lastName']);
        $username = escape($_POST['username']);
        $password = escape($_POST['password']);
        $email = escape($_POST['email']);
        $userRole = escape($_POST['role']);

        $userImage = $_FILES['image']['name'];
        $userImageTemp = $_FILES['image']['tmp_name'];
        move_uploaded_file($userImageTemp, "../images/$userImage");

        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 8));
        $query = "INSERT INTO `users`(`username`, `userPassword`, `userFirstName`, `userLastName`, `userEmail`, `userImage`, `userRole`) VALUES ('$username','$password','$firstName','$lastName','$email','$userImage','$userRole')";

        $result = mysqli_query($connection, $query);
        confirmQuery($result);
        echo "User Created: " . " " . "<a href='users.php'>View Users</a>";
    }
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="firstName">First Name</label>
        <input type="text" class="form-control" name="firstName" placeholder="Enter first name">
    </div>
    <div class="form-group">
        <label for="lastName">Last Name</label>
        <input type="text" class="form-control" name="lastName" placeholder="Enter last name">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" class="form-control" placeholder="Enter username">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter password">
    </div>
    <div class="form-group">
        <label for="image">User Image</label>
        <input type="file" name="image">
    </div>
    <!-- <div class="form-group">
        <label for="role">User Role</label>
        <select name="role" id="" class="form-control">
            <?php 
                $query = "select * from users";
                $selectUsers = mysqli_query($connection, $query);
                confirmQuery($selectUsers);

                while($row = mysqli_fetch_assoc($selectUsers)){
                    $userId = $row['userId'];
                    $userRole = $row['userRole'];

                    echo "<option value='$userId'>$userRole</option>";
                }
            ?>
        </select>
    </div> -->
    <div class="form-group">
        <label for="role">User Role</label>
        <select name="role" id="">
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="createUser" value="Create User">
    </div>
</form>