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
                if(isset($_GET['category'])){
                    $postCategoryId = $_GET['category'];
                    if(isAdmin($_SESSION['user'])){
                        $stmt1 = mysqli_prepare($connection, 
                        "select postId, postTitle, postAuthor, postDate, postImage, postContent 
                        from posts where postCategoryId = ?");
                    } else{
                        $_SESSION['user'] = null;
                        $stmt2 = mysqli_prepare($connection,"select postId, postTitle, postAuthor, postDate, postImage, postContent from posts where postCategoryId = ? and postStatus = ?");
                        $published = 'published';
                    }                    
                    if(isset($stmt1)){
                        mysqli_stmt_bind_param($stmt1, "i", $postCategoryId);
                        mysqli_stmt_execute($stmt1);
                        mysqli_stmt_bind_result($stmt1, $postId, $postTitle, $postAuthor, $postDate, $postImage, $postContent);
                        mysqli_stmt_store_result($stmt1);
                        $stmt = $stmt1;
                    } else{
                        mysqli_stmt_bind_param($stmt2, "is", $postCategoryId, $published);
                        mysqli_stmt_execute($stmt2);
                        mysqli_stmt_bind_result($stmt2, $postId, $postTitle, $postAuthor, $postDate, $postImage, $postContent);
                        mysqli_stmt_store_result($stmt2);
                        $stmt = $stmt2;
                    }
                    if(mysqli_stmt_num_rows($stmt) === 0){
                        echo "<h2 class='text-center'>No posts available</h2>";
                    } else{
                        while(mysqli_stmt_fetch($stmt)):
                            ?> 
                            <h1 class="page-header">
                                Page Heading
                                <small>Secondary Text</small>
                            </h1>
                            <!-- First Blog Post -->
                            <h2>
                                <a href="/cmsprojekat/post.php?pId=<?php echo $postId; ?>"><?php echo $postTitle; ?></a>
                            </h2>
                            <p class="lead">
                                by <a href="/cmsprojekat/authorPosts.php?author=<?php echo $postAuthor; ?>&pId=<?php echo $postId; ?>"><?php echo $postAuthor; ?></a>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> <?php echo $postDate;?></p>
                            <hr>
                            <img class="img-responsive" src="/cmsprojekat/images/<?php echo $postImage;?>" alt="">
                            <hr>
                            <p><?php echo $postContent; ?></p>
                            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>     
                <?php endwhile; mysqli_stmt_close($stmt); } }
                else{
                    header("Location: index.php");
                }?>
            </div>
        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>
    </div>
    <!-- /.row -->
    <hr>
<?php include "includes/footer.php" ?>