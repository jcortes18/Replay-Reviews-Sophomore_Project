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
    <title>Replay Reviews</title>
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
        <div id="series" class="well"></div>
    </div>
    
         <div class="comment-form-container">
               <form id="frm-comment">
            <div class="input-row">
                <input type="hidden" name="comment_id" id="commentId"
                    placeholder="Name" /> 
                   
                   
            </div>
            <?php if (isset($_SESSION['loggedin'])) : ?>
              <!--<button  class="btn-logout" onClick="document.location.href = 'logout.php'">Logout</button>-->
                   <h2>Write a review</h2>
			 <p id="userlogged">User: <i><b><?=$_SESSION['name']?></b></i></p>
					
            <div class="input-row">
                <textarea style="border:1px solid black;"class="input-field" type="text" name="comment" id="comment" placeholder="Add a Comment..."></textarea>
            </div>
                        <div>
                <input type="button" class="btn-submit" id="submitButton"
                    value="Publish" /><div id="comment-message">Comments Added Successfully!</div>
            </div>
 
            <?php endif; ?>
            <?php if (!isset($_SESSION['loggedin'])) : ?>
                 	<p id="userlogged">Log in or create an account to comment!</p>
                    <button  class="btn-login" onClick="window.open('loginpage.php')">Login</button>
                    <button  class="btn-Register" onClick="window.open('createUser.php')">Create Account</button>
            <?php endif; ?>


        </form>

    </div>
    <div id="output"></div>
    <footer id="main-footer">
        <p>Oakland University 2020 Replay Reviews</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="axios.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        getTV();
    </script>
        <script>
			
            function postReply(commentId) {
                $('#commentId').val(commentId);
                $("#name").focus();
            }
            $("#submitButton").click(function () {
            	   $("#comment-message").css('display', 'none');
                var str = $("#frm-comment").serialize();


                $.ajax({
                    url: "tv-comment-add.php",
                    data: str,
                    type: 'post',
				
                    success: function (response)
                    {

						console.log(response);
                        var result = '(' + response + ')';
						
                        if (response)
                        {
			
						
                        	$("#comment-message").css('display', 'inline-block');
                            $("#name").val("");
                            $("#comment").val("");
 
                     	   listComment();
                        } else
                        {
                            alert("Failed to add comments !");
                            return false;
                        }
                    }
                });
            });
            
            $(document).ready(function () {
            	   listComment();
            });

            function listComment() {
				
                $.post("tv-comment-list.php",
                        function (data) {
                               var data = JSON.parse(data);
                            
                            var comments = "";
                            var replies = "";
                            var item = "";
                            var parent = -1;
                            var results = new Array();

                            var list = $("<ul class='outer-comment'>");
                            var item = $("<li>").html(comments);

                            for (var i = 0; (i < data.length); i++)
                            {
                                var commentId = data[i]['comment_id'];
                                parent = data[i]['parent_comment_id'];

                                if (parent == "0")
                                {
                                    comments = "<div class='comment-row'>"+
                                    "<div class='comment-info'><span class='commet-row-label'>from</span> <span class='posted-by'>" + data[i]['comment_sender_name'] + " </span> <span class='commet-row-label'>at</span> <span class='posted-at'>" + data[i]['date'] + "</span></div>" + 
                                    "<div class='comment-text'>" + data[i]['comment'] + "</div>"+
                                    "<div><a class='btn-reply' onClick='postReply(" + commentId + ")'>Reply</a></div>"+
                                    "</div>";

                                    var item = $("<li>").html(comments);
                                    list.append(item);
                                    var reply_list = $('<ul>');
                                    item.append(reply_list);
                                    listReplies(commentId, data, reply_list);
                                }
                            }
                            $("#output").html(list);
                        });
            }

            function listReplies(commentId, data, list) {

                for (var i = 0; (i < data.length); i++)
                {
                    if (commentId == data[i].parent_comment_id)
                    {
                        var comments = "<div class='comment-row'>"+
                        " <div class='comment-info'><span class='commet-row-label'>from</span> <span class='posted-by'>" + data[i]['comment_sender_name'] + " </span> <span class='commet-row-label'>at</span> <span class='posted-at'>" + data[i]['date'] + "</span></div>" + 
                        "<div class='comment-text'>" + data[i]['comment'] + "</div>"+
                        "<div><a class='btn-reply' onClick='postReply(" + data[i]['comment_id'] + ")'>Reply</a></div>"+
                        "</div>";
                        var item = $("<li>").html(comments);
                        var reply_list = $('<ul>');
                        list.append(item);
                        item.append(reply_list);
                        listReplies(data[i].comment_id, data, reply_list);
                    }
                }
            }
			// code source https://phppot.com/php/comments-system-using-php-and-ajax/
        </script>
</body>

</html>