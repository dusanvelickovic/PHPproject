<form action="" method="POST">
<div class="form-group">
<label for="categoryTitle">Edit Category</label>

<?php
if(isset($_GET['edit'])){
    $getId = $_GET['edit'];
    
    $query = "select * from categories where categoryId = $getId";
    $categoriesQuery = mysqli_query($connection, $query);      

    while($row = mysqli_fetch_assoc($categoriesQuery)){
        $categoryId = $row['categoryId'];
        $categoryTitle = $row['categoryTitle'];
    ?>    
    <input class="form-control" type="text" name="categoryTitle" value="<?php if(isset($categoryTitle)){ echo $categoryTitle; } ?>" id="">
    
    <?php 
    }
} ?>

<?php
    // UPDATE CATEGORY
    if(isset($_POST['updateCategory'])){
        $getTitle = $_POST['categoryTitle'];

        $stmt = mysqli_prepare($connection,"update categories set categoryTitle = ?
        where categoryId = ?");
        mysqli_stmt_bind_param($stmt, "si", $getTitle, $categoryId);
        mysqli_stmt_execute($stmt);        
        if(!$stmt){
            die("QUERY FAILED" . mysqli_error($connection));
        }
        mysqli_stmt_close($stmt);
        redirect("categories.php");
    }
?>
</div>
<div class="form-group">
<input class="btn btn-primary" type="submit" name="updateCategory" id="" value="Update">
</div>

</form>