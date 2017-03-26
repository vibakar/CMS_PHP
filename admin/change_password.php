<?php include '../includes/db.php'; ?>
<?php include 'includes/admin_header.php'; ?>
<?php include 'functions.php'; ?>
<div id="wrapper">
    <?php
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $sql_edit = "SELECT * FROM users WHERE user_name='$username' ";
        $select_users = mysqli_query($con, $sql_edit);
        while ($row = mysqli_fetch_assoc($select_users)) {
            $user_id = $row['user_id'];
            $user_name = $row['user_name'];
            $user_password = $row['user_password'];
            $user_role = $row['user_role'];
        }



        if (isset($_POST['change_password'])) {

            $old_password = escape($_POST['old_password']);
            $new_password = escape($_POST['new_password']);
            $confirm_password = escape($_POST['confirm_password']);

            $old_password_err = '';
            $new_password_err = '';
            $confirm_password_err = '';

            if (password_verify($old_password, $user_password)) {

                if ($new_password == $confirm_password) {
                    $confirm_password = password_hash($confirm_password, PASSWORD_BCRYPT, array('cost' => 12));
                    $sql_update = "UPDATE users SET user_password='$confirm_password' WHERE user_name='$username' ";
                    $result = mysqli_query($con, $sql_update);
                    if (!$result) {
                        die('not updated' . mysqli_error($con));
                    }
                    echo '<h3 class="bg-success">Password Updated</h3>';
                    if (isset($new_password)) {
                        $new_password = '';
                    }
                    if (isset($old_password)) {
                        $old_password = '';
                    }
                    if (isset($confirm_password)) {
                        $confirm_password = '';
                    }
                } else {
                    $new_password_err = "New Password and Confirm Password Does Not Match";
                    $confirm_password_err = "New Password and Confirm Password Does Not Match";
                }
            } else {
                $old_password_err = 'Old Password is wrong';
                
            }
        }
    }
    ?>

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

                    <form action="" method="post">

                        <div class="form-group">
                            <label for="old_password">Old Password</label>
                            <input type="password" name="old_password" class="form-control"
                                   value="<?php echo isset($old_password) ? $old_password : '' ?>" required/><?php echo isset($old_password_err) ? "<h4 class='text-primary'>$old_password_err</h4>" : '' ?>
                        </div>

                        <div class="form-group">
                            <label for="new_Password">New Password</label>
                            <input type="Password" name="new_password" class="form-control"
                                   value="<?php echo isset($new_password) ? $new_password : '' ?>" required/><?php echo isset($new_password_err) ? "<h4 class='text-primary'>$new_password_err</h4>" : '' ?>
                        </div>                      

                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" 
                                   value="<?php echo isset($confirm_password) ? $confirm_password : '' ?>" required/><?php echo isset($confirm_password_err) ? "<h4 class='text-primary'>$confirm_password_err</h4>" : '' ?>
                        </div>

                        <div class="form-group">     
                            <input type="submit" name="change_password" class="btn btn-primary" value="Change Password" />
                        </div>

                    </form>


                </div>
            </div>
        </div>
        <!-- /.row -->

    </div>  
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
<?php include 'includes/admin_footer.php'; ?>
 