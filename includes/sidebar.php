<div class="col-md-4">
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="POST">
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                </button>
                </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>           
    <!--  Login  -->
    <div class="well">
        <?php
            if(isLoggedIn()){
                $user = $_SESSION['user'];
                echo "<h4>Logged in as $user</h4>";
                echo "<a href='includes/logout.php' class='btn btn-danger'>Logout</a>";
            } else{
                ?>
        <h4>Login</h4>
        <?php
            if(ifItIsMethod("post")){
                if(isset($_POST["username"]) && isset($_POST["password"])){
                    loginUser($_POST["username"], $_POST["password"]);
                } else{
                    redirect("/cmsprojekat/index");
                }
            }
        ?>
        <form  method="POST">
            <div class="form-group">
                <input name="username" required type="text" class="form-control" placeholder="Enter username">
            </div>
            <div class="input-group">
                <input name="password" type="password" required class="form-control" placeholder="Enter password">
                <span class="input-group-btn">
                    <button class="btn btn-primary" name="login" type="submit">Submit</button>
                </span>
            </div>
            <!-- <div class="form-group">
                <a href="forgot.php?forgot=<?php echo uniqid(true) ?>">Forgot password</a>
            </div> -->
        </form>
    <?php } ?>
        <!-- /.input-group -->
    </div>
    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                        $query = "select * from categories";
                        $categoriesQuerySidebar = mysqli_query($connection, $query);        
                        while($row = mysqli_fetch_assoc($categoriesQuerySidebar)){
                            $categoryTitle = $row['categoryTitle'];
                            $categoryId = $row['categoryId'];
                            echo "<li><a href='/cmsprojekat/category/$categoryId'>{$categoryTitle}</a></li>";
                        }
                    ?>                              
                </ul>
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- Side Widget Well -->
    <?php include "widget.php"; ?>
</div>
