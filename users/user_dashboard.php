<?php include '../includes/db.php'; ?>
<?php include '../admin/functions.php'; ?>
<?php

function escapes($string) {
    global $con;
    return mysqli_real_escape_string($con, trim($string));
}

function recordCounts($table) {
    global $con;
    $sql_posts = "SELECT * FROM " . $table;
    $result_posts = mysqli_query($con, $sql_posts);
    $result = mysqli_num_rows($result_posts);
    confirmQuery($con);
    return $result;
}

function recordCountIndividual($username) {
    global $con;
    $sql_posts = "SELECT * FROM posts WHERE post_by= '$username' ";
    $result_posts = mysqli_query($con, $sql_posts);
    $result = mysqli_num_rows($result_posts);
    confirmQuery($con);
    return $result;
}

function checkActiveUserPost($username) {
    global $con;
    $sql = "SELECT * FROM posts WHERE post_status='published' AND post_by= '$username' ";
    $result = mysqli_query($con, $sql);
    return mysqli_num_rows($result);
}

function checkDraftUserPost($username) {
    global $con;
    $sql = "SELECT * FROM posts WHERE post_status = 'draft' AND post_by = '$username' ";
    $result = mysqli_query($con, $sql);
    return mysqli_num_rows($result);
}

function checkAllPosts(
$table) {
    global $con;
    $sql = "SELECT * FROM " . $table;
    $result = mysqli_query($con, $sql);
    return mysqli_num_rows($result);
}

function userPosts(
$table) {
    global $con;
    $sql = "SELECT * FROM " . $table;
    $result = mysqli_query($con, $sql);
    return mysqli_num_rows($result);
}

?>