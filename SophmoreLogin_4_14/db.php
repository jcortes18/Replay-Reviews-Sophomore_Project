<?php
 /*
 to test the comment section you either need to upload the project to SECS server using filezilla or you can go to localhost/phpmyadmin and login there and then once in there create a database and click import and then choose the tbl_comment.sql file in this folder after that just comment out the below code and put this code in using the format. the root might be a username if you made one but the default is just root. then insert database name and password 
 $conn = mysqli_connect("localhost","root or username","password","database name");
 
 example
 $conn = mysqli_connect("localhost","root","ThisIsMyPassword","CommentReplySystem);
 */

  $conn = mysqli_connect("localhost","root","pwdpwd","comment-reply-system");

  if($conn->connect_error) {
      exit('Error connecting to database'); 
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn->set_charset("utf8mb4");
?>