<?php
require_once ("db.php");
header("Refresh:0");
$commentTitle = isset($_COOKIE['Title_Name']) ? $_COOKIE['Title_Name'] : "";
$TitleMSG = $commentTitle;
$sql = "SELECT * FROM `game_tbl_comment` WHERE title_name ='".$TitleMSG."'";

$result = mysqli_query($conn, $sql);
$record_set = array();
while ($row = mysqli_fetch_assoc($result)) {
    array_push($record_set, $row);
}
mysqli_free_result($result);

mysqli_close($conn);
echo json_encode($record_set);
// code source https://phppot.com/php/comments-system-using-php-and-ajax/
?>