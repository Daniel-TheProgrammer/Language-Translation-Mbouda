<?php session_start(); ?>

<?php
include '../../helper.php';
if(!isset($_SESSION['valid'])) {
    header('Location: ' . route('login.php'));
}
?>

<?php
//including the database connection file
include("../../database/connection.php");

//getting id of the data from url
$id = $_GET['id'];

//deleting the row from table
$query = "SELECT * FROM translation WHERE id=" . $id;
$result=mysqli_query($mysqli, $query) or die("Error $query" . mysqli_error($mysqli));
while ($res = mysqli_fetch_array($result)) {
    unlink('../../uploads/' . $res['word_pronunciation']);
}

//deleting the row from table
$query = "DELETE FROM translation WHERE id=" . $id;
$result=mysqli_query($mysqli, $query) or die("Error $query" . mysqli_error($mysqli));

//redirecting to the display page (view.php in our case)
header("Location: ". route('dashboard/index.php'));
?>

