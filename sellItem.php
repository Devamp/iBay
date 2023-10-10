
<html>
<head> <title> Selling Page </title> 

</head>

<br><br> 
<center><h2> Item Selling Form </h2>
 
<h3> Please fill out the sell form below with information about your item.</h3>
***********************************************************************************
<br> <br> 

<body>

<!-- form to allow user to sell an item by filling out important info about the item -->
<form action="sellItem.php" method="GET">

	<input type="hidden" name="UserID" value="<?php echo $_GET['UserID']; ?>">
	Item Name : <input type="text" name="ItemName" required>
	<br><br>
	Buy Price : <input type="text" name="BuyPrice" required>
	<br><br>
	Item Category : <input type="text" name="Category" required>
	<br><br>
	Location : <input type="text" name="Location" required>
	<br><br>
	Country : <input type="text" name="Country" required>
	<br><br>
	End Time : <input type="text" name="EndTime" required>
	<br><br>
	Seller : <input type="text" name="SellerID" value="<?php echo $_GET['UserID']; ?>" readonly>
	<br><br>
	Description : <input type="text" name="Description" required>
	<br><br> 
	
	<button type="submit">Add to Auction</button>
	
</form>

<form action="search.php" method="GET">
		<input type="hidden" name="UserID" value="<?php echo $_GET['UserID']; ?>">
		<button type="submit">Return to Search</button>
</form>



<?php 
	// before selling, verify user cookie
	function verifyCookie(){
		$cookieName = "user";
		if($_COOKIE[$cookieName] != $_GET['UserID']) {
			echo '<script>alert("Invalid cookie authorization. Please login again.")</script>';
			header("Refresh: 0.5; url=login.php");
			return FALSE;
			
		}
		return TRUE;
	}
	

	if(count($_GET) > 0 && verifyCookie()){

		// create item attributes to insert
		$ItemName = $_GET['ItemName'];
		$Currently = 0;
		$Buy_Price = $_GET['BuyPrice'];
		$First_Bid = 0;
		$numBids = 0;
		$Location = $_GET['Location'];
		$Country = $_GET['Country'];
		$Started = "now()";
		$Ends = $_GET['EndTime'];
		$Seller = $_GET['UserID'];
		$Description = $_GET['Description'];
		
		$conn = new mysqli("localhost", "devam", "cs434", "AuctionDatabase");

		if($conn->connect_errno) {
			echo "Failed to connect to MySQL: ". $conn -> connect_error;
			exit();
		} 
		
		$ItemID = 0;
		
		$sqlItemID = "select MAX(ItemID) as count from tblItems Order by ItemID ASC;";
		$resultItem = $conn->query($sqlItemID);
		
		if($resultItem){
			while($row = $resultItem->fetch_array(MYSQLI_ASSOC)){
				$ItemID = $row['count'] + 1;
				
			}
		}
		
		// sql query to insert
		$sql =
		"INSERT INTO tblItems VALUES ("
		.$ItemID. ","
		. "\"" .$ItemName. "\","
		.$Currently. ","
		.$Buy_Price. ","
		.$First_Bid. ","
		.$numBids. ","
		. "\"" .$Location. "\","
		. "\"" .$Country. "\","
		.$Started. ","
		. "\"" .$Ends . "\"" . ","
		. "\"".$Seller. "\"" . ","
		. "\"".$Description."\"" . ");";
		
		$result = $conn->query($sql);
		
		// update tblCategory and tblItemCateogry depending on if category exists or needs to be added
		if($result){
			
			// check if category exists
			$sqlCatInsert = "SELECT * from tblCategory WHERE Name = " . '\'' . $_GET['Category'] . '\''.";";
			$categoryInsert = $conn->query($sqlCatInsert);
			
		
				
			
			// category found
			if($categoryInsert->num_rows == 1){
				//update tblItemCategory
				while($row = $categoryInsert->fetch_array(MYSQLI_ASSOC)){
					$sqlItemCateogry = "INSERT INTO tblItemCategory VALUES ( ". $ItemID ."," . $row['CategoryID'] . ");";
					$itemCategoryResult = $conn->query($sqlItemCateogry);
					$categoryIDFound = $row['CategoryID'];
				}

				
				
			} else { // category doesnt exist so create new
			
				$categoryIDCount = 0;
				$countResult = $conn->query("SELECT COUNT(*) as count from tblCategory;");
				if($countResult){
					while($row = $countResult->fetch_array(MYSQLI_ASSOC)){
						$categoryIDCount = $row['count'] + 1;
					}
				}
				
				// insert new category
				$resultNewInsert = $conn->query("INSERT INTO tblCategory VALUES (".$categoryIDCount.",'".$_GET['Category']."');");
				
				// update tblItemCategory
				$sqlItemCateogry = "INSERT INTO tblItemCategory VALUES ( ". $ItemID ."," . $categoryIDCount . ");";
				$itemCategoryResult = $conn->query($sqlItemCateogry);			
			} 
			
			
			
			// print item summary for the user once the item has been put up for auction
			echo "Item was successfully put up for auction!<br>Here is your summary: ";
			echo "<br>";
			$qResult = $conn->query("SELECT * FROM tblItems WHERE ItemID = " . $ItemID . ";");
			while($row = $qResult->fetch_array(MYSQLI_ASSOC)){
				print("<pre>".print_r($row,true)."</pre>"); 
			}
			
		}

	
	
	}

?>
