<?php ob_start(); ?>
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
                                    header("Location: post_comments.php?id=" . $_GET['id'] . "");
                                    break;
                                case 'unapprove':
                                    $sql_unapprove = "UPDATE comments SET comment_status='UnApproved' WHERE comment_id=$id";
                                    $result_unapprove = mysqli_query($con, $sql_unapprove);
                                    if (!$sql_unapprove) {
                                        die("failed :" . mysqli_error($con));
                                    }
                                    header("Location: post_comments.php?id=" . $_GET['id'] . "");
                                    break;
                                case 'delete':
                                    $sql = "DELETE FROM comments WHERE comment_id=$id";
                                    $result = mysqli_query($con, $sql);
                                    if (!$result) {
                                        die('failed to delete ' . mysqli_error($con));
                                    }
                                    header("Location: post_comments.php?id=" . $_GET['id'] . "");
                                    break;
                            }
                        }
                    }
                    ?>
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
                                    $sql = "SELECT * FROM comments WHERE comment_post_id=" . mysqli_escape_string($con, $_GET['id']) . " ";
                                    $select_posts = mysqli_query($con, $sql);
                                    $count = mysqli_num_rows($select_posts);
                                    if ($count < 1) {
                                        echo '<tr><td  align="center" colspan="11">This post does not have any comments</td></tr> ';
                                    }
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
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $post_id = $row['post_id'];
                                            $post_title = $row['post_title'];
                                            echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                                        }


                                        echo "<td>$comment_date</td>";
                                        echo "<td><a class='btn btn-primary' href='post_comments.php?approve=$comment_id&id=" . $_GET['id'] . "'>Approve</a></td>";
                                        echo "<td><a class='btn btn-info' href='post_comments.php?unapprove=$comment_id&id=" . $_GET['id'] . "'>UnApprove</a></td>";
                                        echo "<td><a onClick=\"javascript:return confirm('Are You Sure You Want To Delete');\" class='btn btn-danger' href='post_comments.php?del_comment_id=$comment_id&id=" . $_GET['id'] . "'>Delete</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                    <?php
                                    if (isset($_GET['unapprove'])) {
                                        $comment_id = $_GET['unapprove'];

                                        $sql_unapprove = "UPDATE comments SET comment_status='UnApproved' WHERE comment_id=$comment_id";
                                        $result_unapprove = mysqli_query($con, $sql_unapprove);

                                        header("Location: post_comments.php?id=" . $_GET['id'] . " ");
                                    }

                                    if (isset($_GET['approve'])) {
                                        $comment_id = $_GET['approve'];

                                        $sql_approve = "UPDATE comments SET comment_status='Approved' WHERE comment_id=$comment_id";
                                        $result_approve = mysqli_query($con, $sql_approve);

                                        header("Location: post_comments.php?id=" . $_GET['id'] . "  ");
                                    }


                                    if (isset($_GET['del_comment_id'])) {

                                        $delete_id = $_GET['del_comment_id'];
                                        $sql = "DELETE FROM comments WHERE comment_id=$delete_id";
                                        $result = mysqli_query($con, $sql);
                                        if (!$result) {
                                            die('failed to delete ' . mysqli_error($con));
                                        }
                                        header("Location: post_comments.php?id=" . $_GET['id'] . " ");
                                    }
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
<?php include 'includes/admin_footer.php'; ?>