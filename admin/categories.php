<?php include '../includes/db.php'; ?>
<?php include 'includes/admin_header.php'; ?>
<?php include 'functions.php'; ?>
<div id="wrapper">

    <!-- Navigation -->
    <?php include 'includes/admin_navigation.php'; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">

                    <h1 class="page-header">
                        Welcome <?php echo $_SESSION['user_role']; ?>
                        <small><?php echo $_SESSION['username']; ?></small>
                    </h1>
                    <div class="col-xs-6">

                        <form action="" method="post">

                            <?php
                            //Add categories
                            insert_categories();
                            ?>
                            <div class="form-group">                            
                                <label for="cat-title">Category Title</label>
                                <input type="text" name="cat_title" class="form-control" required />                              
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" value="Add Category" class="btn btn-primary" />                              
                            </div>

                        </form>
                        <?php
                        //update category
                        if (isset($_GET['update_id'])) {
                            $update_cat_id = escape($_GET['update_id']);
                            include 'includes/update_categories.php';
                        }
                        ?>
                    </div>
                    <!-- Add category form -->
                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr><th>ID</th><th>Category Title</th><th>Delete</th><th>Edit</th></tr>
                            </thead>
                            <tbody>
                                <?php
                                //selecting all categories
                                $sql = "SELECT * FROM categories";
                                $result = mysqli_query($con, $sql);
                                $categories_count = mysqli_num_rows($result);
                                if ($categories_count < 1) {
                                    echo '<tr><td  align="center" colspan="4">No Categories Available</td></tr> ';
                                }
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $cat_id = $row['cat_id'];
                                    $cat_title = $row['cat_title'];
                                    ?>

                                    <tr>
                                        <td><?php echo $cat_id; ?></td>
                                        <td><?php echo $cat_title; ?></td>
                                        <?php echo"<td><a class='btn btn-danger' onClick=\"javascript:return confirm('Are You Sure You Want To Delete');\"  href='categories.php?delete_id=$cat_id;'>Delete</a></td>"; ?>
                                        <td><a class='btn btn-info' href="categories.php?update_id=<?php echo $cat_id; ?>&update_title=<?php echo $cat_title; ?>">Edit</a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>                            
                        </table>
                        <?php
                        //Delete category
                        delete_categories();
                        ?>
                    </div>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
    <?php include 'includes/admin_footer.php'; ?>