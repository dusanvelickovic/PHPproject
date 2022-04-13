<?php include "includes/adminHeader.php"; ?>

    <div id="wrapper">
        <!-- Navigation -->
        <?php include "includes/adminNavigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small>Author</small>
                        </h1>

                        <div class="col-xs-6">
                            <?php
                                insertCategories();
                            ?>
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="categoryTitle">Add Category</label>
                                    <input class="form-control" type="text" name="categoryTitle" id="">
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="submit" id="" value="Add Category">
                                </div>
                            </form>
                            
                            <?php
                                // update and include query
                                if(isset($_GET['edit'])){
                                    $categoryId = $_GET['edit']; 
                                    include "includes/updateCategories.php";
                                }
                            ?>

                        </div>
                        <div class="col-xs-6">                              
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    // FIND ALL CATEGORIES QUERY
                                    findAllCategories();  
                                ?>  
                                <?php 
                                    // DELELTE QUERY
                                    deleteCategory();
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php include "includes/adminFooter.php"; ?>