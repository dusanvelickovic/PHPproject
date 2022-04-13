<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "admin/functions.php"; ?>
<?php session_start(); ?>
    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php

                    if(isset($_POST['submit'])){

                        $search =  $_POST['search'];

                        $query = "select * from posts where posts.postTags LIKE '%$search%'";
                        $searchQuery = mysqli_query($connection, $query);

                        if(!$searchQuery){
                            die("Query failed" . mysqli_error($connection));
                        }
                        $count = mysqli_num_rows($searchQuery);

                        if($count == 0){
                            echo "<h1>No result.</h1>";
                        } else{

                            while($row = mysqli_fetch_assoc($searchQuery)){
                                $postTitle = $row['postTitle'];
                                $postAuthor = $row['postAuthor'];
                                $postDate = $row['postDate'];
                                $postImage = $row['postImage'];
                                $postContent = $row['postContent'];
                            

                ?> 
                            <h1 class="page-header">
                                Page Heading
                                <small>Secondary Text</small>
                            </h1>
            
                            <!-- First Blog Post -->
                            <h2>
                                <a href="#"><?php echo $postTitle; ?></a>
                            </h2>
                            <p class="lead">
                                by <a href="index.php"><?php echo $postAuthor; ?></a>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> <?php echo $postDate;?></p>
                            <hr>
                            <img class="img-responsive" src="images/<?php echo $postImage;?>" alt="">
                            <hr>
                            <p><?php echo $postContent; ?></p>
                            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>                
                
                <?php       }                           
                        }
                    }
                    ?>
                    


                
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>
        </div>
        <!-- /.row -->

        <hr>
<?php include "includes/footer.php" ?>