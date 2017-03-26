

<?php ob_start(); ?>

        <?php
        $host = "localhost";
        $user = "root";
        $password = "";
        $database = "cms";
        $con = mysqli_connect($host, $user, $password, $database);
        if (!$con) {
            die("Connecting to Database Failed :");
        }
        ?>
  
