<?php include '../includes/db.php'; ?>
<?php ob_start(); ?>


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
                header("Location: comments.php");
                break;
            case 'unapprove':
                $sql_unapprove = "UPDATE comments SET comment_status='UnApproved' WHERE comment_id=$id";
                $result_unapprove = mysqli_query($con, $sql_unapprove);
                if (!$sql_unapprove) {
                    die("failed :" . mysqli_error($con));
                }
                header("Location: comments.php");
                break;
            case 'delete':
                $sql = "DELETE FROM comments WHERE comment_id=$id";
                $result = mysqli_query($con, $sql);
                if (!$result) {
                    die('failed to delete ' . mysqli_error($con));
                }
                header("Location: comments.php");
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
                $sql = "SELECT * FROM comments";
                $select_posts = mysqli_query($con, $sql);
                $comment_count = mysqli_num_rows($select_posts);
                if ($comment_count < 1) {
                    echo '<tr><td  align="center" colspan="11">You have no comments yet </td></tr> ';
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
                    $count = mysqli_num_rows($result);
                    if ($count < 1) {
                        echo "<td>Post Not available</td>";
                    } else {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];

                            echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                        }
                    }

                    echo "<td>$comment_date</td>";
                    echo "<td><a class='btn btn-primary' href='comments.php?approve=$comment_id'>Approve</a></td>";
                    echo "<td><a class='btn btn-info' href='comments.php?unapprove=$comment_id'>UnApprove</a></td>";
                    echo "<td><a class='btn btn-danger' onClick=\"javascript:return confirm('Are You Sure You Want To Delete');\" href='comments.php?del_comment_id=$comment_id'>Delete</a></td>";
                    echo "</tr>";
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
                    header("Location: comments.php");
                }

                if (isset($_GET['approve'])) {
                    $comment_id = $_GET['approve'];

                    $sql_approve = "UPDATE comments SET comment_status='Approved' WHERE comment_id=$comment_id";
                    $result_approve = mysqli_query($con, $sql_approve);
                    if (!$sql_approve) {
                        die("failed :" . mysqli_error($con));
                    }
                    header("Location: comments.php");
                }


                if (isset($_GET['del_comment_id'])) {

                    $delete_id = $_GET['del_comment_id'];
                    $sql = "DELETE FROM comments WHERE comment_id=$delete_id";
                    $result = mysqli_query($con, $sql);
                    if (!$result) {
                        die('failed to delete ' . mysqli_error($con));
                    }
                    header("Location: comments.php");
                }
                ?>
            </tbody>
        </table>
</form>