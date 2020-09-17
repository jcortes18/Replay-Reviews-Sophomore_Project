<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
include 'logged.php';
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT password FROM login WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password);
$stmt->fetch();
$stmt->close();
?>

<?php
require_once ("db.php");
include "assignvar.php";

$commentId = isset($_POST['comment_id']) ? $_POST['comment_id'] : "";
$comment = isset($_POST['comment']) ? $_POST['comment'] : "";
$commentSenderName = isset($_SESSION['name']) ? $_SESSION['name'] : "";
$date = date('Y-m-d H:i:s');
$commentTitle = isset($_COOKIE['Title_Name']) ? $_COOKIE['Title_Name'] : "";

$TitleMSG = $commentTitle;
$sql = "INSERT INTO tv_tbl_comment(parent_comment_id,comment,comment_sender_name,date,title_name) VALUES ('" . $commentId . "','" . $comment . "','" . $commentSenderName . "','" . $date . "','" . $TitleMSG . "')";

$result = mysqli_query($conn, $sql);

if (! $result) {
    $result = mysqli_error($conn);
}
echo $result;
// code source https://phppot.com/php/comments-system-using-php-and-ajax/
?>
