<?php include '../includes/db.php'; ?>
<?php ob_start(); ?>
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>User Name</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Image</th>
            <th>Role</th>
            <th>Admin</th>
            <th>Subscriber</th>
            <th>Delete</th>
            <th>Edit</th>
        </tr>                        
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM users";
        $select_users = mysqli_query($con, $sql);
        $count_users = mysqli_num_rows($select_users);
        if ($count_users < 1) {
            echo '<tr><td  align="center" colspan="11">No Users Available</td></tr> ';
        }
        while ($row = mysqli_fetch_assoc($select_users)) {
            $user_id = $row['user_id'];
            $user_name = $row['user_name'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];


            echo "<tr>";
            echo "<td>$user_id</td>";
            echo "<td>$user_name</td>";
            echo "<td>$user_firstname</td>";
            echo "<td>$user_lastname</td>";
            echo "<td>$user_email</td>";
            echo "<td><img src='../images/$user_image' width='100' height='100' alt='Loading image'></td>";
            echo "<td>$user_role</td>";
            echo "<td><a class='btn btn-info'  href='users.php?change_to_admin=$user_id'>Admin</a></td>";
            echo "<td><a class='btn btn-info'  href='users.php?change_to_subscriber=$user_id'>Subscriber</a></td>";
            echo "<td><a class='btn btn-danger' onClick=\"javascript:return confirm('Are You Sure You Want To Delete');\" href='users.php?del_user_id=$user_id'>Delete</a></td>";
            echo "<td><a class='btn btn-success' href='users.php?source=edit_user&edit_user_id=$user_id'>Edit</a></td>";
        }
        ?>
        <?php
        if (isset($_GET['change_to_admin'])) {
            $user_id = $_GET['change_to_admin'];

            $sql_change_to_admin = "UPDATE users SET user_role='Admin' WHERE user_id=$user_id";
            $result_change_to_admin = mysqli_query($con, $sql_change_to_admin);
            if (!$result_change_to_admin) {
                die("failed :" . mysqli_error($con));
            }
            header("Location: users.php");
        }

        if (isset($_GET['change_to_subscriber'])) {
            $user_id = $_GET['change_to_subscriber'];

            $sql_change_to_subscriber = "UPDATE users SET user_role='Subscriber' WHERE user_id=$user_id";
            $result_change_to_subscriber = mysqli_query($con, $sql_change_to_subscriber);
            if (!$result_change_to_subscriber) {
                die("failed :" . mysqli_error($con));
            }
            header("Location: users.php");
        }

        if (isset($_GET['del_user_id'])) {
            if (isset($_SESSION['user_role'])) {
                if ($_SESSION['user_role'] == "Admin") {

                    $delete_id = $_GET['del_user_id'];
                    $sql = "DELETE FROM users WHERE user_id=$delete_id";
                    $result = mysqli_query($con, $sql);
                    if (!$result) {
                        die('failed to delete ' . mysqli_error($con));
                    }
                    header("Location: users.php");
                }
            }
        }
        ?>
    </tbody>
</table>
