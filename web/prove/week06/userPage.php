<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
 <link rel="stylesheet" type="text/css" href="../stylesheet.css" />
  <title>User Page</title>
   <?php
	require('dbConnect.php');
	
	 if($_SERVER['REQUEST_METHOD'] == 'POST')
	  {
		if(isset($_POST['book'])) 
		{
			
		  $bookName = test_input($_POST['search']);
		  
		  $stmt = $db->prepare('SELECT title FROM project1.library WHERE title=:bookName');
		  $stmt->bindValue(':bookName', $bookName, PDO::PARAM_STR);
		  $stmt->execute();
		  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		  
		  if(count($rows) <= 0)
		  {
			echo "No Reviews Found";
		  }
		  else{
			  $_SESSION['title'] = $row['title'];
			$new_Page ="review.php";
			header("Location: $new_Page");
			die();
		  }			  
			  
		} else {
		  
		  echo "Something Else!";
		}
	  }
  ?>
</head>
<body>
 <?php
    require('../header.php');
	echo "<p> Hello  " . $_SESSION["name"] . "</p>";
    ?>
	
	<form method="post" action="review.php">
	<label for="search">Search for a Book</label>
	<input type="text" id="search" name="search">
	<input type="submit" name="submit" value="Submit">
	</form>
	
  <div class='ratings' style="text-align: center">
			<table style="width:80%">
			<tr>
				<th style="width:200px">Title</th>
				<th style="width:50px">Rating</th> 
				<th>Comments</th>
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
	echo "<tr>";
    echo "<td>" . $row['title'] . "</td>";
    echo "<td>" . $row['rating'] . "</td>";
    echo "<td>" . $row['review'] . "</td>";
    echo "</tr>";
}
echo "</table>";

?>
  
  	<form method="get" action='createBookReview.php'>
	<input type="text" name="title" />
		<input type="submit" value="Create Book Review" />
		</form>
  
   <?php
    require('../../footer.php');
    ?>
</body>
</html>