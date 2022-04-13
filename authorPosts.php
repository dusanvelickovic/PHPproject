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
                    if(isset($_GET['pId'])){
                        $thePostId = $_GET['pId'];
                        $thePostAuthor = $_GET['author'];
                    }

                    $query = "select * from posts where postAuthor = '{$thePostAuthor}'";
                    $selectAllPostsQuery = mysqli_query($connection, $query);

                        while($row = mysqli_fetch_assoc($selectAllPostsQuery)){
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
                                All posts by <?php echo $postAuthor; ?>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> <?php echo $postDate;?></p>
                            <hr>
                            <img class="img-responsive" src="images/<?php echo $postImage;?>" alt="">
                            <hr>
                            <p><?php echo $postContent; ?></p>
                <?php   }  ?>
                <hr>
                 <!-- Blog Comments -->
                <?php
                    if(isset($_POST['createComment'])){
                        $thePostId = $_GET['pId'];
                        $commentAuthor = $_POST['commentAuthor'];
                        $commentEmail = $_POST['commentEmail'];
                        $commentContent = $_POST['commentContent'];
                        if(!empty($commentAuthor) && !empty($commentEmail) && !empty($commentContent)){
                            $query = "INSERT INTO `comments`(`commentPostId`, `commentAuthor`, `commentEmail`, `commentContent`, `commentStatus`, `commentDate`) VALUES 
                            ('$thePostId','$commentAuthor','$commentEmail','$commentContent','disapproved',now())";
    
                            $result = mysqli_query($connection, $query);
                            if(!$result){
                                die('QUERY FAILED' . mysqli_error($connection));
                            }
    
                            $query = "update posts set postCommentCount = postCommentCount + 1 where postId = $thePostId";
                            $increment = mysqli_query($connection, $query);
                        } else{
                            echo "<script>alert('Fields cannot be empty.')</script>";
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