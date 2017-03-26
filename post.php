<?php session_start(); ?>
<?php include './includes/header.php'; ?>
<!-- Navigation -->
<?php include './includes/navigation.php'; ?>

<?php include './includes/db.php'; ?>
<!-- Page Content -->

<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

<!--            <h1 class="page-header">
                Posts

            </h1>-->

            <?php
            if (isset($_GET['p_id'])) {
                $p_id = $_GET['p_id'];

                $view_sql = "UPDATE posts SET post_view_count=post_view_count+1 WHERE post_id=$p_id";
                $view_result = mysqli_query($con, $view_sql);

                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin') {
                    $sql = "SELECT * FROM posts WHERE post_id=$p_id";
                } else {
                    $sql = "SELECT * FROM posts WHERE post_id=$p_id AND post_status='published'";
                }
                

                $result = mysqli_query($con, $sql);
                if (mysqli_num_rows($result) < 1) {
                    echo "<h1 class='text-center'>No Posts Available</h1>";
                } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $post_id = $row['post_id'];
                        $post_category_id = $row['post_category_id'];
                        $post_title = $row['post_title'];
                        $post_by = $row['post_by'];
                        $post_image = $row['post_image'];
                        $post_date = $row['post_date'];
                        $post_content = $row['post_content'];
                        $post_tags = $row['post_tags'];
                        ?>


                        <!-- First Blog Post -->
                        <h2>
                            <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="index.php"><?php echo $post_by; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" width="300" height="200" alt="image not found">
                        <hr>
                        <p><?php echo $post_content; ?></p>

                        <hr>
                        <?php
                    }
                    ?>
                    <!-- Blog Comments -->
                    <?php
                    if (isset($_POST['submit_comment'])) {
                        $post_id = $_GET['p_id'];
                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];

                        if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                            $sql_comment = "INSERT INTO comments (comment_post_id,comment_author,comment_email,comment_content,comment_status,comment_date) VALUES("
                                    . " $post_id,'$comment_author','$comment_email','$comment_content','UnApproved' ,now())";

                            $result_comment = mysqli_query($con, $sql_comment);

                            if (!$result_comment) {
                                die("failed to insert :" . mysqli_error($con));
                            }
//                    $sql_comment = "UPDATE posts set post_comment_count=post_comment_count+1 WHERE post_id=$post_id";
//                    $update_comment_count = mysqli_query($con, $sql_comment);
                        } else {
                            echo "<script>alert('Please Fill All The Fields Before Submit')</script>";
                        }
                        echo '<h4 class="bg-success">Comments Posted..It Will Display After Authors Approval</h4>';
                    }
                    ?>

                    <!-- Comments Form -->
                    <div class="well">
                        <h4>Leave a Comment:</h4>
                        <form  action="" method="post" role="form">
                            <div class="form-group">
                                <label for="comment_author">Author Name</label>
                                <input type="text" class="form-control" name="comment_author" required/>
                            </div>
                            <div class="form-group">
                                <label for="comment_email">Email</label>
                                <input type="email" class="form-control" name="comment_email" required/>
                            </div>
                            <div class="form-group">
                                <label for="comment_email">Your Comment</label>
                                <textarea class="form-control" name="comment_content" rows="3" required></textarea>
                            </div>

                            <button type="submit" name="submit_comment" class="btn btn-primary">Submit Comment</button>
                        </form>
                    </div>

                    <hr>

                    <!-- Posted Comments -->

                    <?php
                    $sql = "SELECT * FROM comments WHERE comment_post_id=$post_id AND comment_status='Approved' ORDER BY comment_id DESC";
                    $result = mysqli_query($con, $sql);
                    if (!$result) {
                        die('something went wrong :' . mysqli_error($con));
                    }
                    while ($row = mysqli_fetch_assoc($result)) {
                        $comment_date = $row['comment_date'];
                        $comment_content = $row['comment_content'];
                        $comment_author = $row['comment_author'];
                        ?>

                        <!-- Comment -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="loading">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $comment_author; ?>
                                    <small><?php echo $comment_date; ?></small> 
                                </h4>
                                <?php echo $comment_content; ?>
                            </div>
                        </div>

                        <?php
                    }
                }
            } else {
                header("Location: index.php");
            }
            ?>
        </div>


        <?php include 'includes/sidebar.php'; ?>
    </div>

</div>
<!-- /.row -->

<hr>

<!-- Footer -->
<?php include './includes/footer.php'; ?>