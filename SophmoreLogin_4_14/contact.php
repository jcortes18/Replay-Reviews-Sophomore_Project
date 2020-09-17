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
    <title>Replay Reviews Contact Page</title>
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

    <section id="contactIntro">
      <h2>Replay Reviews is an Oakland University Group Project</h2>
        <p></p>
        <h3>Created for CSI 2999 by: </h2>
    </section>

    <div class="container">

      <details open>
          <summary class="collapse" open>Johnathan Esho</summary>
          <div class="info">
              <div a="email">Email: jesho@oakland.edu</div>
              <p>Oakland University junior majoring in Information Technology.</p>
          </div>
      </details>
      <details>
          <summary class="collapse">Jessica Cortes</summary>
          <div class="info">
              <div a="email">Email: jcortes@oakland.edu</div>
              <p>Oakland University sophomore majoring in Computer Science.</p>
          </div>
      </details>
      <details>
          <summary class="collapse">Adam Komeshak</summary>
          <div class="info">
              <div a="email">Email: arkomeshak@oakland.edu</div>
              <p>Oakland University junior majoring in Information Technology.</p>
          </div>
      </details>
      <details>
          <summary class="collapse">Trevor Mckinstry</summary>
          <div class="info">
              <div a="email">Email: trevormckinstry@oakland.edu</div>
              <p>Info here</p>
          </div>
      </details>
      <details>
          <summary class="collapse">Eric Chan</summary>
          <div class="info">
              <div a="email">Email: ericchan@oakland.edu</div>
              <p>Junior at Oakland University, majoring in Information Technology.</p>
          </div>
      </details>

  </div>

    <footer id="main-footer">
        <p>Oakland University &copy; 2020 Replay Reviews</p>
    </footer>
</body>

</html>
