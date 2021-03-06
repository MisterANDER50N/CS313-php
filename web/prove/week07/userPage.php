<?php
session_start();
	if (isset($_SESSION['userName']))
{
	$userName = $_SESSION['userName'];
}
else{
	header("Location: New.php");
	die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
 <link rel="stylesheet" type="text/css" href="../stylesheet.css" />
  <title>User Page</title>
   <?php
	require('dbConnect.php');
  ?>
</head>
<body>
 <?php
    require('../header.php');

    ?>
	
	<form method="post" action="review.php" class='search'>
	<input type="text" id="search" name="search" placeholder='Title' style='width: 20%'>
	<input type="submit" name="submit" value="Search for a Book" class='submit'>
	</form>
	<form method="get" action="New.php" class='signout'>
	<input type="submit" name="submit" value="Sign Out" class='submit'>
	</form>
	
  <div class='ratings' style="text-align: center">
			<h3 style='width: 30%'> <?php echo $_SESSION['name']; ?>'s Reviews</h3>
			<table style="width:80%">
			<tr>
				<th style="width:200px">Title</th>
				<th style="width:50px">Rating</th> 
				<th style='width:300px'>Comments</th>
			  </tr>
	<?php
      $query = "SELECT tbl_a.title, tbl_b.rating, tbl_b.review
				FROM  project1.library tbl_a    
				JOIN project1.rating tbl_b   
				ON tbl_a.id = tbl_b.book_id
				WHERE user_id = '{$_SESSION['user_id']}'";
	  $stmt = $db->prepare($query);
      $stmt->execute();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
{  
	echo "<tr class='rating'>";
    echo "<td>" . $row['title'] . "</td>";
    echo "<td>" . $row['rating'] . "</td>";
    echo "<td>" . $row['review'] . "</td>";
    echo "</tr>";
}
echo "</table></br>";

?>
  
  	<form method="get" action='createBookReview.php'>
	<input type="text" name="title"  placeholder='Title'/>
		<input type="submit" value="Create Book Review" class='submit'/>
		</form>
  
   <?php
    require('../../footer.php');
    ?>
</body>
</html>