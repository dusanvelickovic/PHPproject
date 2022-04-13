<?php
include "deletemodal.php";
    if(isset($_POST['checkBoxArray'])){
        foreach(($_POST['checkBoxArray']) as $postValueId){
            $bulk_options = escape($_POST['bulk_options']);

            switch($bulk_options){
                case 'published':
                    $query = "update posts set postStatus = '$bulk_options' where postId = '$postValueId'";
                    $updateToPublish = mysqli_query($connection, $query);
                    confirmQuery($updateToPublish);
                break;
                case 'draft':
                    $query = "update posts set postStatus = '$bulk_options' where postId = '$postValueId'";
                    $updateToDraft = mysqli_query($connection, $query);
                    confirmQuery($updateToDraft);
                break;
                case 'delete':
                    $query = "delete from posts where postId = '$postValueId'";
                    $deletePosts = mysqli_query($connection, $query);
                    confirmQuery($deletePosts);
                break;
                case 'clone':

                    $query = "select * from posts where postId = '$postValueId'";
                    $clonePost = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_assoc($clonePost)){
                        $postTitle = escape($row['postTitle']);
                        $postCategoryId = escape($row['postCategoryId']);
                        $postAuthor = escape($row['postAuthor']);
                        $commentCount = escape($row['postCommentCount']);
                        $postDate = escape($row['postDate']);
                        $postImage = escape($row['postImage']);
                        $postContent = escape($row['postContent']);
                        $postTags = escape($row['postTags']);
                        $postStatus = escape($row['postStatus']);
                    }
                    
                    $query = "INSERT INTO `posts`(`postCategoryId`, `postTitle`, `postAuthor`, `postDate`, `postImage`, `postContent`, `postTags`, `postStatus`, `postCommentCount`) VALUES ('$postCategoryId','$postTitle','$postAuthor',now(),'$postImage','$postContent','$postTags', '$postStatus', '$commentCount')";
                    $copyQuery = mysqli_query($connection, $query);
                    confirmQuery($copyQuery);
                break;
            }
        }
    }
?>
<form action="" method="POST">
    <table class="table table-bordered table-hover">
        <div id="bulkoptionContainer" class="col-xs-4">
            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=addPost">Add New</a>
        </div>
    <thead>
        <tr>
            <th><input id="selectAllBoxes" type="checkbox"></th>
            <th>Id</th>
            <th>User</th>
            <th>Title</th>
            <th>Content</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>View Post</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Reset Views</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $id = loggedInUserId();
            $query = "SELECT * 
            FROM posts INNER JOIN categories
            on categories.categoryId = posts.postCategoryId
            ORDER BY posts.postId DESC";
            $showPosts = mysqli_query($connection, $query);
            
            while($row = mysqli_fetch_assoc($showPosts)){
                $id = $row['postId'];
                $author = $row['postAuthor'];
                $user = $row['postAuthor'];
                $title = $row['postTitle'];
                $content = $row['postContent'];
                $category = $row['postCategoryId'];
                $status = $row['postStatus'];
                $image = $row['postImage'];
                $tags = $row['postTags'];
                $comments = $row['postCommentCount'];
                $date = $row['postDate'];
                $postViewsCount = $row['postViewsCount'];
                $categoryId = $row['categoryId'];
                $categoryTitle = $row['categoryTitle'];
                
                echo "<tr>";
                ?>
                <td><input class='checkBoxes' type='checkbox' name="checkBoxArray[]" value="<?php echo $id ?>"></td>
                <?php
                echo "<td>$id</td>";

                if(!empty($author)){
                    echo"<td>$author</td>";
                } else if(!empty($user)){
                    echo"<td>$user</td>";
                }
                echo"<td>$title</td>";
                echo "<td>$content</td>";
                echo "<td>$categoryTitle</td>";
                echo "<td>$status</td>
                <td><img class='img-responsive' width='200px' src='../images/$image' alt='Post image'></td>
                <td>$tags</td>";

                $query = "select * from comments where commentPostId = $id";
                $numOfComms = mysqli_query($connection, $query);
                $countComms = mysqli_num_rows($numOfComms);
                $row = mysqli_fetch_array($numOfComms);
                if(isset($row['commentId'])){
                    $commentId = $row['commentId'];
                    echo "<td><a href='postComments.php?id=$id'>$countComms</a></td>";
                }

                echo "<td>$date</td>";
                echo "<td><a class='btn btn-primary' href='../post.php?pId=$id'>View Post</a></td>";
                echo "<td><a class='btn btn-success' href='posts.php?source=editPost&pId=$id'>Edit</a></td>";
                ?>

                <form action="" method="POST">
                    <input type="hidden" value="<?php echo $id ?>" name = "postId">
                    
                    <?php
                    
                    echo "<td><input class='btn btn-danger' type='submit' name='delete' value='Delete'></td>"
                    
                    ?>
                </form>
                
                <?php
                // echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?')\" href='posts.php?delete=$id'>Delete</a></td>";
                // echo "<td><a rel='$id' class='delete_link' href='javascript:void(0)'>Delete</a></td>";
                echo "<td><a href='posts.php?reset=$id'>$postViewsCount</a></td>
                </tr>";
            }
            ?>
        <?php
            if(isset($_POST['delete'])){
                $delete = escape($_POST['postId']);
                $query = "delete from posts where postId = {$delete}";
                $result = mysqli_query($connection, $query);
                
                confirmQuery($result);
                header("Location: posts.php");
            }
            if(isset($_GET['reset'])){
                $reset = $_GET['reset'];
                $query = "update posts set postViewsCount = 0 where postId = " . mysqli_real_escape_string($connection, $_GET['reset']) . " ";
                $result = mysqli_query($connection, $query);
                
                confirmQuery($result);
                header("Location: posts.php");
            }
            ?>
        </tbody>
    </table>
</form>
<script>
    $(document).ready(function () {
        $(".delete_link").on('click', function () { 
            let id = $(this).attr("rel");
            let deleteUrl = 'posts.php?delete=' + id +" ";

            $(".modal_delete_link").attr("href", deleteUrl);

            $("#myModal").modal('show');
         })
    });
</script>