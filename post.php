<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "admin/functions.php"; ?>
<?php session_start(); ?>
    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>
    <?php
        if(isset($_POST['liked'])){
            $postId = $_POST['postId'];
            $userId = $_POST['userId'];

            
            // fetching post
            $stmt = mysqli_prepare($connection, "SELECT likes FROM posts WHERE postId = ?");
            mysqli_stmt_bind_param($stmt, "i", $postId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $postId);
            $likes = mysqli_stmt_store_result($stmt);

            // update post with like
            mysqli_query($connection, "UPDATE posts SET likes=$likes+1 WHERE postId=$postId");

            // insert like for post
            mysqli_query($connection, "INSERT INTO likes(userId, postId) VALUES ($userId, $postId)");
            exit();
        }
    ?>
    <?php
        if(isset($_POST['disliked'])){
            $postId = $_POST['postId'];
            $userId = $_POST['userId'];

            // fetching post
            $stmt = mysqli_prepare($connection, "select likes from posts
            where postId = ?");
            mysqli_stmt_bind_param($stmt, "i", $postId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $postId);
            $likes = mysqli_stmt_store_result($stmt);
            
            // $query = "SELECT * FROM posts WHERE postId = $postId";
            // $result = mysqli_query($connection, $query);
            // $post = mysqli_fetch_assoc($result);
            // $likes = $post['likes'];

            // update post with dislike
            mysqli_query($connection, "UPDATE posts SET likes = $likes - 1 WHERE postId = $postId");

            // deleting like for post
            mysqli_query($connection, "DELETE FROM likes WHERE postId = $postId AND userId = $userId");
            exit();
        }
    ?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                    if(isset($_GET['pId'])){
                        $thePostId = $_GET['pId'];
                        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                            $viewQuery = "UPDATE posts set postViewsCount = postViewsCount + 1 where postId = $thePostId";
                            $sendQuery = mysqli_query($connection, $viewQuery);
                            if(!$sendQuery){
                                die("QUERY FAILED" . mysqli_error($connection));
                            }
                        }
                        if(isset($_SESSION['role']) and $_SESSION['role'] == 'admin'){
                            $query = "select * from posts where postId = $thePostId";
                        } else{
                            $query = "select * from posts where postId = $thePostId and postStatus = 'published'";
                        }
                        $selectAllPostsQuery = mysqli_query($connection, $query);
                        if(mysqli_num_rows($selectAllPostsQuery) < 1){
                            echo "<h2 class='text-center'>No posts available</h2>";
                        } else{
                            while($row = mysqli_fetch_assoc($selectAllPostsQuery)){
                                $postTitle = $row['postTitle'];
                                $postAuthor = $row['postAuthor'];
                                $postDate = $row['postDate'];
                                $postImage = $row['postImage'];
                                $postContent = $row['postContent'];
                                ?> 
                            <h1 class="page-header">
                                Post 
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
                            <img class="img-responsive" src="/cmsprojekat/images/<?php echo $postImage;?>" alt="">
                            <hr>
                            <p><?php echo $postContent; ?></p>
                            <?php   
                        }
                        ?>
                    <hr>
                    <?php 
                        if(isLoggedIn()){ ?>
                            <div class="row">
                                <p class="pull-right"><a 
                                    class="<?php echo userLikedPost($thePostId) ? 'dislike' : 'like' ?>" 
                                    href=""><span class="glyphicon glyphicon-thumbs-up"
                                    data-toggle="tooltip" 
                                    data-placement="top"
                                    title="<?php echo userLikedPost($thePostId) ? 'I liked this before' : 'Want to like it?' ?>"
                                    ></span> 
                                    <?php echo userLikedPost($thePostId) ? 'Dislike' : 'Like' ?>
                                </a></p>
                            </div>
                    <?php    } else{ ?>
                        <div class="row">
                            <p class="pull-right login-to-post">You need to <a href="/cmsprojekat/login.php">login</a> to like</p>
                        </div>
                    <?php }
                    ?>
                    <!-- <div class="row">
                        <p class="pull-right"><a class="dislike" href="#"><span class="glyphicon glyphicon-thumbs-down"></span> Dislike</a></p>
                    </div> -->
                    <div class="row">
                        <p class="pull-right likes">Likes: <?php echo getPostLikes($thePostId) ?></p>
                    </div>
                    <div class="clearfix"></div>
                    <!-- Blog Comments -->
                    <?php
                        // COMMENT
                        if($_SERVER['REQUEST_METHOD'] === 'POST'){
                            if(isset($_POST['createComment'])){
                                $thePostId = $_GET['pId'];
                                $commentAuthor = $_POST['commentAuthor'];
                                $commentEmail = $_POST['commentEmail'];
                                $commentContent = $_POST['commentContent'];
                                if(!empty($commentAuthor) && !empty($commentEmail) && !empty($commentContent)){
                                    $query = "INSERT INTO `comments`(`commentPostId`, `commentAuthor`, `commentEmail`, `commentContent`, `commentStatus`, `commentDate`) VALUES ('$thePostId','$commentAuthor','$commentEmail','$commentContent','disapproved',now())";
                                    $result = mysqli_query($connection, $query);
                                    if(!$result){
                                        die('QUERY FAILED' . mysqli_error($connection));
                                    }
                                } else{
                                    echo "<script>alert('Fields cannot be empty.')</script>";
                                }
                            }
                        }
                    ?>
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="" method="POST">
                        <div class="form-group">
                            <label for="authro">Author</label>
                            <input type="text" class="form-control" name="commentAuthor">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="commentEmail" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="comment">Your comment</label>
                            <textarea class="form-control" rows="3" name="commentContent"></textarea>
                        </div>
                        <button type="submit" name="createComment" class="btn btn-primary">Submit</button>
                    </form>
                </div>             
                <hr>
                <!-- Posted Comments -->
                <?php 
                    $query = "select * from comments where commentPostId = $thePostId 
                    and commentStatus = 'approved' order by commentId DESC";
                    
                    $commentQuery = mysqli_query($connection, $query);
                    if(!$commentQuery){
                        die('QUERY FAILED' . mysqli_error($connection));
                    }
                    
                    while($row = mysqli_fetch_assoc($commentQuery)){
                        $commentDate = $row['commentDate'];
                        $commentContent = $row['commentContent'];
                        $commentAuthor = $row['commentAuthor'];
                        ?>
                    <!-- Comment -->
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="https://place-hold.it/64x64" alt="">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $commentAuthor ?>
                            <small><?php echo $commentDate ?></small>
                        </h4>
                        <?php echo $commentContent ?>
                    </div>
                </div>
                <?php    
                }
                    } } 
                    else{
                        header("Location: index.php");
                    }
                    ?>
            </div>
            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>
        </div>
        <!-- /.row -->
        <hr>
<?php include "includes/footer.php" ?>
<script>
    $(document).ready(function (){ 
        $("[data-toggle='tooltip']").tooltip();
        let postId = <?php echo $thePostId; ?>;
        let userId = <?php echo loggedInUserId(); ?>;
        // liking
        $('.like').click(function(){
            $.ajax({
                url: "/cmsprojekat/post.php?pId=<?php echo $thePostId ?>",
                type: "post",
                data: {
                    "liked": 1,
                    "postId": postId,
                    "userId": userId
                }
            });
        });
        // disliking
        $('.dislike').click(function(){
            $.ajax({
                url: "/cmsprojekat/post.php?pId=<?php echo $thePostId ?>",
                type: "post",
                data: {
                    "disliked": 1,
                    "postId": postId,
                    "userId": userId
                }
            });
        });
    })
</script>