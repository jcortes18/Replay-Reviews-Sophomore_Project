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
    <style>
        .img-circle{
            border-radius: 50%;
            border-style: solid;
            float: left;
            box-sizing: border-box;
        }
      .profile_container{
        width: 40%;
        margin:auto;
        overflow: hidden;
      
      }
      .profile_container2{
        text-align: center;
      }
        .profileBlock{
            float: left;
            box-sizing: border-box;
            width: 50%;
            padding: inherit;
            margin: auto;
        }
      #profile_table{
        padding: inherit;
        margin: auto;
      }
      #table_row{
        margin: auto;
        line-height: 2em;
      }
      #table_col1{
        text-align: right;
      }
      #table_col2{
        padding-left: 30px;
        text-align: left;
      }

    </style>
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

        <?php if (isset($_SESSION['loggedin'])) : ?>
          <div class="profile_container">
            <div class="profile_container2">
              <h2>User Profile | <i><?=$_SESSION['name']?></i></h2>
                <br>
            <div class="profileBlock">
              <img class="img-circle" src="directorsChair.png">
            </div>
            <div class="profileBlock">
              <table id="profile_table">
                    <tr id="table_row">
                      <td id="table_col1">Username: </td>
                      <td id="table_col2"><i><?=$_SESSION['name']?></i></td>
                    </tr>

                    <?php
                    require('db.php');
                  
                    $strSQL = "SELECT firstname, lastname, email FROM login WHERE id = '".$_SESSION['id']."'";
                  
                    $rs = mysqli_query($conn, $strSQL);

                    while($row = mysqli_fetch_array($rs)) : ?>
                      <tr id="table_row">
                          <td id="table_col1">First name: </td>
                          <td id="table_col2"><?php echo $row['firstname'];?></td>
                      </tr>
                      <tr id="table_row">
                          <td id="table_col1">Last name: </td>
                          <td id="table_col2"><?php echo $row['lastname'];?></td>
                      </tr>
                      <tr id="table_row">
                          <td id="table_col1">Email: </td>
                          <td id="table_col2"><?php echo $row['email'];?></td>
                      </tr>
                     <?php endwhile; ?>
                     <?php mysqli_close($conn);?>
                </table>
                <br>
                <button  class="btn-logout" onClick="document.location.href = 'changePassword.php'">Change Password</button>
                </div>
             </div>
          </div>
        <?php endif; ?>

        <footer id="main-footer">
            <p>Oakland University 2020 Replay Reviews</p>
        </footer>

        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
        <script src="axios.min.js"></script>
        <script src="js/main.js"></script>
    </body>

    </html>
