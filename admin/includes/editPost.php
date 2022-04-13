<?php
    if(isset($_GET['pId'])){

        $thePostId = $_GET['pId'];
    }
        $query = "select * from posts where postId = $thePostId";
        $showPosts = mysqli_query($connection, $query);
        confirmQuery($showPosts);
    
        while($row = mysqli_fetch_assoc($showPosts)){
            $id = $row['postId'];
            $author = $row['postAuthor'];
            $title = $row['postTitle'];
            $content = $row['postContent'];
            $category = $row['postCategoryId'];
            $status = $row['postStatus'];
            $image = $row['postImage'];
            $tags = $row['postTags'];
            $comments = $row['postCommentCount'];
            $date = $row['postDate'];    
        }

        if(isset($_POST['update-post'])){
            $postTitle = $_POST['title'];
            $postAuthor = $_POST['author'];
            $postStatus = $_POST['status'];
            $postCategory = $_POST['category'];
            $postTags = $_POST['tags'];
            $postContent = $_POST['content'];
            
            $postImage = $_FILES['image']['name'];
            $postImageTmp = $_FILES['image']['tmp_name'];

            move_uploaded_file($postImageTmp, "../images/$postImage");

            if(empty($postImage)){
                $query = "select * from posts where postId = $thePostId";
                $selectImage = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($selectImage)){
                    $postImage = $row['postImage'];
                }
            }

            $query = "update posts set 
            postTitle = '$postTitle',
            postCategoryId = '$postCategory',
            postAuthor = '$postAuthor',
            postStatus = '$postStatus',
            postTags = '$postTags',
            postContent = '$postContent',
            postImage = '$postImage',
            postDate = now()
            where postId = '$thePostId'";

            $update = mysqli_query($connection, $query);
            confirmQuery($update);

            echo "<p class='bg-success'>Post Updated. <a href='../post.php?pId=$thePostId'>View Post </a>or<a href='posts.php'> Edit More Posts</a></p>";
        }
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title"
        value="<?php echo $title ?>">
    </div>
    <div class="form-group">
        <select name="category" id="">
            <?php 
                $query = "select * from categories";
                $selectCategories = mysqli_query($connection, $query);
                confirmQuery($selectCategories);

                while($row = mysqli_fetch_assoc($selectCategories)){
                    $categoryId = $row['categoryId'];
                    $categoryTitle = $row['categoryTitle'];

                    echo "<option value='$categoryId'>$categoryTitle</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="author">Post Author</label>
        <input type="text" class="form-control" name="author" 
        value="<?php echo $author; ?>">
    </div>
    <div class="form-group">
        <select name="status" id="">
            <option value="<?php echo $status ?>"><?php echo $status ?></option>
            <?php
                if($status == 'published'){
                    echo "<option value='draft'>draft</option>";
                } else{
                    echo "<option value='published'>publish</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <img width="100px
        " src="../images/<?php echo $image ?>" alt="">
        <input type="file" name="image" id="">
    </div>
    <div class="form-group">
        <label for="tags">Post Tags</label>
        <input type="text" class="form-control" name="tags" value="<?php echo $tags ?>">
    </div>
    <div class="form-group">
        <label for="content">Post Content</label>
        <textarea type="text" class="form-control" name="content" cols="30" rows="10" id='summernote'><?php echo str_replace('\r\n', '</br>', $content)?>
        </textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update-post" value="Update Post">
    </div>
</form>