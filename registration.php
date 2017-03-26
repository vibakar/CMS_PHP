<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include './admin/functions.php'; ?>

<!-- Navigation -->

<?php include "includes/navigation.php"; ?>
<?php
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    if (isset($_POST['gender'])) {
        $gender = $_POST['gender'];
    }
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $error = ['username' => '', 'email' => '', 'password ' => '', 'gender' => ''];
    if (user_exists($username)) {
        $error['username'] = 'Username already exists..Try another';
    }
    if (strlen($username) < 4) {
        $error['username'] = 'Username should be more than 4 letters';
    }
    if ($username == '') {
        $error['username'] = 'Username cannot be empty';
    }
    if (!isset($_POST['gender'])) {
        $error['gender'] = 'Select the gender';
    }
    if (email_exists($email)) {
        $error['email'] = 'Email already exists';
    }
    if ($email == '') {
        $error['email'] = 'Email cannot be empty';
    }
    if (empty($password)) {
        $error['password'] = "Password cannot be empty";
    }
    if (strlen($password) < 5) {
        $error['password'] = "Password length Should be more than 5";
    }

    foreach ($error as $key => $value) {
        if (empty($value)) {
            unset($error[$key]);
        }
    }

    if (empty($error)) {
        registerUser($username, $email, $password, $gender);
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
                        <br><br><br>
                        <h1>Register</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">

                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control"  placeholder="Enter Desired Username"
                                       autocomplete="on" value="<?php echo isset($username) ? $username : '' ?>" required /><?php echo isset($error['username']) ? '<h4 class="text-primary">' . $error['username'] . '</h4>' : '' ?>

                            </div>

                            <div class="form-group">
                                Gender
                                <label for="gender" class="radio-inline">
                                    <input type="radio" name="gender" <?php if (isset($gender) && ($gender == "male")) echo "checked"; ?> value="male" 
                                           />Male
                                </label>
                                <label for="gender" class="radio-inline">
                                    <input type="radio" name="gender" <?php if (isset($gender) && ($gender == "female")) echo "checked"; ?> value="female" 
                                           />Female
                                </label>
                                <label for="gender" class="radio-inline">
                                    <input type="radio" name="gender" <?php if (isset($gender) && ($gender == "others")) echo "checked"; ?> value="others" 
                                           required/>Others
                                </label>
                                <br><?php echo isset($error['gender']) ? '<h4 class="text-primary">' . $error['gender'] . '</h4>' : '' ?>
                            </div>

                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com"
                                       autocomplete="on"   value="<?php echo isset($email) ? $email : '' ?>" required />
                                       <?php echo isset($error['email']) ? '<h4 class="text-primary">' . $error['email'] . '</h4>' : '' ?>
                            </div>

                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="Password" 
                                       value="<?php echo isset($password) ? $password : '' ?>" required />
                                       <?php echo isset($error['password']) ? '<h4 class="text-primary">' . $error['password'] . '</h4>' : '' ?>
                            </div>

                            <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php"; ?>
