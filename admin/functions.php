<?php
    //===== DATABASE HELPERS FUNCTIONS =====//
    function confirmQuery($result){
        global $connection;
        if(!$result){
            die('QUERY FAILED' . mysqli_error($connection));
        }
    }
    // redirect
    function redirect($location){
        header("Location: " . $location);
        exit;
    }
    function ifItIsMethod($method = null){
        if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
            return true;
        }
        return false;
    }
    function isLoggedIn(){
        if(isset($_SESSION['role'])){
            return true;
        }
        return false;
    }
    // execute query function
    function query($query){
        global $connection;
        $result =  mysqli_query($connection, $query);
        confirmQuery($result);
        return $result;
    }
    function fetchRecords($result){
        return mysqli_fetch_assoc($result);
    }
    //===== END DATABASE HELPERS =====//
    //===== GENERAL HELPERS =====//
    function getUsername(){
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }

    // checks if user has admin role
    function isAdmin(){
        if(isLoggedIn()){
            $query = query("select userRole from users where userId = '". $_SESSION['id'] ."'");
            $row = fetchRecords($query);
            if($row['userRole'] == 'admin'){
                return true;
            } else{
                return false;
            }
        }
    } 
    function loggedInUserId(){
        if(isLoggedIn()){
            $result = query("SELECT * FROM users WHERE username = '" . $_SESSION['user'] . "'");
            confirmQuery($result);
            $user = mysqli_fetch_assoc($result);
        return mysqli_num_rows($result) >= 1 ? $user['userId'] : false;
        }
        return false;
    }
    function userLikedPost($postId = ''){
        $result = query("select * from likes where userId = " . loggedInUserId() . " && postId = $postId");
        confirmQuery($result);
        return mysqli_num_rows($result) >= 1 ? true : false;
    }
    function countRecords($query){
        return mysqli_num_rows($query);
    }
    function getPostLikes($postId = ''){
        $result = query("select * from likes where postId = $postId");
        confirmQuery($result);
        return mysqli_num_rows($result);
    }
    function checkIfUserIsLoggedInAndRedirect($redirectLocation = null){
        if(isLoggedIn()){
            redirect($redirectLocation);
        }
    }
    function usersOnline(){
        if(isset($_GET['onlineusers'])){
            global $connection;
            if(!$connection){
                session_start();
                include("../includes/db.php");
                $session = session_id();
                $time = time();
                $timeOutInSeconds = 10;
                $timeOut = $time - $timeOutInSeconds;
                
                $query = "select * from users_online where session = '$session'";
                $sendQuery = mysqli_query($connection, $query);
                $count = mysqli_num_rows($sendQuery);
                
                if($count == null){
                    mysqli_query($connection, "INSERT INTO users_online(session, time) values('$session', '$time')");
                } else{
                    mysqli_query($connection, "update users_online set time = '$time' where session = '$session'");
                }
                $usersOnlineQuery = mysqli_query($connection, "select * from users_online where time > '$timeOut'");
                echo $countUsers = mysqli_num_rows($usersOnlineQuery);
            }
        }
    }
    usersOnline();
    function insertCategories(){
        global $connection;
        if(isset($_POST['submit'])){
            $categoryTitle =  $_POST['categoryTitle'];
            $categoryTitle = mysqli_real_escape_string($connection, $categoryTitle);

            if($categoryTitle == '' || empty($categoryTitle)){
                echo 'This field should not be empty.';
            } else{
                $stmt = mysqli_prepare($connection,"INSERT INTO `categories`(`categoryTitle`) VALUES (?)");
                mysqli_stmt_bind_param($stmt, "s", $categoryTitle);

                mysqli_stmt_execute($stmt);

                if(!$stmt){
                    die('QUERY FAILED') . mysqli_error($connection);
                }
            }
            mysqli_stmt_close($stmt);
        }
    }
    function findAllCategories(){
        global $connection;
        $query = "select * from categories";
        $categoriesQuery = mysqli_query($connection, $query);      

        while($row = mysqli_fetch_assoc($categoriesQuery)){
            $categoryId = $row['categoryId'];
            $categoryTitle = $row['categoryTitle'];

            echo "<tr>";
            echo "<td>{$categoryId}</td>";
            echo "<td>{$categoryTitle}</td>";
            echo "<td><a href='categories.php?delete={$categoryId}'>Delete</a></td>";
            echo "<td><a href='categories.php?edit={$categoryId}'>Edit</a></td>";
            echo "</tr>";
        }
    }
    function deleteCategory(){
        global $connection;
        if(isset($_GET['delete'])){
        $getCategoryId = $_GET['delete'];

        $query = "DELETE FROM categories where categoryId = {$getCategoryId}";
        $deleteQuery = mysqli_query($connection, $query);
        header("Location: categories.php");
        }
    }
    // escape string
    function escape($string){
        global $connection;
        return mysqli_real_escape_string($connection, trim($string));
    }
    // select * from <tableName>
    function recordCount($tableName){
        global $connection;
        $query = "select * from $tableName";
        $selectPosts = mysqli_query($connection, $query);
        confirmQuery($selectPosts);
        return mysqli_num_rows($selectPosts);
    }
    function getAllUserPost(){
        $result = query("SELECT COUNT(*) AS numOfPosts
        FROM posts
        WHERE userId = " . loggedInUserId() ."");
        while ($row = mysqli_fetch_assoc($result)) {
            return $row['numOfPosts'];
        }
    }
    function getAllPostUserComments(){
        $result = query("select count(*) as numOfComms 
        from posts inner join comments on posts.postId = 
        comments.commentPostId where posts.userId =" . loggedInUserId() ."");
        while ($row = mysqli_fetch_assoc($result)) {
            return $row['numOfComms'];
        }
    }
    function getAllPostUserCategories(){
        $result = query("select count(*) as numOfCats 
        from categories where categories.userId =" . loggedInUserId() ."");
        while ($row = mysqli_fetch_assoc($result)) {
            return $row['numOfCats'];
        }
    }
    // select * from <table> where <columnName> = '<data>'
    function whereQuery($tableName, $columnName, $status){
        global $connection;
        $query = "select * from $tableName where $columnName = '$status'";
        $result = mysqli_query($connection, $query);
        return mysqli_num_rows($result);
    }
     
    // username exists
    function usernameExists($username){
        global $connection;
        $query = "select username from users where username = '$username'";
        $result = mysqli_query($connection, $query);
        confirmQuery($result);
        if(mysqli_num_rows($result) > 0){
            return true;
        } else{
            return false;
        }
    }
    // email exists
    function emailExists($email){
        global $connection;
        $stmt = mysqli_prepare($connection,"select userEmail from users where userEmail = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        confirmQuery($stmt);
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) > 0){
            return true;
        } else{
            return false;
        }
    }
    // register user
    function registerUser($username, $email, $password){
        global $connection;

        $username = escape($username);
        $email = escape($email);
        $password = escape($password);
        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

        $query = "INSERT INTO `users`(`username`, `userPassword`, `userEmail`, `userRole`) VALUES ('$username','$password','$email',
        'subscriber')";
        $registerQuery = mysqli_query($connection, $query);
        confirmQuery($registerQuery);
    }
    // login user
    function loginUser($username, $password){
        global $connection;

        $username = trim($username);
        $password = trim($password);

        $username = escape($username);
        $password = escape($password);

        $query = "select * from users where username = '$username'";
        $selectUser = mysqli_query($connection, $query);
        confirmQuery($selectUser);

        while($row = mysqli_fetch_assoc($selectUser)){
            $id = $row['userId'];
            $user = $row['username'];
            $firstName = $row['userFirstName'];
            $lastName = $row['userLastName'];
            $pwd = $row['userPassword'];
            $email = $row['userEmail'];
            $role = $row['userRole'];
        }
        if(password_verify($password, $pwd)){ 
            $_SESSION['id'] = $id;
            $_SESSION['role'] = $role;
            $_SESSION['user'] = $user;
            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
            $_SESSION['email'] = $email;
            redirect("/cmsprojekat/admin/index.php");
        }
        else{
            return false;
        }
    }
?>