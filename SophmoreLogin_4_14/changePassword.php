<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
include "logged.php";
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReplayReview Home Page</title>
    <link rel="stylesheet" type="text/css" href="homepage.css"> </head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <style> 
        
        #changePassTable{
        padding: inherit;
        margin: auto;
      }
      #table_row{
        margin: auto;
        
      }
      #table_col1{
        text-align: right;
      }
      #table_col2{
        padding-left: 30px;
        text-align: left;

      }</style>
<body>
            <nav id="navbar">
            <div class="container">
                <ul>
                    <li>Replay Review</li>
                    <li><a href="HomePage.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li style="float:right;display: inline; position:relative;">

                <?php if (!isset($_SESSION['loggedin'])) : ?>
                        <button  class="btn-login" onClick="window.open('loginpage.php')">Login</button>
                        <button  class="btn-Register" onClick="window.open('createUser.php')">Create Account</button>
                <?php endif; ?>

                 <?php if (isset($_SESSION['loggedin'])) : ?>

                        <p style="display:inline;">Logged in as: <i><?=$_SESSION['name']?></i>  </p>

                        <button  class="btn-logout" onClick="document.location.href = 'profile.php'">Profile</button>

                       <button  class="btn-logout" onClick="document.location.href = 'logout.php'">Logout</button>

                    <?php endif; ?>
    				</li>

                </ul>
            </div>
        </nav>
        <header id="main-header">
            <div class="container">
                </div>
        </header>


        <form name="chngpwd" action="changePassword.php" method="post" onSubmit="return valid();">
            <table align="center" id="changePassTable">
                <h2 align="center">Change Password</h2>
                <tr id="table_row" height="50">
                    <td id="table_col1">Current Password :</td>
                    <td id="table_col2"><input type="password" name="opwd" id="opwd"></td>
                </tr>
                <tr id="table_row" height="50">
                    <td id="table_col1">New Password :</td>
                    <td id="table_col2"><input type="password" name="npwd" id="npwd"></td>
                </tr>
                <tr id="table_row" height="50">
                    <td id="table_col1">Confirm Password :</td>
                    <td id="table_col2"><input type="password" name="cpwd" id="cpwd"></td>
                </tr>
                <tr id="table_row" height="50" >
                   <td><input class="btn-logout" type="button" value="Go back!" onclick="history.back()"></td>
                   <td><button class="btn-logout" type="submit" name="Submit" >OK!</button></td>
                </tr>
             </table>
            
        </form>

        <?php

            require('db.php');

            if(isset($_POST['Submit'])){
                
                $stmt = $conn->prepare("SELECT password FROM login WHERE id = ?");
                $stmt->bind_param("i", $_SESSION['id']);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($password);
                $stmt->fetch();
                
                if ($_POST['opwd'] === $password) {
                    $stmt = $conn->prepare("UPDATE login SET password = ? WHERE id = ?");
                    $stmt->bind_param("si", $_POST['npwd'], $_SESSION['id']);
                    $stmt->execute();
                    
                    echo "<script type='text/javascript'>
                        $(document).ready(function(){
                          Swal.fire({
                            icon: 'success',
                            title: 'Password changed!',
                          }).then((result) => {
                              if (result.value) {
                                window.location.href = 'profile.php';
                              }
                            })
                        });
                            
                        </script>";
                    
                    if($stmt->affected_rows === 0) exit('No rows updated');
                    $stmt->close();
                    }
                    else{
                        echo "<script type='text/javascript'>
                        $(document).ready(function(){
                          Swal.fire({
                            icon: 'error',
                            title: 'Invalid old password',
                          })
                        });
                            
                        </script>";
                    }
                }
        ?>
        <?php mysqli_close($conn);?>


        <footer id="main-footer">
            <p>Oakland University 2020 Replay Reviews</p>
        </footer>

        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
        <script src="axios.min.js"></script>
        <script src="js/main.js"></script>

        <script type="text/javascript">
            function valid(){
                if(document.chngpwd.opwd.value==""){
                    Swal.fire('Current Password missing..');
                    document.chngpwd.opwd.focus();
                    return false;
                }else if(document.chngpwd.npwd.value==""){
                    Swal.fire('New Password missing..');
                    document.chngpwd.npwd.focus();
                    return false;
                }else if(document.chngpwd.cpwd.value==""){
                    Swal.fire('Confirm Password missing..');
                    document.chngpwd.cpwd.focus();
                    return false;
                }else if(document.chngpwd.npwd.value!= document.chngpwd.cpwd.value){
                    Swal.fire('New Passwords do not match');
                    document.chngpwd.cpwd.focus();
                    return false;
                }
                return true;
            }
        </script>
    </body>

    </html>
