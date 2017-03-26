
<?php include 'includes/user_header.php'; ?>
<?php include 'user_dashboard.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <?php
    if (!isset($_SESSION['user_role'])) {
        header("Location: ../index.php");
    }
    $role = $_SESSION['user_role'];
    if ($role == 'Admin') {
        header("Location: ../index.php");
    }
    ?>
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>User Page</title>

        <!-- Bootstrap Core CSS -->
        <link href="../admin/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../admin/css/sb-admin.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <?php include './includes/user_navigation.php'; ?>

            <div id="page-wrapper">

                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">
                                Welcome <?php echo $_SESSION['user_role']; ?>
                                <small><?php echo $_SESSION['username']; ?></small>
                            </h1>
                            <?php
                            $username = $_SESSION['username'];
                            $final_unapproved_comments = 0;
                            $all_comments_per_user = 0;
                            $final_approved_comments = 0;
                            $total_post_views = 0;
                            ?>
                        </div>
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-file-text fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <?php
                                            ?>
                                            <div class='huge'><?php echo $post_count = recordCountIndividual($username); ?></div>
                                            <div>Posts</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="user_post.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-comments fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <?php
                                            $sql_posts = "SELECT * FROM posts WHERE post_by='$username'";
                                            $post_result = mysqli_query($con, $sql_posts);
                                            $post_count = mysqli_num_rows($post_result);
                                            if ($post_count < 1) {
                                                $comments_count = 0;
                                            } else {
                                                while ($row = mysqli_fetch_assoc($post_result)) {
                                                    $post_id = $row['post_id'];
                                                    $sql = "SELECT * FROM comments WHERE comment_post_id=$post_id";
                                                    $select_posts = mysqli_query($con, $sql);
                                                    $total_comment_count = mysqli_num_rows($select_posts);
                                                    if ($total_comment_count < 1) {
                                                        $comments_count = 0;
                                                    } else {
                                                        $comments_count = $total_comment_count;
                                                    }
                                                    $all_comments_per_user+=$comments_count;
                                                }
                                            }
                                            ?>
                                            <div class='huge'><?php echo $all_comments_per_user; ?></div>
                                            <div>Comments</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="user_comments.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-yellow">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-user fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <?php
                                            $sql = "SELECT * FROM posts WHERE post_by='$username' ";
                                            $result = mysqli_query($con, $sql);
                                            if ($post_count < 1) {
                                                $total_post_views = 0;
                                            }
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $post_views = $row['post_view_count'];
                                                $total_post_views+=$post_views;
                                            }
                                            ?>
                                            <div class='huge'><?php echo $total_post_views; ?></div>
                                            <div> Post Views</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="user_post.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-red">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-list fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">

                                            <div class='huge'><?php echo $category_count = recordCount('categories'); ?></div>
                                            <div>Categories</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="../index.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--row-->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="../admin/js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../admin/js/bootstrap.min.js"></script>

    </body>

</html>
<?php include 'includes/user_footer.php'; ?>