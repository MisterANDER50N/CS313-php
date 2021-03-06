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
  <title>Reviews</title>
  
   <?php
  require('dbConnect.php');
  
  ?>
</head>
<body>
 <?php
 
 require('../header.php');
 if($_POST['search'] == '')
				{
					$new_Page ="userPage.php";
					header("Location: $new_Page");
					die();
				}
   if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    if(isset($_POST['search'])) 
    {
      $bookName = htmlspecialchars($_POST['search']);
	  $_SESSION['title'] = $bookName;
	  
	  $query = "SELECT tbl_b.rating, tbl_b.review, tbl_c.display_name, tbl_a.summary
				FROM  project1.library tbl_a    
				INNER JOIN project1.rating tbl_b   
				ON tbl_a.id = tbl_b.book_id
				INNER JOIN project1.user tbl_c
				ON tbl_b.user_id = tbl_c.id
				WHERE title = :bookName";
      $stmt = $db->prepare($query);
	  $stmt->bindValue(':bookName', $bookName, PDO::PARAM_STR);
      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	  $q2 = "SELECT summary FROM project1.library WHERE title = :bookName";
	  $s2 = $db->prepare($q2);
	  $s2->bindValue(':bookName', $bookName, PDO::PARAM_STR);
	  $s2->execute();
	  $summary = $s2->fetch(PDO::FETCH_ASSOC);
			
			echo "<form method='get' action='userPage.php' class='search'>";
			echo "<input type='submit' value='Go Back' class='submit'/>";
			echo "</form>"	;
      echo "<p><span style='font-size:2em; font-weight:bold; margin-left: 11%;'>" . $bookName . "</span></p>";
	  echo "<p style='text-align:left; margin-left: 13%; margin-right: 13%;'>" . $summary['summary'] . "</p>";
	  echo "<div class='ratings' style='text-align: center'>";
	
	if(count($rows) <= 0)
		  {
			echo "No Reviews Found Would You like to add Review?";
			echo "<form method='' action='createBookReview.php'>";
			echo "<input type='hidden' name='title'  value='".$bookName."'/>";
			echo "<input type='submit' value='Yes' class='submit'/>";
			echo "</form>"	;
			echo "<form method='get' action='userPage.php'>";
			echo "<input type='submit' value='No' class='submit'/>";
			echo "</form>";
		  }
	  else{
		 echo "<table style='width:80%'>";
		  echo "<tr><th style='width:200px'>User Name</th>";
		  echo "<th style='width:50px'>Rating</th> ";
		  echo "<th>Review</th></tr>";
		 
			foreach ($rows as $row)
			{
				echo "<tr class='rating'>";
				echo "<td>" . $row['display_name'] . "</td>";
				echo "<td>" . $row['rating'] . "</td>";
				echo "<td>" . $row['review'] . "</td>";
				echo "</tr>";
			}     
		echo "</table>";	
	  }
    } else {
      
      echo "Something Else!";
    }
  }
  
    require('../../footer.php');
  ?>
  
</body>
</html>