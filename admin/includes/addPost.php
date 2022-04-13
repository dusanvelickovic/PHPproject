<?php
    if(isset($_POST['createPost'])){
        $postTitle = escape($_POST['title']);
        $postAuthor = escape($_POST['author']);
        $postCategoryId = escape($_POST['category']);
        $postStatus = escape($_POST['status']);

        $postImage = $_FILES['image']['name'];
        $postImageTemp = $_FILES['image']['tmp_name'];

        $postTags = escape($_POST['tags']);
        $postContent = escape($_POST['content']);
        $postDate = date('d-m-y');
        // $postCommentCount = 4;
        $userId = $_SESSION['id'];
        move_uploaded_file($postImageTemp, "../images/$postImage");

        $query = "INSERT INTO `posts`(`postCategoryId`, `postTitle`, `postAuthor`, `postDate`, `postImage`, `postContent`, `postTags`, `postStatus`, `userId`) VALUES ('$postCategoryId','$postTitle','$postAuthor',now(),'$postImage','$postContent','$postTags','$postStatus', '$userId')";

        $result = mysqli_query($connection, $query);
        confirmQuery($result);

        $thePostId = mysqli_insert_id($connection);

        echo "<p class='bg-success'>Post Created. <a href='../post.php?pId=$thePostId'>View Post </a>or<a href='posts.php'> Edit More Posts</a></p>";
    }
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>
    <div class="form-group">
        <label for="category">Category</label>
        <select name="category" id="">
            <?php 
                $query = "select * from categories";
                $selectCategories = mysqli_query($connection, $query);
                confirmQuery($selectCategories);

                while($row = mysqli_fetch_assoc($selectCategories)){
                    $categoryId = escape($row['categoryId']);
                    $categoryTitle = escape($row['categoryTitle']);

                    echo "<option value='$categoryId'>$categoryTitle</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="users">Users</label>
        <select name="author" id="">
            <?php 
                $query = "select * from users";
                $selectUsers = mysqli_query($connection, $query);
                confirmQuery($selectUsers);

                while($row = mysqli_fetch_assoc($selectUsers)){
                    $userId = escape($row['userId']);
                    $username = escape($row['username']);

                    echo "<option value='$username'>$username</option>";
                }
            ?>
        </select>
    </div>
    <!-- <div class="form-group">
        <label for="author">Post Author</label>
        <input type="text" class="form-control" name="author">
    </div> -->
    <div class="form-group">
        <select name="status" id="">
            <option value="draft">Post status</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
        </select>
    </div>
    <div class="form-group">
        <label for="image">Post Image</label>
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="tags">Post Tags</label>
        <input type="text" class="form-control" name="tags">
    </div>
    <div class="form-group">
        <label for="summernote">Post Content</label>
        <textarea type="text" class="form-control" name="content" cols="30" rows="10" id="summernote"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="createPost" value="Publish Post">
    </div>
</form>