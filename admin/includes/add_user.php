<?php include '../includes/db.php'; ?>
<?php
if (isset($_POST['create_user'])) {
    $users_firstname = escape($_POST['users_firstname']);
    $users_lastname = escape($_POST['users_lastname']);
    $users_role = escape($_POST['users_role']);
    $users_email = escape($_POST['users_email']);
    $users_name = escape($_POST['users_name']);
    $user_gender = escape($_POST['user_gender']);
    $user_password = escape($_POST['users_password']);
    $user_nation = escape($_POST['user_nation']);
    $user_city = escape($_POST['user_city']);
    $user_mobile = escape($_POST['user_mobile']);
    $users_image = $_FILES['users_image']['name'];

    if (empty($users_image)) {
        if ($user_gender == 'male') {
            $users_image = 'men.jpg';
        } elseif ($user_gender == 'female') {
            $users_image = 'women.jpg';
        } elseif ($user_gender == 'others') {
            $user_image = 'dummy.jpg';
        } else {

            $users_image_temp = $_FILES['users_image']['tmp_name'];

            move_uploaded_file($users_image_temp, "../images/$users_image");
        }
    }
    $password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));

    $sql = "INSERT INTO users(user_name,user_password,user_firstname,user_lastname,user_gender,user_email,user_image,user_role,user_nation,user_city,user_mobile)"
            . " VALUES('$users_name','$password','$users_firstname','$users_lastname','$user_gender','$users_email','$users_image','$users_role',"
            . "'$user_nation','$user_city','$user_mobile')";

    $result = mysqli_query($con, $sql);
    confirmQuery($result);
    echo 'User Created ' . ' ' . '<a href="users.php">View Users</a>';
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" name="users_firstname" class="form-control" required/>
    </div>

    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" name="users_lastname" class="form-control" required/>
    </div>

    <div class="form-group">
        <label for="user_name">User Name</label>
        <input type="text" name="users_name" class="form-control" required/>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="users_password" class="form-control" required/>
    </div>

    <div class="form-group">
        <label for="gender">Gender</label><br>
        <input type="radio" name="user_gender" <?php if (isset($user_gender) && ($user_gender == "male")) echo "checked"; ?> value="male" 
               />Male
        <input type="radio" name="user_gender" <?php if (isset($user_gender) && ($user_gender == "female")) echo "checked"; ?> value="female" 
               />Female
        <input type="radio" name="user_gender" <?php if (isset($user_gender) && ($user_gender == "others")) echo "checked"; ?> value="others" 
               required/>Others
    </div>

    <div class="form-group">
        <label for="user_role">Role</label>
        <select name="users_role" class="form-control">

            <option value='Subscriber'>Select Options</option>
            <option value='Admin'>Admin</option>
            <option value='Subscriber'>Subscriber</option>

        </select>
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" name="users_email" class="form-control" />
    </div>

    <div class="form-group">
        <label for="user_image">Image</label>
        <input type="file" name="users_image" class="form-control" />
    </div>

    <div class="form-group">
        <label for="nation">Nation</label><br>
        <input type="text" name="user_nation"  pattern="[A-Za-z]{3,20}" title="Enter only Letters min 3 & max 20" class="form-control" />
    </div>

    <div class="form-group">
        <label for="city">City</label><br>
        <input type="text" name="user_city" pattern="[A-Za-z]{3,20}" title="Enter only Letters min 3 & max 20" class="form-control"  />
    </div>

    <div class="form-group">
        <label for="phone">Mobile</label><br>
        <input type="text" name="user_mobile" pattern="[0-9]{10}" title="Enter only Numbers in 10 digits" class="form-control" />
    </div>

    <div class="form-group">     
        <input type="submit" name="create_user" class="btn btn-primary" value="Add User" />
    </div>

</form>