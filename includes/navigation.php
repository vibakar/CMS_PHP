
<?php include 'db.php'; ?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Home</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                
                $sql = "SELECT * FROM categories";
                $result = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $category_id = $row['cat_id'];
                    $categories = $row['cat_title'];

                    $category_class = '';
                    $registration_class = '';
                    $contact_class = '';
                    $registration = "registration.php";
                    $contact = "contact.php";
                    $home = "index.php";
                    $pagename = basename($_SERVER['PHP_SELF']);

                    if (isset($_GET['category']) && ($_GET['category']) == $category_id) {
                        $category_class = 'active';
                    } elseif ($pagename == $registration) {
                        $registration_class = 'active';
                    } elseif ($pagename == $contact) {
                        $contact_class = 'active';
                    }

                    echo "<li class='$category_class'><a href='category.php?category=$category_id'>$categories</a></li>";
                }
                ?>


                <?php
                if (isset($_SESSION['user_role'])) {

                    if ($_SESSION['user_role'] == 'Admin') {
                        echo "<li><a href='admin'>Admin</a></li>";
                    }
                }
                ?>


                <li class='<?php echo $registration_class; ?>'><a href="./registration.php">Registration</a></li>
                <li class='<?php echo $contact_class; ?>'><a href="./contact.php">Contact</a></li>

                <?php
                if (isset($_SESSION['user_role'])) {

                    if ($_SESSION['user_role'] == 'Subscriber') {
                        echo "<li><a href='../cms/users/index.php'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>My Account</strong></a></li>";
                    }
                }
                ?>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
