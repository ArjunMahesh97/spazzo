<?php 
session_start();
$_SESSION['user_id'] = 1;
$_SESSION['user_name']='arjun';
?>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Spazzo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- TODO : seo stuff goes here -->
    <meta name="theme-color" content="#efe3dd">
    <!-- stylesheets and fonts -->
    <link rel="stylesheet" type="text/css" media="screen" href="css/index.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/animate.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- <script src="js/index.js"></script> -->
    <!-- TODO : Create favivons for all pages -->
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Rubik:400">
</head>
<?php 
$servername = "localhost:3306";
$username = "root";
$password = "";
// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
/*echo "Connected successfully to mysql";*/
$sql = "SELECT * FROM mobiledb.processor";
$result = $conn->query($sql);
if($result == false) {
   /* echo "Query fiailed";*/
    die("Query failed");
}

$conn->close();
//die("Testing ended");
// define variables and set to empty values
$name = $email = $gender = $comment = $website = "";
/*
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    #$name = test_input($_POST["name"]);
    #$email = test_input($_POST["email"]);
    #$website = test_input($_POST["website"]);
    #$comment = test_input($_POST["comment"]);
    #$gender = test_input($_POST["gender"]);
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
} */
//var_dump($_REQUEST);
if(!isset($_REQUEST['uname'])) {
?>

   <body>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>                
                <a class="navbar-brand animated fadeIn" href="#">Spazzo</a>
            </div>
                
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="login-btn animated slideInRight" href="about.html">ABOUT US</a></li>
                    <li><a class="login-btn animated slideInRight" href="login.html">LOGIN</a></li>
                    <li><a class="signup-btn animated slideInRight" href="signup.html">SIGNUP</a></li>           
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-push-6">
                    <img src="assets/hero.png" alt="Designer" class="img-hero animated fadeIn" />
                </div>
                <div class="col-lg-6 col-lg-pull-6 about">
                    <h1 class="tagline animated fadeIn">Digital art meets Designers</h1>
                    <p class="desc animated fadeIn">Looking for a design portal that isn't crowded with posts and designers
                        that you don't care about? While being respectful to a fellow designer's work is important, 
                        there simply comes a time when you think, "Okay, I've had enough of this spammy posts in my design 
                        feed, I need some good content to grow as a designer".
                        <br> Fret not, Spazzo is the social design portal that helps you do exactly just that.
                    </p>
                    <a href="login.html" class="start-btn animated fadeIn">Get started</a>
                </div>
            </div>
        </div>
    </div>
    
    <script
     src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js">
    </script>
    <script
     src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
     integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" 
     crossorigin="anonymous" >
    </script>
</body>



 <?php
} else {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=spazzo", 'root', '');
        
        // execute the stored procedure
        $sql = 'select  validateUser(:name,:psw)';
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':name', $_REQUEST['uname'], PDO::PARAM_STR);        
        $stmt->bindParam(':psw', $_REQUEST['psw'], PDO::PARAM_STR);
        $r =$stmt->execute();
        
        $r = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        var_dump($r);
        
        //echo "<script>alert('Invalid User name or password, please retry');document.location='first.php'</script>";
        $uid = (int)$r[0];
        
       if($uid > 0) {
            $username = $_REQUEST['uname'];
            $_SESSION['user_id'] = $uid;
            //var_dump($uid);
            //echo "<script>alert('Invalid User name or password, please retry');document.location='first.php'</script>";
            $_SESSION['user_name'] = $_REQUEST['uname'];
            echo "<script>document.location='login.php'</script>";
        } else {
            $_SESSION['user_id'] = 0;
            $_SESSION['user_name'] = 'Unknown';
            unset($_REQUEST['uname']);
            echo "<script>alert('Invalid User name or password, please retry');document.location='mainpage.php'</script>";
            
        }
        printf("%d\n",$uid);
        //var_dump($uid);
        // execute the second query to get values from OUT parameter
        //var_dump($r);
    } catch (PDOException $pe) {
        die("Error occurred:" . $pe->getMessage());
    }
}
 ?>        
     
      
 </div>
 	
</html>  