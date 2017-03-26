
<?php include 'db.php'; ?>

<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">



    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search by title,author..etc" required />
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" name="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- Search form -->
        <!-- /.input-group -->
    </div>

    <!--Login -->   
    <div class="well">

        <?php
        if (isset($_SESSION['user_role'])) {
            ?>  
            <h4>Logged in as <?php echo $_SESSION['username'] ?></h4>
            <a href="includes/logout.php" class = "btn btn-primary">Logout</a>

        <?php } else { ?>
            <h4>Login</h4>

            <form action = "includes/login.php" method = "post">
                <div class = "form-group">
                    <input type = "text" class = "form-control" name = "username" placeholder = "Enter Username" required/>
                </div>
                <div class = "form-group">
                    <input type = "password" class = "form-control" name = "password" placeholder = "Enter Password" required/>
                    
                    <?php
                    if (isset($_SESSION['login_error'])) {
                        echo $_SESSION['login_error'];
                    }
                    ?>
                </div>  
                <div class = "form-group">
                    <input type = "submit" class = "btn btn-primary" name = "login" value = "Login"/>
                   <a href = "./registration.php">Not yet Registered?</a>
                   <a href = "./forget_password.php">Forget Password?</a>
                </div>

            </form>
        <?php }
        ?>

        <!-- Search form -->
        <!-- /.input-group -->
    </div>


    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-unstyled">
                    <?php
                    $sql = "SELECT * FROM categories";
                    $result = mysqli_query($con, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];
                        echo "<li><a href='category.php?category=$cat_id'>$cat_title</a></li>";
                    }
                    ?>

                </ul>
            </div>

        </div>
        <!-- /.row -->
    </div>


</div>