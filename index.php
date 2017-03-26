<?php session_start(); ?>
<?php include './includes/header.php'; ?>
<!-- Navigation -->
<?php include './includes/navigation.php'; ?>

<?php include './includes/db.php'; ?>
<?php include './admin/functions.php'; ?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <!--
                        <h1 class="page-header">
                            Page Heading
                            <small>Secondary Text</small>
                        </h1>-->

            <?php
            $per_page = 4;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = "";
            }

            if ($page == "" || $page == 1) {
                $page_1 = 0;
            } else {
                $page_1 = ($page * $per_page) - $per_page;
            }
            $sql_count = "SELECT * FROM posts ";
            $result_count = mysqli_query($con, $sql_count);
            $count = mysqli_num_rows($result_count);

            if ($count < 1) {
                echo "<h1 class='text-center'>No Posts Available</h1>";
            }
            $count = ceil($count / $per_page);

            $sql = "SELECT * FROM posts WHERE post_status='published' LIMIT $page_1,$per_page ";
            $result = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $post_id = $row['post_id'];
                $post_category_id = $row['post_category_id'];
                $post_title = $row['post_title'];
                $post_by = $row['post_by'];
                $post_image = $row['post_image'];
                $post_date = $row['post_date'];
                $post_content = $row['post_content'];
                $post_tags = $row['post_tags'];
                $post_content = strip_tags($post_content);
                ?>


                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?p_id=<?php echo $post_id; ?>&author=<?php echo $post_by; ?>"><?php echo $post_by; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id; ?>">
                    <?php
                    if (!empty($post_image)) {
                        $sql_image = " SELECT * FROM posts WHERE post_status='published' AND post_id=$post_id ";
                        $result = mysqli_query($con, $sql_image);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $post_image = $row['post_image'];
                        }
                    }
                    ?>
                    <img class="img-responsive" src="images/<?php echo $post_image; ?>" width="300" height="200" alt="image not found">
                </a>
                <hr>
                <p><?php echo substr($post_content, 0, 300) . '...'; ?></p>

                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More<span class="glyphicon glyphicon-chevron-right"></span></a>

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
<ul class="pager">
    <?php
    for ($i = 1; $i <= $count; $i++) {
        if ($i == $page) {
            echo "<li><a class='active_link' href='index.php?page=$i'>$i</a></li>";
        } else {
            echo "<li><a href='index.php?page=$i'>$i</a></li>";
        }
    }
    ?>

</ul>
<!-- Footer -->
<?php include './includes/footer.php'; ?>