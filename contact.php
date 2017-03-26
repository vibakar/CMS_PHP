<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>


<!-- Navigation -->

<?php include "includes/navigation.php"; ?>
<?php
if (isset($_POST['submit'])) {
    $to = "viba.2394@gmail.com";
    $subject = wordwrap($_POST['subject'],70);
    $body = $_POST['body'];
    $header="From: ".$_POST['email'];
    mail($to, $subject, $body,$header);
    echo '<h5 class="bg-success">Email Sent</h5>';
}
?>
<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">

                        <h1>Contact</h1>
                        <form role="form" action="" method="post" id="login-form" autocomplete="off">

                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter the Email" required />
                            </div>
                            <div class="form-group">
                                <label for="subject" class="sr-only">Subject</label>
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter the Subject" required />
                            </div>
                            <div class="form-group">
                                <label for="body" class="sr-only">Body</label>
                                <textarea  class="form-control" name="body" id="body" cols="50" rows="10" required></textarea>
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php"; ?>