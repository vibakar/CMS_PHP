

<form action="" method="post">
    <div class="form-group">                                                         

        <?php
        //update category
        if (isset($_GET['update_id'])) {
            $update_cat_id = $_GET['update_id'];
            $update_cat_title = $_GET['update_title'];
        }

        if (isset($_POST['update'])) {
            $form_cat_title = escape($_POST['cat_title']);
            $sql = "UPDATE categories SET cat_title='$form_cat_title' WHERE cat_id=$update_cat_id; ";
            $update_result = mysqli_query($con, $sql);
            
        }
        ?>
        <label for="cat-title">Edit Category</label>
        <input type="text" name="cat_title" class="form-control" value="<?php
        if (isset($update_cat_title)) {
            echo $update_cat_title;
        }
        ?>" required/>                              
    </div>
    <div class="form-group">
        <input type="submit" name="update" value="Update Category" class="btn btn-primary" />                              
    </div>

</form>