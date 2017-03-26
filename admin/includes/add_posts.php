<?php include '../includes/db.php'; ?>

<?php
if (isset($_POST['create_post'])) {
    $p_cat_id = escape($_POST['post_category_id']);
    $p_title = escape($_POST['post_title']);
    $p_by = escape($_SESSION['username']);
    $p_content = escape($_POST['post_content']);
    $p_tags = escape($_POST['post_tags']);
    $p_status = escape($_POST['post_status']);
    $post_image = $_FILES['post_image']['name'];

    if (empty($post_image)) {
        $post_image = 'dummyicon.png';
    } else {

        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];
        move_uploaded_file($post_image_temp, "../images/$post_image");
    }

    $sql = "INSERT INTO posts (post_category_id,post_title,post_by,post_date,post_image,post_content,post_tags,post_status)"
            . " VALUES( $p_cat_id,'$p_title','$p_by',now(),'$post_image','$p_content','$p_tags','$p_status')";

    $result = mysqli_query($con, $sql);
    confirmQuery($result);
    $p_id = mysqli_insert_id($con); //gives last created id
    echo "<p class='bg-success'>Post Created <a href='../view_post.php?p_id=$p_id'>View Post</a> or <a href='posts.php'>Edit More Posts</a> </p>";
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="post_title" class="form-control" placeholder="Enter The Title" required />
    </div>

    <div class="form-group">
        <label for="title">Post Category</label><br>
        <select class="form-control" name="post_category_id" >
            <option value='29'>Select Options</option>
            <?php
            $sql_category = "SELECT * FROM categories";
            $result = mysqli_query($con, $sql_category);
            while ($row = mysqli_fetch_assoc($result)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                echo "<option value='$cat_id'>$cat_title</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="status">Post Status</label><br>
        <select class="form-control" name="post_status">
            <option value="draft">Select Options</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
        </select>

    </div>

    <div class="form-group">
        <label for="image">Post Image</label>
        <input type="file" name="post_image" class="form-control" accept="image/jpeg,image/jpg,image/png"/>
    </div>

    <div class="form-group">
        <label for="tage">Post Tags</label>
        <input type="text" name="post_tags" class="form-control" placeholder="Your Name,Title,Category and something related to post" required/>
    </div>

    <div class="form-group">
        <label for="content">Post Content</label>
        <textarea rows="10" cols="30" name="post_content" class="form-control" ></textarea>
    </div>

    <div class="form-group">     
        <input type="submit" name="create_post" class="btn btn-primary" value="Publish Post" />
    </div>

</form>