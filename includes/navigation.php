<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/cmsprojekat/index.php">CMS Front</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php
                        $query = "select * from categories";
                        $selectAllCategoriesQuery = mysqli_query($connection, $query);

                        while($row = mysqli_fetch_assoc($selectAllCategoriesQuery)){
                            $categoryTitle = $row['categoryTitle'];
                            $categoryId = $row['categoryId'];
                            $categoryClass  = '';
                            $registrationClass = '';
                            $contactClass = '';
                            
                            $registration = 'registration.php';
                            $contact = 'contact.php';
                            $pageName = basename($_SERVER['PHP_SELF']);

                            if(isset($_GET['category']) && $_GET['category'] == $categoryId){
                                $categoryClass = 'active';
                            } else if($pageName == $registration){
                                $registrationClass = 'active';
                            } else if($pageName == $contact){
                                $contactClass = 'active';
                            }
                            echo "<li class='$categoryClass'><a href='/cmsprojekat/category/$categoryId'>{$categoryTitle}</a></li>";
                        }
                    ?>
                    <?php
                        if(isLoggedIn()){
                            echo "
                            <li>
                                <a href='/cmsprojekat/admin'>Admin</a>
                            </li>";
                            echo "
                            <li>
                                <a href='/cmsprojekat/includes/logout.php'>Logout</a>
                            </li>";
                        } else{
                            echo "
                            <li>
                                <a href='/cmsprojekat/login.php'>Login</a>
                            </li>";
                        }
                        ?>
                    <li class="<?php echo $registrationClass ?>">
                        <a href="/cmsprojekat/registration">Registration</a>
                    </li>
                    <li class="<?php echo $contactClass ?>">
                        <a href="/cmsprojekat/contact">Contact</a>
                    </li>
                    <?php
                        if(isset($_SESSION['role'])){
                            if(isset($_GET['pId'])){
                                $pid = $_GET['pId'];
                                echo "
                                <li>
                                <a href='admin/posts.php?source=editPost&pId=$pid'>Edit Post</a>
                                </li>
                                ";
                            }
                        }
                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>