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
    <title>ReplayReviews Login</title>
    <link rel="stylesheet" type="text/css" href="homepage.css"> </head>
<style>
	#box{


text-align:center;
}
#login{
	

	text-align:center;
	border-radius:30px;
	padding:70px 100px;
	margin-bottom:25px;
}

#loguserLabel, #logpassLabel{
	border:none;
		font-size:1em;
	color: rgba(0, 0, 0, 1);
	width:10%;
	
	background-color:white;

	display:inline-block;
	
	
}
#loguser, #logpass{ 
	font-size:1.2em;
	font-style:italic;
	text-align:center;
	display:inline-block;
	width:20%;
	border-radius:20px;

}

#log-submit-btn{
	
	color:#fff;
	background-color:#e74c3c;
	outline: none;
    border: 0;
    color: #fff;
	padding:10px 20px;
	text-transform:uppercase;
	margin-top:50px;
	border-radius:20px;
	cursor:pointer;
	position:relative;
}
	#log-submit-btn:hover{
		background-color:rgba( 191, 6, 6, 1)
	}



	</style>
<body>
        <nav id="navbar">
        <div class="container">
            <ul>
                <li>Replay Reviews</li>
                <li><a href="HomePage.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li style="float:right;display: inline; position:relative;">
           
            <?php if (!isset($_SESSION['loggedin'])) : ?>
                      <button  class="btn-login" onClick="document.location.href ='loginpage.php'">Login</button>
                    <button  class="btn-Register" onClick="document.location.href='createUser.php'">Create Account</button>
            <?php endif; ?>
            
             <?php if (isset($_SESSION['loggedin'])) : ?>
                   <p style="display:inline;">Logged in as: <i><?=$_SESSION['name']?></i></p>

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
    
    
    
  <div id="box">
    <div class="login">
			<h1>Login</h1>
			<form action="authenticate.php" method="post">
			
			
			<div style="text-align:center;">
				<label for="username" id="loguserLabel" >Username</label>
				<input type="text" name="username" placeholder="Username" id="loguser" required>
				</div>
				
				
				<div style="text-align:center;">
				<label for="password"id="logpassLabel">Password</label>
				<input type="password" name="password" placeholder="Password" id="logpass" required>
				</div>
				
				
				<input id="log-submit-btn" type="submit" value="Login">
			</form>
		</div>
		</div>
		
		
<footer id="main-footer">
        <p>Oakland University 2020 Replay Reviews</p>
</footer>
    
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="axios.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
			
			

	



