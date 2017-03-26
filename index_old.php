<?php include './includes/header.php'; ?>
<!-- Navigation -->
<?php include './includes/navigation.php'; ?>

<?php include './includes/db.php'; ?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <br><br>
            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>

            <?php
            $sql = "SELECT * FROM posts WHERE post_status='published'";
            $result = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $post_id = $row['post_id'];
                $post_category_id = $row['post_category_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_image = $row['post_image'];
                $post_date = $row['post_date'];
                $post_content = substr($row['post_content'],0,500);
                $post_tags = $row['post_tags'];
                ?>


                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?p_id=<?php echo $post_id; ?>&author=<?php echo $post_author; ?>"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id; ?>">
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" width="300" height="200" alt="image not found">
                </a>
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
                <?php
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