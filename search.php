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
                            Page Heading
                            <small>Secondary Text</small>
                        </h1>-->

            <?php
            if (isset($_POST['submit'])) {
                $search = $_POST['search'];

                $sql = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' ";

                $result = mysqli_query($con, $sql);
                $count = mysqli_num_rows($result);
                if ($count == 0) {
                    ?>
                    <h1>No Results Found For  <?php echo $search; ?> </h1>
                    <?php
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
                        <h3>Your Search Results For <?php echo $search; ?></h3>
                        <hr>
                        <h2>
                            <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_by; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" width="300" height="200" alt="image not found">
                        <hr>
                        <p><?php echo $post_content; ?></p>
                        <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                        <hr>
                        <?php
                    }
                }
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