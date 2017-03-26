<?php include '../includes/db.php'; ?>
<?php include './includes/user_header.php'; ?>
<?php include 'user_dashboard.php'; ?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>User Page</title>

        <!-- Bootstrap Core CSS -->
        <link href="../admin/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../admin/css/sb-admin.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>
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
                    $user_firstname = $row['user_firstname'];
                    $user_gender = $row['user_gender'];
                    $user_email = $row['user_email'];
                    $user_lastname = $row['user_lastname'];
                    $user_nation = $row['user_nation'];
                    $user_city = $row['user_city'];
                    $user_mobile = $row['user_mobile'];
                    $user_image = $row['user_image'];
                    $user_role = $row['user_role'];
                }

                if (isset($_POST['update_user'])) {

                    $user_name = escapes($_POST['user_name']);
                    $user_firstname = escapes($_POST['user_firstname']);
                    $user_email = escapes($_POST['user_email']);
                    $user_lastname = escapes($_POST['user_lastname']);
                    $user_gender = escapes($_POST['user_gender']);
                    $user_nation = escapes($_POST['user_nation']);
                    $user_city = escapes($_POST['user_city']);
                    $user_mobile = escapes($_POST['user_mobile']);
                    $user_image = $_FILES['user_image']['name'];
                    $user_image_temp = $_FILES['user_image']['tmp_name'];
                    $user_role = escapes($_POST['users_role']);


                    move_uploaded_file($user_image_temp, "../images/$user_image");

                    if (empty($user_image)) {
                        $sql_img_query = "SELECT * FROM users WHERE user_name='$username'";
                        $result_img = mysqli_query($con, $sql_img_query);
                        while ($row = mysqli_fetch_assoc($result_img)) {
                            $user_image = $row['user_image'];
                        }
                    }
                    $sql_update = "UPDATE users SET user_name='$user_name',user_gender='$user_gender',"
                            . "user_firstname='$user_firstname',user_lastname='$user_lastname',user_gender='$user_gender',user_email='$user_email',user_image='$user_image',"
                            . "user_role='$user_role',user_nation='$user_nation',user_city='$user_city',user_mobile='$user_mobile' WHERE user_name='$username' ";
                    $result = mysqli_query($con, $sql_update);
                    if (!$result) {
                        die('not updated' . mysqli_error($con));
                    }
                    echo "<h4 class='bg-success'>Profile Updated</h4>";
                }
            }
            ?>

            <!-- Navigation -->
            <?php include 'includes/user_navigation.php'; ?>

            <div id="page-wrapper">

                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">
                                Welcome <?php echo $_SESSION['user_role']; ?>
                                <small><?php echo $_SESSION['username']; ?></small>
                            </h1>

                            <form action="" method="post" enctype="multipart/form-data">                             
                                <div class="form-group">
                                    <label for="username">User Name</label>
                                    <input type="text" name="user_name" value="<?php echo $user_name; ?>" class="form-control" readonly="readonly"/>
                                </div>

                                <div class="form-group">
                                    <label for="user_image">Profile Picture</label><br>
                                    <img src="../images/<?php echo $user_image; ?>" width="100" height="100" alt="loading image" />
                                    <input type="file" name="user_image" accept="image/jpeg,image/jpg,image/png"/>
                                </div>

                                <div class="form-group">
                                    <label for="firstname">FirstName</label>
                                    <input type="text" name="user_firstname" value="<?php echo $user_firstname; ?>" pattern="[A-Za-z ]{3,20}" title="Enter only Letters min 3 & max 20" class="form-control" required/>
                                </div>

                                <div class="form-group">
                                    <label for="lastname">LastName</label><br>
                                    <input type="text" name="user_lastname" value="<?php echo $user_lastname; ?>" pattern="[A-Za-z. ]{1,20}" title="Enter only Letters min 1"  class="form-control" required />
                                </div>

                                <div class="form-group">
                                    <label for="gender">Gender</label><br>
                                    <input type="radio" name="user_gender" <?php if (isset($user_gender) && ($user_gender == "male")) echo "checked"; ?> value="male" 
                                           />Male
                                    <input type="radio" name="user_gender" <?php if (isset($user_gender) && ($user_gender == "female")) echo "checked"; ?> value="female" 
                                           />Female
                                    <input type="radio" name="user_gender" <?php if (isset($user_gender) && ($user_gender == "others")) echo "checked"; ?> value="others" 
                                           />Others
                                </div>

                                <input type="hidden" name="users_role" value="<?php echo $user_role; ?>" class="form-control"  />


                                <div class="form-group">
                                    <label for="email">Email</label><br>
                                    <input type="email" name="user_email" value="<?php echo $user_email; ?>" class="form-control" required/>
                                </div>                            

                                <div class="form-group">
                                    <label for="nation">Nation</label><br>
                                    <input type="text" name="user_nation" value="<?php echo $user_nation; ?>" pattern="[A-Za-z]{2,15}" title="Enter only Letters min 2 & max 15" class="form-control" required/>
                                </div>

                                <div class="form-group">
                                    <label for="city">City</label><br>
                                    <input type="text" name="user_city" value="<?php echo $user_city; ?>" pattern="[A-Za-z]{2,15}" title="Enter only Letters min 2 & max 15" class="form-control" required />
                                </div>

                                <div class="form-group">
                                    <label for="phone">Mobile</label><br>
                                    <input type="text" name="user_mobile" value="<?php echo $user_mobile; ?>" pattern="[0-9]{10}" title="Enter only Numbers in 10 digits" class="form-control" required/>
                                </div>
                                <div class="form-group">     
                                    <input type="submit" name="update_user" class="btn btn-primary" value="Update Profile" />
                                </div>

                            </form>


                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="../admin/js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../admin/js/bootstrap.min.js"></script>

    </body>

</html>

<?php include 'includes/user_footer.php'; ?>