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
    <title>ReplayReviews Home Page</title>
    <link rel="stylesheet" type="text/css" href="homepage.css"> </head>

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
    <div class="search_wrapper">
        <input type="radio" name="size" class="search_type" id="movie" value="Movies" autocomplete="off" />
        <label for="movie">Movies</label>
        <input type="radio" name="size" class="search_type" id="game" value="Games" autocomplete="off" />
        <label for="game">Games</label>
        <input type="radio" name="size" class="search_type" id="tele" value="TV" autocomplete="off" />
        <label for="tele">TV</label>
    </div>
    <div class="search-cont">
        <form id="search-bar">
            <input type="text" class="search-control" id="searchTitle" name="searchbar" placeholder="Search for Movies"> </form>
    </div>
    <div class="container">
        <div class="movie_container">
            <div id="titles" class="row"></div>
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