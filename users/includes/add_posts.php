<?php include '../includes/db.php'; ?>
<?php include './user_dashboard.php' ?>
<?php
if (isset($_POST['create_post'])) {
    $p_cat_id = escapes($_POST['post_category_id']);
    $p_title = escapes($_POST['post_title']);
    $p_by = escapes($_SESSION['username']);
    $p_content = escapes($_POST['post_content']);
    $p_tags = escapes($_POST['post_tags']);
    $p_status = 'draft';
    $post_image = $_FILES['post_image']['name'];
    
    if (!empty($post_image)) {
        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];
        move_uploaded_file($post_image_temp, "../images/$post_image");
    } else {
        $post_image = 'dummyicon.png';
    }
    $sql = "INSERT INTO posts (post_category_id,post_title,post_by,post_date,post_image,post_content,post_tags,post_status)"
            . " VALUES( $p_cat_id,'$p_title','$p_by',now(),'$post_image','$p_content','$p_tags','$p_status')";

    $result = mysqli_query($con, $sql);
    confirmQuery($con);
    $p_id = mysqli_insert_id($con); //gives last created id
    echo "<p class='bg-success'>Post Created!! waiting for Admins approval to publish</P>";
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="post_title" class="form-control" placeholder="Enter The Title"  required/>
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
        <label for="image">Post Image</label>
        <input type="file" name="post_image" class="form-control" accept="image/jpeg,image/jpg,image/png" />
    </div>

    <div class="form-group">
        <label for="tags">Post Tags</label>
        <input type="text" name="post_tags" class="form-control" placeholder="Your Name,Title,Category and something related to post" required />
    </div>

    <div class="form-group">
        <label for="content">Post Content</label>
        <textarea rows="10" cols="30" name="post_content" class="form-control" ></textarea>
    </div>

    <div class="form-group">     
        <input type="submit" name="create_post" class="btn btn-primary" value="Add Post" />
    </div>

</form>