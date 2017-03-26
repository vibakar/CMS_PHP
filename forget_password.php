<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include './admin/functions.php'; ?>

<!-- Navigation -->

<?php include "includes/navigation.php"; ?>
<?php
if (isset($_POST['forget_password'])) {
    $username = escape($_POST['username']);
    $email = escape($_POST['email']);
    $new_password = escape($_POST['new_password']);
    $confirm_password = escape($_POST['confirm_password']);
    $db_email = '';

    $sql = "SELECT * FROM users WHERE user_name='$username'";
    $result = mysqli_query($con, $sql);
    $count = mysqli_num_rows($result);
    if ($count < 1) {
        $username_err = 'Username Not found';
    } else {
        while ($row = mysqli_fetch_array($result)) {
            $db_email = $row['user_email'];
        }
        if ($email != $db_email) {
            $email_err = 'Email Not found';
        }
        if ($new_password != $confirm_password) {
            $password_err = 'New Password And Confirm Password Should Be Same';
        } elseif ($email == $db_email && $new_password == $confirm_password) {
            $confirm_password = password_hash($confirm_password, PASSWORD_BCRYPT, array('cost' => 12));
            $update_sql = "UPDATE users SET user_password='$confirm_password' WHERE user_name='$username' AND user_email='$email'";
            $update_result = mysqli_query($con, $update_sql);
            if (!$update_result) {
                die("Something wrong :" . mysqli_error($con));
            }
            echo '<h3 class="bg-success text-center">Password Reseted</h3>';
            if (isset($username)) {
                $username = '';
            }
            if (isset($email)) {
                $email = '';
            }
            if (isset($new_password)) {
                $new_password = '';
            }
            if (isset($confirm_password)) {
                $confirm_password = '';
            }
        }
    }
}
?>

<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <br>
                        <h1>Reset Password</h1>
                        <form role="form" action="" method="post" id="login-form" autocomplete="off">

                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control"  placeholder="Enter The Registered Username"
                                       autocomplete="on" value="<?php echo isset($username) ? $username : '' ?>" required /><?php echo isset($username_err) ? '<h4 class="text-primary">' . $username_err . '</h4>' : '' ?>

                            </div>


                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter The Registered Email"
                                       autocomplete="on"   value="<?php echo isset($email) ? $email : '' ?>" required />
                                       <?php echo isset($email_err) ? '<h4 class="text-primary">' . $email_err . '</h4>' : '' ?>
                            </div>

                            <div class="form-group">
                                <label for="password" class="sr-only">New Password</label>
                                <input type="password" name="new_password" id="key" class="form-control" placeholder="Enter New Password" 
                                       value="<?php echo isset($new_password) ? $new_password : '' ?>" required />
                                       <?php echo isset($password_err) ? '<h4 class="text-primary">' . $password_err . '</h4>' : '' ?>
                            </div>


                            <div class="form-group">
                                <label for="password" class="sr-only">Confirm Password</label>
                                <input type="password" name="confirm_password" id="key" class="form-control" placeholder="Enter Confirm Password" 
                                       value="<?php echo isset($confirm_password) ? $confirm_password : '' ?>" required />
                                       <?php echo isset($password_err) ? '<h4 class="text-primary">' . $password_err . '</h4>' : '' ?>
                            </div>

                            <input type="submit" name="forget_password" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php"; ?>
