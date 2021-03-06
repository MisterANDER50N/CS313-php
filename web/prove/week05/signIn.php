<?php
session_start();
if (!isset($_SESSION['id'])) {
	$_SESSION['id']=$_GET['id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="../stylesheet.css" />
  <title>Sign In</title>  
  
  <?php
  
  	function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }
  
    try
    {
      $dbUrl = getenv('DATABASE_URL');

      $dbOpts = parse_url($dbUrl);

      $dbHost = $dbOpts["host"];
      $dbPort = $dbOpts["port"];
      $dbUser = $dbOpts["user"];
      $dbPassword = $dbOpts["pass"];
      $dbName = ltrim($dbOpts["path"],'/');

      $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);

      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $ex)
    {
      echo 'Error!: ' . $ex->getMessage();
      die();
    }
  ?>

  </head>
<body>
 <?php
  require('../header.php');
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    if(isset($_POST['pass'])) 
    {
      $pass = test_input($_POST['pass']);
      $query = "SELECT password, username, id, display_name 
				FROM project1.user 
				WHERE id = :id";  
	  $stmt->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
	  $stmt = $db->prepare($query);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if($row[password] == $pass){
		 $_SESSION['name'] = $row[username];
		 $_SESSION['user_id'] = $row[id];
		 $_SESSION['display_name'] = $row[display_name];
		 echo "change page";
		 echo '<script>window.location.href = "userPage.php";</script>';
	  }
      else
		  echo "<p>incorrect password, please try again.</p>";
    }
  }
  ?>
 <form method="post" action="<?php echo htmlspecialchars($_SERVER["userPage.php"]);?>">
  <label for="message">Please Enter Your Password</label>
  <?php echo "SELECT password, username, id, display_name FROM project1.user WHERE id = ". $_SESSION['id']; ?>
  <input type="text" id="pass" name="pass">
  <input type="submit" name="submit" value="Submit">
</form>
    <?php
    require('../../footer.php');
    ?>
</body>
</html>