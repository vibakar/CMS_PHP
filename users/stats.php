
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
        <script src="https://www.google.com/jsapi " ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
                            ?>
                        </div>
                    </div>
                    <!-- /.row -->

                    <!--row-->

                    <?php
                    $all_posts_in_db = checkAllPosts('posts');
                    $user_post = recordCountIndividual($username);
                    $active_user_post = checkActiveUserPost($username);
                    $draft_user_post = checkDraftUserPost($username);
                    ?>      
                    <?php
                    $sql_posts = "SELECT * FROM posts WHERE post_by='$username'";
                    $post_result = mysqli_query($con, $sql_posts);
                    $post_count = mysqli_num_rows($post_result);
                    if ($post_count < 1) {
                        $unapproved_comments_count = 0;
                    } else {
                        while ($row = mysqli_fetch_assoc($post_result)) {
                            $post_id = $row['post_id'];
                            $sql = "SELECT * FROM comments WHERE comment_post_id=$post_id AND comment_status='UnApproved'";
                            $select_posts = mysqli_query($con, $sql);
                            $comment_count = mysqli_num_rows($select_posts);
                            if ($comment_count < 1) {
                                $unapproved_comments_count = 0;
                            } else {
                                $unapproved_comments_count = $comment_count;
                            }
                            $final_unapproved_comments+=$unapproved_comments_count;
                        }
                    }
                    ?>

                    <?php
                    $sql_posts = "SELECT * FROM posts WHERE post_by='$username'";
                    $post_result = mysqli_query($con, $sql_posts);
                    $post_count = mysqli_num_rows($post_result);
                    if ($post_count < 1) {
                        $approved_comments_count = 0;
                    } else {
                        while ($row = mysqli_fetch_assoc($post_result)) {
                            $post_id = $row['post_id'];
                            $sql = "SELECT * FROM comments WHERE comment_post_id=$post_id AND comment_status='Approved'";
                            $select_posts = mysqli_query($con, $sql);
                            $comment_count = mysqli_num_rows($select_posts);
                            if ($comment_count < 1) {
                                $approved_comments_count = 0;
                            } else {
                                $approved_comments_count = $comment_count;
                            }
                            $final_approved_comments+=$approved_comments_count;
                        }
                    }
                    ?>

                    <div class="row" id="chart">
                        <script type="text/javascript">
                            google.charts.load('current', {'packages': ['bar']});
                            google.charts.setOnLoadCallback(drawChart);
                            function drawChart() {
                                var data = google.visualization.arrayToDataTable([
                                    ['Stats', 'count'],
<?php
$element_text = ['Total Posts in blog', 'Your Posts', 'Your Active posts', 'Pending For Approval', 'Total Comments', 'Approved Comments', 'Unapproved Comments'];
$element_count = [$all_posts_in_db, $user_post, $active_user_post, $draft_user_post, $draft_user_post, $final_approved_comments, $final_unapproved_comments];

for ($i = 0; $i < 7; $i++) {
    echo "['$element_text[$i]'" . "," . "$element_count[$i]],";
}
?>

                                ]);

                                var options = {
                                    chart: {
                                        title: ' ',
                                        subtitle: ' ',
                                    }
                                };

                                var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                                chart.draw(data, options);
                            }
                            window.addEventListener('resize', function () {
                                var a = document.getElementById('chart');
                                a.style.width = window.innerWidth + 'px';
                                a.style.height = window.innerHeight + 'px';
                            });


                        </script>
                        <div id="columnchart_material" style="width: 1050px; height: 500px;"></div>
                    </div>

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