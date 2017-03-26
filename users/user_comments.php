<?php include '../includes/db.php'; ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <?php
        if (!isset($_SESSION['user_role'])) {
            header("Location: ../index.php");
        }
        $role = $_SESSION['user_role'];
        if ($role == 'Admin') {
            header("Location: ../index.php");
        }
        ?>

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

                        </div>
                    </div>

                    <?php
                    if (isset($_POST['entireCommentId'])) {

                        foreach ($_POST['entireCommentId'] as $id) {
                            $bulk_options = $_POST['bulk_options'];

                            switch ($bulk_options) {
                                case 'approve':
                                    $sql_approve = "UPDATE comments SET comment_status='Approved' WHERE comment_id=$id";
                                    $result_approve = mysqli_query($con, $sql_approve);
                                    if (!$sql_approve) {
                                        die("failed :" . mysqli_error($con));
                                    }
                                    header("Location: user_comments.php");
                                    break;
                                case 'unapprove':
                                    $sql_unapprove = "UPDATE comments SET comment_status='UnApproved' WHERE comment_id=$id";
                                    $result_unapprove = mysqli_query($con, $sql_unapprove);
                                    if (!$sql_unapprove) {
                                        die("failed :" . mysqli_error($con));
                                    }
                                    header("Location: user_comments.php");
                                    break;
                                case 'delete':
                                    $sql = "DELETE FROM comments WHERE comment_id=$id";
                                    $result = mysqli_query($con, $sql);
                                    if (!$result) {
                                        die('failed to delete ' . mysqli_error($con));
                                    }
                                    header("Location: user_comments.php");
                                    break;
                            }
                        }
                    }
                    ?>
                    <!-- /.row -->
                    <form action="" method="post">
                        <table class="table table-bordered table-hover">
                            <div id="bulkOptionsContainer" class="col-xs-4">
                                <select id="bulk" class="form-control" name="bulk_options">
                                    <option value="">Select Options</option>
                                    <option value="approve">Approve</option>
                                    <option value="unapprove">Un Approve</option>
                                    <option value="delete">Delete</option>
                                </select>          
                            </div>
                            <div class="col-xs-4">      
                                <input type="submit" name="submit" class="btn btn-success" value="Apply" />
                            </div>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th><input id="selectAllBoxes" type="checkbox"></th>
                                        <th>ID</th>
                                        <th>Author</th>
                                        <th>Comments</th>
                                        <th>Email ID</th>
                                        <th>Status</th>
                                        <th>In Response To</th>
                                        <th>Date</th>
                                        <th>Approve</th>
                                        <th>UnApprove</th>
                                        <th>Delete</th>
                                    </tr>                        
                                </thead>
                                <tbody>
                                    <?php
                                    $comments_count=0;
                                    $post_by = $_SESSION['username'];
                                    $sql_posts = "SELECT * FROM posts WHERE post_by='$post_by'";
                                    $post_result = mysqli_query($con, $sql_posts);
                                    $post_count = mysqli_num_rows($post_result);
                                    if ($post_count < 1) {
                                        echo '<tr><td  align="center" colspan="11">You have no posts yet. <a href="user_post.php?user_source=add_posts">Add Posts </a>to get comments </td></tr> ';
                                    }
                                    while ($row = mysqli_fetch_assoc($post_result)) {
                                        $post_id = $row['post_id'];

                                        $sql = "SELECT * FROM comments WHERE comment_post_id=$post_id";
                                        $select_posts = mysqli_query($con, $sql);
                                        $comments_count = mysqli_num_rows($select_posts);

                                        while ($row = mysqli_fetch_assoc($select_posts)) {
                                            $comment_id = $row['comment_id'];
                                            $comment_post_id = $row['comment_post_id'];
                                            $comment_author = $row['comment_author'];
                                            $comment_email = $row['comment_email'];
                                            $comment_content = $row['comment_content'];
                                            $comment_date = $row['comment_date'];
                                            $comment_status = $row['comment_status'];


                                            echo "<tr>";
                                            echo "<td><input type='checkbox' class='checkboxes' name='entireCommentId[]' value='$comment_id' /></td>";
                                            echo "<td>$comment_id</td>";
                                            echo "<td>$comment_author</td>";
                                            echo "<td>$comment_content</td>";
                                            echo "<td>$comment_email</td>";
                                            echo "<td>$comment_status</td>";


                                            $sql_comment = "SELECT * FROM posts WHERE post_id= $comment_post_id ";
                                            $result = mysqli_query($con, $sql_comment);
                                            $comment_count = mysqli_num_rows($result);
                                            if ($comment_count < 1) {
                                                echo "<td>You Have Deleted The Post</td>";
                                            } else {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $post_id = $row['post_id'];
                                                    $post_title = $row['post_title'];

                                                    echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                                                }
                                            }

                                            echo "<td>$comment_date</td>";
                                            echo "<td><a class='btn btn-primary' href='user_comments.php?&approve=$comment_id'>Approve</a></td>";
                                            echo "<td><a class='btn btn-info' href='user_comments.php?&unapprove=$comment_id'>UnApprove</a></td>";
                                            echo "<td><a class='btn btn-danger' onClick=\"javascript:return confirm('Are You Sure You Want To Delete');\" href='user_comments.php?&delete=$comment_id'>Delete</a></td>";

                                            echo "</tr>";
                                        }
                                    }
                                    if ($comments_count < 1) {
                                        echo '<tr><td  align="center" colspan="11">You have no comments yet </td></tr> ';
                                    }
                                    ?>
                                    <?php
                                    if (isset($_GET['unapprove'])) {
                                        $comment_id = $_GET['unapprove'];
                                        $sql_unapprove = "UPDATE comments SET comment_status='UnApproved' WHERE comment_id=$comment_id";
                                        $result_unapprove = mysqli_query($con, $sql_unapprove);
                                        if (!$sql_unapprove) {
                                            die("failed :" . mysqli_error($con));
                                        }
                                        header("Location: user_comments.php");
                                    }

                                    if (isset($_GET['approve'])) {
                                        $comment_id = $_GET['approve'];

                                        $sql_approve = "UPDATE comments SET comment_status='Approved' WHERE comment_id=$comment_id";
                                        $result_approve = mysqli_query($con, $sql_approve);
                                        if (!$sql_approve) {
                                            die("failed :" . mysqli_error($con));
                                        }
                                        header("Location: user_comments.php");
                                    }


                                    if (isset($_GET['delete'])) {

                                        $delete_id = $_GET['delete'];
                                        $sql = "DELETE FROM comments WHERE comment_id=$delete_id";
                                        $result = mysqli_query($con, $sql);
                                        if (!$result) {
                                            die('failed to delete ' . mysqli_error($con));
                                        }
                                        header("Location: user_comments.php");
                                    }
                                    ?>
                                </tbody>
                            </table>
                    </form>
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
        <script src="js/script.js"></script>

    </body>

</html>
