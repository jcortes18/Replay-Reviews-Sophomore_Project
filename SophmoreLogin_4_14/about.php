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
    <title>About Replay Reviews</title>
    <link rel="stylesheet" type="text/css" href="homepage.css">
    <!--
    Do we need these links because they are causing the about page to load slow

     <script type="text/javascript" src="https://me.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=sOjT3ouEPORjIXC2EVsTnRnZlQoBcoOQMcNGwIaH8-7aI-p4yTLyuv3YlxSy9XWBFuwqB0GIT3zRRkSBB7iK8_s-xuH8nr3-XqGeHA4amGG50QfKJ0Bl7x47JS00gq2_gouhdCc2BJ9hibZmejTbSuTBiqC0VeQxh4mQNIB138PwQDWCtOZFNbmyOecrYtpgHYQ56gICDpU_cpLhPKi--ZCjHCoX7CPvnrT17D2AYAMhvVeVSJRmTaaQ5qbALH4iJZVRvatMDtrIqkqVUfsoqM79nXFn09ibIRaEzqKC1j8QFFzkyf2vHRW8YiWbPGKUbRsgticpGuOGBgX4QKrmeYtF4-3zhyJE6KB85GTglihXByMQvBJDbe4FAA5hK57reEX-yBqyZYrlnIKitOw39oKNsYkZmDudLUs1TKZWgaNNe6vRCr_2ZUhGtK3tXlOiEmfWqWVbnqou91YDVb7P8LybMuc6IntC4aLNvxVX_U4" charset="UTF-8"></script>
     <link rel="stylesheet" crossorigin="anonymous" href="https://me.kis.v2.scr.kaspersky-labs.com/E3E8934C-235A-4B0E-825A-35A08381A191/abn/main.css?attr=aHR0cHM6Ly9kb2MtMTQtMTQtZG9jcy5nb29nbGV1c2VyY29udGVudC5jb20vZG9jcy9zZWN1cmVzYy9rNjNmdDNtMXN2NHBnMzRvMW1yNmFkZGxmZTZrM3RtbC9wZnMxbjJzMWYwdTBmcDB1aDByYTk2dWhidDNscDc1bi8xNTgzMjkzODc1MDAwLzE3ODg3MTcyMzE2NDkxNzM5NDE0LzE3ODg3MTcyMzE2NDkxNzM5NDE0LzEwREMzT3lpb3ZrT0NROThyRFRrMVV4Y3BnX1BlRE5zRT9lPWRvd25sb2FkJmg9MDY0NjYwNDUzMzQ2NTg5NjQ5NTkmYXV0aHVzZXI9MiZub25jZT1qYTkzbzkxMHNsdjVnJnVzZXI9MTc4ODcxNzIzMTY0OTE3Mzk0MTQmaGFzaD1lMzlsM2hwOWpmbnEycjhraWVoaWw4ZmNvYWJkbmtzag"/>
-->
</head>

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

    <div class="container">

        <section id="about">
			<h2><br>About Replay Reviews</h2>
          <p>Replay Reviews was created as a site that helps users consolidate reviews for popular Movies, TV Shows, and Video Games all in one place.</p>
        </section>

        <div class="block">

          <section id="apiReferences">
            <p>Currently, our site takes a user's input in the search bar and, depending on the user selection, chooses the appropriate API in order to produce a list of search results.</p>
          	<ul>
          		<li>For Movies and TV shows, we use the OMDB API: <br><a href="http://www.omdbapi.com" style="color:blue">FOUND HERE</a></li>
          		<li>For Video Games, we use the RAWG API: <br><a href="http://rawg.io/apidocs" style = "color:blue">FOUND HERE</a></li>
          	</ul>
          </section>
        </div>

        <div class="block">

        	<section id="axiosRef">
            <p>Our results pages auto populates using the AXIOS JavaScript scripts that automatically generates HTTP requests for search results on popular review sites like IMDB, Rotten Tomatoes, Roger Ebert, and others.</p>

          	<ul>
            		<li>The source code for the AXIOS JavaScript Library can be found on GitHub by <a href="https://github.com/axios/axios" style="color:blue">CLICKING HERE</a></li>
          	</ul>

          </section>
        </div>

        <section id="sitesHeader">
          <h2>Review Sites Used:</h2>
        </section>

        <div class="sitesWrap">

          <section id="rottenTomatoes">
              <ul>
                <li><a href="https://www.rottentomatoes.com/">Rotten Tomatoes</a></li>
              </ul>
          </section>
          <section id="iMDB">
              <ul>
                <li><a href="https://www.imdb.com/">IMDB</a></li>
              </ul>
          </section>

          <section id="metaCritic">
              <ul>
                <li><a href="https://www.metacritic.com/">MetaCritic</a></li>
              </ul>
          </section>
          <section id="rogerEbert">
              <ul>
                <li><a href="https://www.rogerebert.com/">RogerEbert</a></li>
              </ul>
          </section>
      </div>

    </div>

  	<footer class="copy">
  		<p>Oakland University &copy; 2020 Replay Reviews</p>
  	</footer>

</body>

</html>