<table class="table table-bordered table-hover"
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Admin</th>
            <th>Subscriber</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $query = "select * from users";
            $showUsers = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($showUsers)){
                $userId = $row['userId'];
                $username = $row['username'];
                $userPassword = $row['userPassword'];
                $userFirstName = $row['userFirstName'];
                $userLastName = $row['userLastName'];
                $userEmail = $row['userEmail'];
                $userImage = $row['userImage'];
                $userRole = $row['userRole'];

                echo "<tr>
                <td>$userId</td>
                <td>$username</td>
                <td>$userFirstName</td>
                <td>$userLastName</td>
                <td>$userEmail</td>
                <td>$userRole</td>";
                echo "<td><a href='users.php?giveAdmin=$userId'>Change to admin</a></td>
                <td><a href='users.php?giveSub=$userId'>Change to subscriber</a></td>
                <td><a href='users.php?source=editUser&editId=$userId'>Edit</a></td>
                <td><a href='users.php?delete=$userId'>Delete</a></td>
                </tr>";
            }
        ?>
        <?php
            if(isset($_GET['giveAdmin'])){
                $admin = $_GET['giveAdmin'];
                $giveAdmin = "update users set userRole = 'admin' where userId = $admin";
                $result = mysqli_query($connection, $giveAdmin);

                confirmQuery($result);
                header("Location: users.php");
            }
            if(isset($_GET['giveSub'])){
                $sub = $_GET['giveSub'];
                $giveSub = "update users set userRole = 'subscriber' where userId = $sub";
                $result = mysqli_query($connection, $giveSub);

                confirmQuery($result);
                header("Location: users.php");
            }
            if(isset($_GET['delete'])){
                if(isset($_SESSION['role'])){
                    if($_SESSION['role'] == 'admin'){
                        $deleteUser = mysqli_real_escape_string($connection, $_GET['delete']);
                        $query = "delete from users where userId = {$deleteUser}";
                        $result = mysqli_query($connection, $query);
                        
                        confirmQuery($result);
                        header("Location: users.php");
                    }
                }
            }
        ?>
    </tbody>
</table>