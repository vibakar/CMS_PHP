<?php ob_start();?>
<?php session_start();?>
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

        <script src="http://tinymce.cachefly.net/4.1/tinymce.min.js"></script>
        <script>tinymce.init({selector: 'textarea'});</script>
    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <?php include './includes/user_navigation.php'; ?>

            <div id="page-wrapper">

                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">
                                Welcome <?php echo $_SESSION['user_role'];?>
                                <small><?php echo $_SESSION['username'];?></small>
                            </h1>
                        </div>
                    </div>

                    <?php
                    if (isset($_GET['user_source'])) {
                        $source = $_GET['user_source'];
                    } else {
                        $source = '';
                    }
                    switch ($source) {
                        case 'edit_posts':
                            include './includes/edit_user_posts.php';
                            break;
                        case 'add_posts':
                            include './includes/add_posts.php';
                            break;                       
                        default:
                            include './includes/view_user_posts.php';
                            break;
                    }
                    ?>


                    <!-- /.row -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="../admin/js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../admin/js/bootstrap.min.js"></script>

    </body>

</html>
