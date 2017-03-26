<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">Admin</a>
    </div>
    <!-- Top Menu Items -->

    <ul class="nav navbar-right top-nav">   

<!--       <li><a href="">Users Online:<?php //users_online();           ?></a></li>-->
        <!--        <li><a href="">Users Online:<div class="usersonline"></div></a></li>-->
        <li><a href="../index.php">Blog Home</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user "></i><?php
                if (isset($_SESSION['username'])) {
                    echo $_SESSION['username'];
                }
                ?> <b class="caret"></b></a>

            <ul class="dropdown-menu">
                <li>
                    <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <!--                <li>
                                    <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                                </li>-->
                <li class="divider"></li>
                <li>
                    <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <?php
    $pagename = basename($_SERVER['PHP_SELF']);

    $dashboard = 'index.php';
    $view_all_posts = 'posts.php';
    $add_posts = 'posts.php?source=add_posts';
    $categories = 'categories.php';
    $comments = 'comments.php';
    $profile = 'profile.php';
    $password = 'change_password.php';
    $view_all_user = 'users.php';
    $add_user = 'users.php?source=add_user';
    $dashboard_class = '';
    $category_class = '';
    $post_class = '';
    $comments_class = '';
    $profile_class = '';
    $password_class = '';
    $users_class = '';

    if ($pagename == $dashboard) {
        $dashboard_class = 'active';
    } elseif ($pagename == $categories) {
        $category_class = 'active';
    } elseif ($pagename == $comments) {
        $comments_class = 'active';
    } elseif ($pagename == $profile) {
        $profile_class = 'active';
    } elseif ($pagename == $password) {
        $password_class = 'active';
    } elseif ($pagename == $view_all_posts || $add_posts) {
        $post_class = 'active';
    } elseif ($pagename == $view_all_user || $add_user) {
        $users_class = 'active';
    }
    ?>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li class="<?php echo $dashboard_class; ?>">
                <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>

            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="posts_dropdown" class="collapse">
                    <li>
                        <a href="posts.php">View All Posts</a>
                    </li>
                    <li>
                        <a href="posts.php?source=add_posts">Add Posts</a>
                    </li>
                </ul>
            </li>

            <li class="<?php echo $category_class; ?>">
                <a href="categories.php"><i class="fa fa-fw fa-desktop"></i> Categories </a>
            </li>

            <li class="<?php echo $comments_class; ?>">
                <a href="comments.php"><i class="fa fa-fw fa-comment"></i> Comments</a>
            </li>

            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo" class="collapse">
                    <li>
                        <a href="users.php">View All Users</a>
                    </li>
                    <li>
                        <a href="users.php?source=add_user">Add Users</a>
                    </li>
                </ul>
            </li>
            <li class="<?php echo $profile_class; ?>">
                <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
            </li>
            <li class="<?php echo $password_class; ?>">
                <a href="change_password.php"><i class="fa fa-fw fa-lock"></i>Change Password</a>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>