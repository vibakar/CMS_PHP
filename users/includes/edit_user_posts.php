<?php include '../includes/db.php'; ?>
<?php include './user_dashboard.php'; ?>
<?php
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
}
$sql_edit = "SELECT * FROM posts WHERE post_id=$edit_id";
$select_posts = mysqli_query($con, $sql_edit);
while ($row = mysqli_fetch_assoc($select_posts)) {
    $p_id = $row['post_id'];
    $p_cat_id = $row['post_category_id'];
    $p_title = $row['post_title'];
    $p_by = $row['post_by'];
    $p_date = $row['post_date'];
    $p_image = $row['post_image'];
    $p_content = $row['post_content'];
    $p_tags = $row['post_tags'];
    $p_comment_count = $row['post_comment_count'];
    $p_status = $row['post_status'];
}

if (isset($_POST['update_posts'])) {

    $post_category_id = escapes($_POST['post_category']);
    $post_title = escapes($_POST['post_title']);

    $post_img = $_FILES['post_img']['name'];
    $post_img_temp = $_FILES['post_img']['tmp_name'];

    $post_content = escapes($_POST['post_content']);
    $post_tags = escapes($_POST['post_tags']);
    $post_status = 'draft';
    move_uploaded_file($post_img_temp, "../images/$post_img");

    if (empty($post_img)) {
        $sql_img_query = "SELECT * FROM posts WHERE post_id=$edit_id";

        $result_img = mysqli_query($con, $sql_img_query);
        while ($row = mysqli_fetch_assoc($result_img)) {
            $post_img = $row['post_image'];
        }
    }
    $sql_update = "UPDATE posts SET post_category_id='$post_category_id',post_title='$post_title',post_by='$p_by',"
            . "post_date=now(),post_image='$post_img',post_content='$post_content',post_tags='$post_tags',"
            . "post_status='$post_status' WHERE post_id=$p_id ";
    $result = mysqli_query($con, $sql_update);
    if (!$result) {
        die('not updated' . mysqli_error($con));
    }
    echo "<p class='bg-success'>Post updated waiting for admins approval <a href='./user_post.php'>Edit More Posts</a> </p>";
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" name="post_title" value="<?php echo $p_title; ?>" class="form-control" />
    </div>

    <div class="form-group">
        <label for="title">Post Category</label><br>
        <select class="form-control" name="post_category" >   

            <?php
            $sql_category = "SELECT * FROM categories";
            $result = mysqli_query($con, $sql_category);
            while ($row = mysqli_fetch_assoc($result)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                if ($cat_id == $p_cat_id) {
                    echo "<option selected value='$cat_id'>$cat_title</option>";
                } else {
                    echo "<option value='$cat_id'>$cat_title</option>";
                }
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="image">Post Image</label><br>
        <img src="../images/<?php echo $p_image; ?>" width="100" alt="loading image" />
        <input type="file" name="post_img" class="form-control" accept="image/jpeg,image/jpg,image/png"/>
    </div>

    <div class="form-group">
        <label for="tage">Post Tags</label>
        <input type="text" name="post_tags" value="<?php echo $p_tags; ?>" class="form-control" />
    </div>

    <div class="form-group">
        <label for="content">Post Content</label>
        <textarea rows="10" cols="30" name="post_content" class="form-control" ><?php echo str_replace('\r\n', '</br>', $p_content); ?>
            
        </textarea>
    </div>

    <div class="form-group">     
        <input type="submit" name="update_posts" class="btn btn-primary" value="Update Post" />
    </div>

</form>