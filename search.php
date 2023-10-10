<html>
<head><title> iBay Home </title></head>
<body>

<center> <h1> Welcome to iBay, <?php echo $_GET['UserID']; ?>! <h1>  <h3> Access thousands of listings by searching below...</h3> 


<form action="search.php" method="GET"> 
	<input type="search" name="searchbar" placeholder="Search for a phrase..." size="100">
	<button type="submit">Search</button>
	<input type="hidden" name="UserID" value="<?php echo $_GET['UserID']; ?>">
	<br><br>
	<label class="radio-inline">
	<input type="radio" name="myRadio" value="descriptionRadio" checked> in description
	</label>
	<label class="radio-inline">
	<input type="radio" name="myRadio" value="categoryRadio"> in category
	</label>
	<label class="radio-inline">
	<input type="radio" name="myRadio" value="sellerRadio"> in seller
	</label>
  
</form>


<center> <h3> Or sell some items you don't need anymore! </h3> 
<form action="sellItem.php" method="GET">
	<input type="hidden" name="UserID" value="<?php echo $_GET['UserID']; ?>">
	<br><br>
	<button type="submit">Sell Item</button>
</form>
</center>

	
	 <h3> <?php if(count($_GET) > 1){ echo "Here are the TOP 100 results matching your search phrase: " . $_GET['searchbar']; }?> </h3>
	 
</center>
</body>
</html>

