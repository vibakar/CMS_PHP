<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="../index.php">Blog Home</a>

    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['username']; ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="./user_profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <!--                <li>
                                    <a href=""><i class="fa fa-fw fa-gear"></i> Settings</a>
                                </li>-->

                <li>
                    <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li>
                <a href="./index.php"><i class="fa fa-fw fa-home"></i> Start</a>
            </li>
            <li>
                <a href="./user_post.php?user_source=add_posts"><i class="fa fa-fw fa-upload"></i> Add Posts</a>
            </li>          
            <li>
                <a href="./user_post.php"><i class="fa fa-file-text"></i> My Posts</a>
            </li>
            <li>
                <a href="./user_comments.php"><i class="fa fa-fw fa-comment"></i> Comments</a>
            </li>
            <li>
                <a href="./stats.php"><i class="fa fa-fw fa-bar-chart"></i> Stats</a>
            </li>
            <li>
                <a href="./change_password.php"><i class="fa fa-fw fa-lock"></i> Change Password</a>
            </li>
            <li>
                <a href="./user_profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
            </li>

        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>