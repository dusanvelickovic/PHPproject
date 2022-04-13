<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "admin/functions.php"; ?>
<?php session_start(); ?>
<?php ob_start(); ?>
    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                    $per_page = 5;
                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    } else{
                        $page = "";
                    }
                    if($page == "" || $page == 1){
                        $page_1 = 0;
                    } else{
                        $page_1 = ($page * $per_page) - $per_page;
                    }
                    if(isset($_SESSION['role']) and $_SESSION['role'] == 'admin'){
                        $countPosts = "select * from posts";
                    } else{
                        $countPosts = "select * from posts where postStatus = 'published'";
                    }
                    $findCount = mysqli_query($connection, $countPosts);
                    $count = mysqli_num_rows($findCount);
                    $count = ceil($count / $per_page);
                    if($count < 1){
                        echo "<h2 class='text-center'>No posts available</h2>";
                    } else{                        
                        $query = "select * from posts limit $page_1, $per_page";
                        $selectAllPostsQuery = mysqli_query($connection, $query);
                        while($row = mysqli_fetch_assoc($selectAllPostsQuery)){
                            $postId = $row['postId'];
                            $postTitle = $row['postTitle'];
                            $postAuthor = $row['postAuthor'];
                            $postDate = $row['postDate'];
                            $postImage = $row['postImage'];
                            $postContent = substr($row['postContent'], 0, 180) . '...';
                            $postStatus = $row['postStatus'];
                            
                            if($postStatus == 'published'){                            
                                ?> 
                            <h1 class="page-header">
                                Page Heading
                                <small>Secondary Text</small>
                            </h1>
                            <!-- First Blog Post -->
                            <h2>
                                <a href="post/<?php echo $postId; ?>"><?php echo $postTitle; ?></a>
                            </h2>
                            <p class="lead">
                                by <a href="/cmsprojekat/authorPosts.php?author=<?php echo $postAuthor; ?>&pId=<?php echo $postId; ?>"><?php echo $postAuthor; ?></a>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> <?php echo $postDate;?></p>
                            <hr>
                            <a href="post.php?pId=<?php echo $postId ?>"><img class="img-responsive" src="images/<?php echo $postImage;?>" alt=""></a>
                            <hr>
                            <p><?php echo $postContent; ?></p>
                            <a class="btn btn-primary" href="post.php?pId=<?php echo $postId ?>">Read More<span class="glyphicon glyphicon-chevron-right"></span></a>                
                    <?php } } }?>
            </div>
            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>
        </div>
        <!-- /.row -->
        <hr>
        <ul class="pager">
            <?php
                for($i = 1; $i <= $count; $i++){
                    if($i == $page){
                        echo "<li><a class='active_link' href='index.php?page=$i'>{$i}</a></li>";
                    } else{
                        echo "<li><a href='index.php?page=$i'>{$i}</a></li>";       
                    }
                }
            ?>
        </ul>
<?php include "includes/footer.php" ?>