<?php
	
	// on submit, create db connection and call items with given phrase from the table for which the radio button was selected
	if(count($_GET) > 1){
		
		// establish connection
		$conn = new mysqli("localhost", "devam", "cs434", "AuctionDatabase");

		if($conn->connect_errno) {
			echo "Failed to connect to MySQL: ". $conn -> connect_error;
			exit();
		}
		
		$selectedRadio = $_GET['myRadio'];
		$searchString = $_GET['searchbar'];
		
		// find phase in tblCategory
		if($selectedRadio == "categoryRadio"){
$sqlCategory = "SELECT * FROM tblItems WHERE ItemID IN (SELECT ItemID FROM tblCategory INNER JOIN tblItemCategory ON tblCategory.CategoryID = tblItemCategory.CategoryID WHERE Name LIKE " . "'%" . $searchString . "%'" . " AND Ends > now()) ORDER BY Currently ASC;";

			$sqlCategoryClosed = "SELECT * FROM tblItems WHERE ItemID IN (SELECT ItemID FROM tblCategory INNER JOIN tblItemCategory ON tblCategory.CategoryID = tblItemCategory.CategoryID WHERE Name LIKE " . "'%" . $searchString . "%'" . " AND Ends < now()) ORDER BY Currently ASC;";
			
			$result = $conn->query($sqlCategory);
			$resultClosed = $conn->query($sqlCategoryClosed);
			
			
			// print active auction first, then closed auction
			$resultCounter = 0;
			if($result){
				echo "CURRENT ACTIVE AUCTIONS: ";
				echo "<br>";
				echo "<br>";
				
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
					if($resultCounter < 100){
						$itemIDLink = "ItemID:" . $row['ItemID'];
						echo "========== " . "<a href='bidding.php?ItemID=" . $row['ItemID'] . "&UserID=" . $_GET['UserID'] . "'> " . $itemIDLink . "</a>" . " ==========";
						echo "<br>";
						print("<pre>".print_r($row,true)."</pre>"); 
						$resultCounter = $resultCounter+1;
					}					
				}
				
				if($resultCounter === 0){
					echo "No active auctions with given search phrase.";
					echo "<br>";
				}
					
			}
			
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				
			if($resultClosed){
				echo "CLOSED AUCTIONS: ";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				while($row = $resultClosed->fetch_array(MYSQLI_ASSOC)){
					if($resultCounter < 100){
						$itemIDLink = "ItemID:" . $row['ItemID'];
						echo "========== " . "<a href='bidding.php?ItemID=" . $row['ItemID'] . "&UserID=" . $_GET['UserID'] . "'> " . $itemIDLink . "</a>" . " ==========";
						echo "<br>";
						print("<pre>".print_r($row,true)."</pre>"); 
						$resultCounter = $resultCounter+1;
					}					
				}
			}
			
			echo "" . $resultCounter . " total results found.";
			
			
			// get matching results from tblItems seller attribute
		} else if ($selectedRadio == "sellerRadio"){
		
			// first print all active auctions (i.e Ends > now())
			$sqlSeller = "SELECT * FROM tblItems WHERE Seller LIKE " . "'%" . $searchString . "%'" . " AND Ends > now() ORDER BY Currently ASC;";
			$result = $conn->query($sqlSeller);
			
			// then print items which were already past their end time
			$sqlSellerClosed = "SELECT * FROM tblItems WHERE Seller LIKE " . "'%" . $searchString . "%'" . " AND Ends < now() ORDER BY Currently ASC;";
			$resultClosed = $conn->query($sqlSellerClosed);
			
			
			// print active auction first, then closed auction
			$resultCounter = 0;
			if($result){
				echo "CURRENT ACTIVE AUCTIONS: ";
				echo "<br>";
				echo "<br>";
				
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
					if($resultCounter < 100){
						$itemIDLink = "ItemID:" . $row['ItemID'];
						echo "========== " . "<a href='bidding.php?ItemID=" . $row['ItemID'] . "&UserID=" . $_GET['UserID'] . "'> " . $itemIDLink . "</a>" . " ==========";
						echo "<br>";
						print("<pre>".print_r($row,true)."</pre>"); 
						$resultCounter = $resultCounter+1;
					}					
				}	
				
				if($resultCounter === 0){
					echo "No active auctions with given search phrase.";
					echo "<br>";
				}
			}
			
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
			
			if($resultClosed){
				echo "CLOSED AUCTIONS: ";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				while($row = $resultClosed->fetch_array(MYSQLI_ASSOC)){
					if($resultCounter < 100){
						$itemIDLink = "ItemID:" . $row['ItemID'];
						echo "========== " . "<a href='bidding.php?ItemID=" . $row['ItemID'] . "&UserID=" . $_GET['UserID'] . "'> " . $itemIDLink . "</a>" . " ==========";
						echo "<br>";
						print("<pre>".print_r($row,true)."</pre>"); 
						$resultCounter = $resultCounter+1;
					}					
				}
			}
			
			echo "" . $resultCounter . " total results found.";
			
		} else { 
		
			// get matching phrase from description in tblItems
			$sqlDescription = "SELECT * FROM tblItems WHERE Description LIKE " . "'%" . $searchString . "%'" . " AND Ends > now() ORDER BY Currently ASC;";
			$result = $conn->query($sqlDescription);
		
			
			$sqlDescriptionClosed = "SELECT * FROM tblItems WHERE Description LIKE " . "'%" . $searchString . "%'" . " AND Ends < now() ORDER BY Currently ASC;";
			$resultClosed = $conn->query($sqlDescriptionClosed);
			
			$resultCounter = 0;
			
			// print active auction first, then closed auction
			if($result){
				echo "CURRENT ACTIVE AUCTIONS: ";
				echo "<br>";
				echo "<br>";
				
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
					if($resultCounter < 100){
						$itemIDLink = "ItemID:" . $row['ItemID'];
						echo "========== " . "<a href='bidding.php?ItemID=" . $row['ItemID'] . "&UserID=" . $_GET['UserID'] . "'> " . $itemIDLink . "</a>" . " ==========";
						echo "<br>";
						print("<pre>".print_r($row,true)."</pre>"); 
						$resultCounter = $resultCounter+1;
					}
				}
				
				if($resultCounter === 0){
					echo "No active auctions with given search phrase.";
					echo "<br>";
				}
				
			} 
			
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
			
			if($resultClosed){
				echo "CLOSED AUCTIONS: ";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				while($row = $resultClosed->fetch_array(MYSQLI_ASSOC)){
					if($resultCounter < 100){
						$itemIDLink = "ItemID:" . $row['ItemID'];
						echo "========== " . "<a href='bidding.php?ItemID=" . $row['ItemID'] . "&UserID=" . $_GET['UserID'] . "'> " . $itemIDLink . "</a>" . " ==========";
						echo "<br>";
						print("<pre>".print_r($row,true)."</pre>"); 
						$resultCounter = $resultCounter+1;
					}
				}
				
			} 
			
			
			
			echo "" . $resultCounter . " total results found.";
		}
	}
?>
