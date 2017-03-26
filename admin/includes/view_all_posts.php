<?php include '../includes/db.php'; ?>
<?php ob_start(); ?>
<?php include 'delete_modal.php'; ?>
<?php
if (isset($_POST['checkBoxArray'])) {

    foreach ($_POST['checkBoxArray'] as $checkBoxValue) {

        $bulk_options = $_POST['bulk_options'];
        switch ($bulk_options) {
            case 'published':
                $sql_publish = "UPDATE posts SET post_status='published' WHERE post_id=$checkBoxValue";
                mysqli_query($con, $sql_publish);
                break;
            case 'draft':
                $sql_publish = "UPDATE posts SET post_status='draft' WHERE post_id=$checkBoxValue";
                mysqli_query($con, $sql_publish);
                break;
            case 'delete':
                $sql_publish = "DELETE FROM posts WHERE post_id=$checkBoxValue";
                mysqli_query($con, $sql_publish);
                break;
            case 'clone':
                $sql_select = "SELECT * FROM posts WHERE post_id='$checkBoxValue' ";
                $select_result = mysqli_query($con, $sql_select);
                while ($row = mysqli_fetch_assoc($select_result)) {
                    $p_title = $row['post_title'];
                    $p_cat_id = $row['post_category_id'];
                    $p_date = $row['post_date'];
                    $p_author = $row['post_author'];
                    $p_user = $row['post_user'];
                    $p_status = $row['post_status'];
                    $p_image = $row['post_image'];
                    $p_content = $row['post_content'];
                    $p_tags = $row['post_tags'];
                }


                $sql = "INSERT INTO posts (post_category_id,post_title,post_user,post_date,post_image,post_content,post_tags,post_status)"
                        . " VALUES( $p_cat_id,'$p_title','$p_user',now(),'$p_image','$p_content','$p_tags','$p_status')";

                $result = mysqli_query($con, $sql);
                confirmQuery($result);
        }
    }
}
?>
<form action="" method="post">
    <table class="table table-bordered table-hover">
        <div id="bulkOptionsContainer" class="col-xs-4">
            <select id="bulk" class="form-control" name="bulk_options">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>          
        </div>
        <div class="col-xs-4">      
            <input type="submit" name="submit" class="btn btn-success" value="Apply" />
            <a class="btn btn-primary" href="posts.php?source=add_posts">Add New</a>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th><input id="selectAllBoxes" type="checkbox"></th>
                    <th>ID</th>
                    <th>By</th>
                    <th>Title</th>
                    <th>Category Title</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Tags</th>
                    <th>Comments</th>
                    <th>post Views</th>
                    <th>Date</th>
                    <th>View Posts</th>
                    <th>Delete</th>
                    <th>Edit</th>

                </tr>                        
            </thead>
            <tbody>
                <?php
//            $sql = "SELECT * FROM posts ORDER BY post_id DESC";
                $sql = "SELECT posts.post_id,posts.post_category_id,posts.post_title,posts.post_by,posts.post_user, ";
                $sql.= "posts.post_date,posts.post_image,posts.post_content,posts.post_tags,posts.post_comment_count,posts.post_view_count,posts.post_status, ";
                $sql.= "categories.cat_id,categories.cat_title FROM posts LEFT JOIN categories ON posts.post_category_id=categories.cat_id ";
                $sql.= "ORDER BY posts.post_id DESC ";
                $select_posts = mysqli_query($con, $sql);
                $count_posts = mysqli_num_rows($select_posts);
                if ($count_posts < 1) {
                    echo '<tr><td  align="center" colspan="14">No Posts Available <a href="posts.php?source=add_posts">Add Posts</a></td></tr> ';
                }
                while ($rows = mysqli_fetch_array($select_posts)) {
                    $p_id = $rows['post_id'];
                    $p_cat_id = $rows['post_category_id'];
                    $p_title = $rows['post_title'];
                    $p_by = $rows['post_by'];
                    $p_user = $rows['post_user'];
                    $p_date = $rows['post_date'];
                    $p_image = $rows['post_image'];
                    $p_content = $rows['post_content'];
                    $p_tags = $rows['post_tags'];
                    $p_comment_count = $rows['post_comment_count'];
                    $post_view_count = $rows['post_view_count'];
                    $p_status = $rows['post_status'];
                    $cat_title = $rows['cat_title'];
                    $cat_id = $rows['cat_id'];
                    echo "<tr>";
                    ?>
                <td><input class='checkboxes' name='checkBoxArray[]' type='checkbox' value='<?php echo $p_id; ?>'/></td>
                    <?php
                    echo "<td> $p_id </td>";
                    echo "<td>$p_by</td>";
                    echo "<td>$p_title</td>";
                    if (empty($cat_title)) {
                        echo "<td>Not Available</td>";
                    } else {
                        echo "<td>$cat_title</td>";
                    }
                    echo "<td>$p_status</td>";
                    echo "<td><img src='../images/$p_image' width='100' alt='loading image'/></td>";
                    echo "<td>$p_tags</td>";

                    $sql_comment = "SELECT * FROM comments WHERE comment_post_id= $p_id ";
                    $result_comment = mysqli_query($con, $sql_comment);
                    $row = mysqli_fetch_array($result_comment);
                    $comment_id = $row['comment_id'];
                    $comment_count = mysqli_num_rows($result_comment);

                    echo "<td><a href='post_comments.php?id=$p_id'>$comment_count</a></td>";
                    echo "<td><a href='posts.php?reset=$p_id'>$post_view_count</a></td>";
                    echo "<td>$p_date</td>";
                    echo "<td><a class='btn btn-info' href='../view_post.php?p_id=$p_id'>View Posts</td>";
                    ?>
                <form method="post">
                    <input type="hidden" name="delete_id" value="<?php echo $p_id; ?>"/>
                    <?php
                    echo '<td><input type="submit" onClick=\'javascript:return confirm("Are You Sure You Want To Delete");\' class="btn btn-danger" name="delete" value="Delete"/></td>';
                    ?>
                </form>
                <?php
                echo "<td><a class='btn btn-success' href='posts.php?source=edit_posts&edit_id=$p_id'>Edit</a></td>";
                echo "</tr>";
            }
            ?>
            <?php
            if (isset($_POST['delete'])) {
                $delete_id = $_POST['delete_id'];
                $sql = "DELETE FROM posts WHERE post_id=$delete_id";
                $result = mysqli_query($con, $sql);
                header("Location: posts.php");
            }

            if (isset($_GET['reset'])) {
                $reset_id = $_GET['reset'];
                $sql = "UPDATE posts SET post_view_count=0 WHERE post_id=" . mysqli_real_escape_string($con, $reset_id) . " ";
                $result = mysqli_query($con, $sql);
                header("Location: posts.php");
            }
            ?>
            </tbody>
        </table>
</form>
<script>
    $(document).ready(function () {
        $(".delete_link").on('click', function () {
            var id = $(this).attr("rel");
            var delete_url = "posts.php?delete_id=" + id + " ";
            $(".modal_delete_link").attr("href", delete_url);
            $("#myModal").modal('show');

        });
    });

</script>
