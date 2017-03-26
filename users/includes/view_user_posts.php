<?php include '../includes/db.php'; ?>


<form action="" method="post">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>

                <th>Title</th>
                <th>category</th>
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
            $post_by = $_SESSION['username'];
            $sql = "SELECT * FROM posts WHERE post_by='$post_by' ORDER BY post_id DESC";
            $select_posts = mysqli_query($con, $sql);
            $post_count = mysqli_num_rows($select_posts);
            if ($post_count < 1) {
                echo '<tr><td  align="center" colspan="11">You have no posts yet..<a href="user_post.php?user_source=add_posts">Add Posts</a> </td></tr> ';
            }

            while ($row = mysqli_fetch_assoc($select_posts)) {
                $p_id = $row['post_id'];
                $p_cat_id = $row['post_category_id'];
                $p_title = $row['post_title'];
                $p_by = $row['post_by'];
                $p_user = $row['post_user'];
                $p_date = $row['post_date'];
                $p_image = $row['post_image'];
                $p_content = $row['post_content'];
                $p_tags = $row['post_tags'];
                $p_comment_count = $row['post_comment_count'];
                $post_view_count = $row['post_view_count'];
                $p_status = $row['post_status'];

                echo "<tr>";
                ?>
                <?php
                echo "<td>$p_title</td>";

                $sql = "SELECT * FROM categories WHERE cat_id=$p_cat_id";
                $result = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $cat_title = $row['cat_title'];
                    $cat_id = $row['cat_id'];
                }
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

                echo "<td><a href='user_post.php?user_source=user_comments&p_id=$p_id'>$comment_count</a></td>";
                echo "<td>$post_view_count</td>";
                echo "<td>$p_date</td>";
                echo "<td><a class='btn btn-info' href='../view_post.php?p_id=$p_id'>View Posts</a></td>";
                ?>
            <form method="post">
                <input type="hidden" name="delete_id" value="<?php echo $p_id; ?>"/>
                <?php
                echo '<td><input type="submit" onClick=\'javascript:return confirm("Are You Sure You Want To Delete");\' class="btn btn-danger" name="delete" value="Delete"/></td>';
                ?>
            </form>

            <?php
            echo "<td><a class='btn btn-success' href='user_post.php?user_source=edit_posts&edit_id=$p_id'>Edit</a></td>";

            echo "</tr>";
        }
        ?>

        <?php
        if (isset($_POST['delete'])) {
            $delete_id = $_POST['delete_id'];
            $sql = "DELETE FROM posts WHERE post_id=$delete_id";
            $result = mysqli_query($con, $sql);
            header("Location: user_post.php");
        }
        ?>
        </tbody>
    </table>
</form>
