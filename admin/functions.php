

<?php

function escape($string) {
    global $con;
    return mysqli_real_escape_string($con, trim($string));
}

function users_online() {
    if (isset($_GET['onlineusers'])) {
        global $con;
        if (!$con) {
            session_start();
            include('../includes/db.php');
            $session = session_id();
            $time = time();
            $time_out_in_seconds = 30;
            $time_out = $time - $time_out_in_seconds;
            $query = "SELECT * FROM users_online WHERE session='$session'";
            $send_query = mysqli_query($con, $query);
            $count = mysqli_num_rows($send_query);

            if ($count == NULL) {
                mysqli_query($con, "INSERT INTO users_online (session,time) VALUES('$session','$time') ");
            } else {
                mysqli_query($con, "UPDATE users_online SET time='$time' WHERE session='$session' ");
            } $users_online_query = mysqli_query($con, "SELECT * FROM users_online WHERE time > '$time_out' ");
            echo $count_user = mysqli_num_rows($users_online_query);
        }
    }//get request
}

users_online();

function confirmQuery($result) {
    global $con;

    if (!$result) {
        die('Query Failed :' . mysqli_error($con));
    }
}

function insert_categories() {
    global $con;
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];

        if ($cat_title == "" || empty($cat_title)) {
            echo '<h5>Please Provide The Title To Add</h5>';
        } else {
            $sql = "INSERT INTO categories(cat_title) VALUES('$cat_title')";
            mysqli_query($con, $sql);
        }
    }
}

function delete_categories() {
    global $con;

    if (isset($_GET['delete_id'])) {
        $del_cat_id = $_GET['delete_id'];
        $sql = "DELETE FROM categories WHERE cat_id=$del_cat_id";
        $del_result = mysqli_query($con, $sql);
        header("Location: categories.php");
    }
}

function recordCount($table) {
    global $con;
    $sql_posts = "SELECT * FROM " . $table;
    $result_posts = mysqli_query($con, $sql_posts);
    $result = mysqli_num_rows($result_posts);
    confirmQuery($con);
    return $result;
}

function checkStatus($table, $column, $status) {
    global $con;
    $sql = "SELECT * FROM $table WHERE $column='$status'";
    $result = mysqli_query($con, $sql);
    return mysqli_num_rows($result);
}

function checkUserrole($table, $column, $status) {
    global $con;
    $sql = "SELECT * FROM $table WHERE $column='$status'";
    $result = mysqli_query($con, $sql);
    return mysqli_num_rows($result);
}

function is_admin($username) {
    global $con;
    $sql = "SELECT user_role FROM users WHERE user_name='$username'";
    $result = mysqli_query($con, $sql);
    confirmQuery($result);
    $row = mysqli_fetch_array($result);
    if ($row['user_role'] == "Admin") {
        return true;
    } else {
        return false;
    }
}

function user_exists($username) {
    global $con;
    $sql = "SELECT user_name FROM users WHERE user_name='$username'";
    $result = mysqli_query($con, $sql);
    confirmQuery($result);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}

function email_exists($email) {
    global $con;
    $sql = "SELECT user_email FROM users WHERE user_email='$email'";
    $result = mysqli_query($con, $sql);
    confirmQuery($result);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}

function redirect($location) {
    header("Location:" . $location);
}

function registerUser($username, $email, $password, $gender) {
    global $con;
    $username = mysqli_real_escape_string($con, $username);
    $email = mysqli_real_escape_string($con, $email);
    $password = mysqli_real_escape_string($con, $password);
    $gender = mysqli_real_escape_string($con, $gender);
    if ($gender == "male") {
        $user_image = "men.jpg";
    } elseif ($gender == "female") {
        $user_image = "women.jpg";
    } else {
        $user_image = "dummy.jpg";
    }
    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

    $sql_insert = "INSERT INTO users(user_name,user_password,user_email,user_role,user_image,user_gender)"
            . " VALUES('$username','$password','$email','Subscriber','$user_image','$gender')";

    $result = mysqli_query($con, $sql_insert);
    confirmQuery($con);
    redirect("/cms");
}

function loginUser($username, $password) {
    global $con;

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $username = mysqli_real_escape_string($con, $username);
    $password = mysqli_real_escape_string($con, $password);

    $sql = "SELECT * FROM users WHERE user_name='$username'";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        die('Query Failed :' . mysqli_error($con));
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $db_user_id = $row['user_id'];
        $db_user_name = $row['user_name'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];
    }

    if (password_verify($password, $db_user_password) && ($db_user_role == 'Admin')) {
        $_SESSION['username'] = $db_user_name;
        $_SESSION['firstname'] = $db_user_firstname;
        $_SESSION['lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;
        $_SESSION['login_error'] = null;
        redirect("/cms/admin");
    } elseif (password_verify($password, $db_user_password) && ($db_user_role == 'Subscriber')) {
        $_SESSION['username'] = $db_user_name;
        $_SESSION['firstname'] = $db_user_firstname;
        $_SESSION['lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;
        $_SESSION['login_error'] = null;
        redirect("/cms/users");
    } else {
        $_SESSION['login_error'] = '<p class="text-center bg-danger">Username or Password Incorrect</p>';
        redirect("/cms");
    }
}
?>