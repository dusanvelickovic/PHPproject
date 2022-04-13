<table class="table table-bordered table-hover"
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In response to</th>
            <th>Date</th>
            <th>Approve</th>
            <th>Disapprove</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $query = "select * from comments";
            $showComments = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($showComments)){
                $commentId = $row['commentId'];
                $commentPostId = $row['commentPostId'];
                $author = $row['commentAuthor'];
                $email = $row['commentEmail'];
                $content = $row['commentContent'];
                $status = $row['commentStatus'];
                $date = $row['commentDate'];

                echo "<tr>
                <td>$commentId</td>
                <td>$author</td>
                <td>$content</td>
                <td>$email</td>";

                // $query = "select * from categories where categoryId = $category";
                // $categoriesQuery = mysqli_query($connection, $query);      

                // $categoryTitle = '';
                // while($row = mysqli_fetch_assoc($categoriesQuery)){
                //     $categoryId = $row['categoryId'];
                //     $categoryTitle = $row['categoryTitle'];
                // }
                // echo "<td>$categoryTitle</td>";
                echo "<td>$status</td>";
                $query = "select * from posts where postId = $commentPostId";
                $selectPostId = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($selectPostId)){
                    $postId = $row['postId'];
                    $postTitle = $row['postTitle'];
                    echo "<td><a href='../post.php?pId=$postId'>$postTitle</a></td>";
                }
                echo "<td>$date</td>
                <td><a href='comments.php?approve=$commentId'>Approve</a></td>
                <td><a href='comments.php?disapprove=$commentId'>Disapprove</a></td>
                <td><a href='comments.php?delete=$commentId'>Delete</a></td>
                </tr>";
            }
        ?>
        <?php
            if(isset($_GET['approve'])){
                $approve = $_GET['approve'];

                $approveQuery = "update comments set commentStatus = 'approved' where commentId = $approve";

                $result = mysqli_query($connection, $approveQuery);

                confirmQuery($result);
                header("Location: comments.php");
            }
            if(isset($_GET['disapprove'])){
                $disapprove = $_GET['disapprove'];

                $disapproveQuery = "update comments set commentStatus = 'disapproved' where commentId = $disapprove";

                $result = mysqli_query($connection, $disapproveQuery);

                confirmQuery($result);
                header("Location: comments.php");
            }
            if(isset($_GET['delete'])){
                $deleteComment = $_GET['delete'];

                $query = "delete from comments where commentId = {$deleteComment}";

                $result = mysqli_query($connection, $query);

                confirmQuery($result);
                header("Location: comments.php");
            }
        ?>
    </tbody>
</table>