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
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Replay Reviews Account Creation</title>
    <link rel="stylesheet" type="text/css" href="homepage.css"> </head>
<style>
.box{
    text-align:center;
}
#log-form{
	text-align:center;
	border-radius:30px;
	padding:70px 100px;
	margin-bottom:25px;
}

#userLabel, #passLabel{
	width:10%;
	background-color:white;
	font-size:1em;
	color: rgba(0, 0, 0, 1);
	display:inline-block;
	border:0;
	
}
#createuser, #createpass{ 
    font-size:1.2em;
	font-style:italic;
	border-radius:20px;
	text-align:center;
	display:inline-block;
	width:20%;

}

#create-submit-btn, #create-back-btn{
	color:#fff;
	background-color:#e74c3c;
	outline: none;
    border: 0;
    color: #fff;
	padding:10px 20px;
	text-transform:uppercase;
	margin-top:50px;
	border-radius:2px;
	cursor:pointer;
	position:relative;
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
   
   <div class="box">


 <div class="log-form">
  <h2 id="create-h3">Create your account</h2>
  <form action="createUser.php" method="POST">
				<div style="text-align:center;">
					<label for createuser id="userLabel">First name</label>
					<input id ="createuser" name="firstname" type="text" title="firstname" placeholder="firstname" />
				</div>
				<div style="text-align:center;">
					<label for createuser id="userLabel">Last name</label>
					<input id ="createuser" name="lastname" type="text" title="lastname" placeholder="lastname" />
				</div>
			  <div style="text-align:center;">
				    <label for createuser id="userLabel">Username</label>
				    <input id ="createuser" name="createusername" type="text" title="username" placeholder="username" />
				</div>
				<div style="text-align:center;">
				    <label for createuser id="userLabel">Email</label>
				    <input id ="createuser" name="email" type="email" title="email" placeholder="email" />
				</div>
				<div style="text-align:center;">
					  <label for createuser id="passLabel">Password</label>
				    <input id="createpass" name="createpassword" type="password" title="password" placeholder="password" />
				</div>
				<div style="text-align:center;">
				    <button id="create-submit-btn" type="submit" class="btn-create" id="register">Register</button>
				    <input id="create-back-btn" type="button" value="Go back!" onclick="history.back()">
				</div>
	  </form>
    </div>	
	</div>	

 <footer id="main-footer">
        <p>Oakland University 2020 Replay Reviews</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="axios.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript">
			$(function(){
				$('#create-submit-btn').click(function(e){
					<?php
						require_once ("db.php");

						if(isset($_POST)){
								$firstname = $_POST['firstname'];
								$lastname = $_POST['lastname'];
								$username = $_POST['createusername'];
								$email = $_POST['email'];
								$password =$_POST['createpassword'];


								$sql = "INSERT INTO login(firstname,lastname,username,email, password) VALUES ('" . $firstname . "','" . $lastname . "','" . $username . "','" . $email . "','" . $password . "')";
								$result = mysqli_query($conn, $sql);

								if (! $result) {
										echo "Error";
								}else{
										header('Location: loginpage.php');
									 }
						}else{
				                echo 'No data';
							 }
				?>
				}
			}
		</script>
    
    
    </body>
</html>














