
<html>
<head> <title> Bidding Page </title> 

</head>

<br><br> 
<center><h2> Bidding Form: Item <?php echo $_GET['ItemID']; ?> </h2>
 
<h3> Please veify the information below and place your bid.</h3>
***********************************************************************************
<br> <br> 

<body>


<!-- form which reports current item attributes and allows user to bid
     create connect and get values for all item attributes from db
-->
<form action="placeBid.php" method="GET">
		<div class="container">   
		<label>Your UserID : </label>
		<input name="UserID" value=<?php echo $_GET['UserID']; ?> readonly>
		<br><br>
		<label>Bidding ItemID : </label>   
		<input name="ItemID" value=<?php echo $_GET['ItemID']; ?> readonly>
		<br><br>
		<label>Number of Bids : <?php 
			$conn = new mysqli("localhost", "devam", "cs434", "AuctionDatabase");
			
			if($conn->connect_errno) {
				echo "Failed to connect to MySQL: ". $conn -> connect_error;
				exit();
			}
			
			$sql = "select Number_of_Bids as numBids from tblItems where ItemID =".$_GET['ItemID'].";";
			$result = $conn->query($sql);
			if($result){
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
					echo $row['numBids'];
				}
			}
		
		?> </label>   
		<br><br>    
		<label>Buy Price : <?php 
			$conn = new mysqli("localhost", "devam", "cs434", "AuctionDatabase");
			
			if($conn->connect_errno) {
				echo "Failed to connect to MySQL: ". $conn -> connect_error;
				exit();
			}
			
			$sql = "select Buy_price as buyPrice from tblItems where ItemID =".$_GET['ItemID'].";";
			$result = $conn->query($sql);
			if($result){
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
					echo $row['buyPrice'];
				}
			}
		
		?></label>   
		<br><br> 
		<label>Location : <?php 
			$conn = new mysqli("localhost", "devam", "cs434", "AuctionDatabase");
			
			if($conn->connect_errno) {
				echo "Failed to connect to MySQL: ". $conn -> connect_error;
				exit();
			}
			
			$sql = "select Location as location from tblItems where ItemID =".$_GET['ItemID'].";";
			$result = $conn->query($sql);
			if($result){
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
					echo $row['location'];
				}
			}
		
		?> </label>   

		<br><br>    
		<label>Country : <?php 
			$conn = new mysqli("localhost", "devam", "cs434", "AuctionDatabase");
			
			if($conn->connect_errno) {
				echo "Failed to connect to MySQL: ". $conn -> connect_error;
				exit();
			}
			
			$sql = "select Country as country from tblItems where ItemID =".$_GET['ItemID'].";";
			$result = $conn->query($sql);
			if($result){
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
					echo $row['country'];
				}
			}
		
		?></label> 

		<br><br>   
		<label>Started : <?php 
			$conn = new mysqli("localhost", "devam", "cs434", "AuctionDatabase");
			
			if($conn->connect_errno) {
				echo "Failed to connect to MySQL: ". $conn -> connect_error;
				exit();
			}
			
			$sql = "select Started as start from tblItems where ItemID =".$_GET['ItemID'].";";
			$result = $conn->query($sql);
			if($result){
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
					echo $row['start'];
				}
			}
		
		?> </label>   

		<br><br>   
		<label>Ends : <?php 
			$conn = new mysqli("localhost", "devam", "cs434", "AuctionDatabase");
			
			if($conn->connect_errno) {
				echo "Failed to connect to MySQL: ". $conn -> connect_error;
				exit();
			}
			
			$sql = "select Ends as end from tblItems where ItemID =".$_GET['ItemID'].";";
			$result = $conn->query($sql);
			if($result){
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
					echo $row['end'];
				}
			}
		
		?>  </label>

		<br><br>   
		<label>Seller : <?php 
			$conn = new mysqli("localhost", "devam", "cs434", "AuctionDatabase");
			
			if($conn->connect_errno) {
				echo "Failed to connect to MySQL: ". $conn -> connect_error;
				exit();
			}
			
			$sql = "select Seller as sell from tblItems where ItemID =".$_GET['ItemID'].";";
			$result = $conn->query($sql);
			if($result){
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
					echo $row['sell'];
				}
			}
		
		?></label>     

		<br><br>   
		<label>Description : <?php 
			$conn = new mysqli("localhost", "devam", "cs434", "AuctionDatabase");
			
			if($conn->connect_errno) {
				echo "Failed to connect to MySQL: ". $conn -> connect_error;
				exit();
			}
			
			$sql = "select Description from tblItems where ItemID =".$_GET['ItemID'].";";
			$result = $conn->query($sql);
			if($result){
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
					echo $row['Description'];
				}
			}
		
		?> </label>   
		<br><br>   
		<br><br>   

		<label>Highest Bidder : <?php 
			$conn = new mysqli("localhost", "devam", "cs434", "AuctionDatabase");
			
			if($conn->connect_errno) {
				echo "Failed to connect to MySQL: ". $conn -> connect_error;
				exit();
			}
			
			$sql = "select UserID from tblBids where ItemID = ".$_GET['ItemID']." order by Amount DESC limit 1;";
			$result = $conn->query($sql);
			if($result){
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
					echo $row['UserID'];
				}
			}
		
		?> </label> 

		<br><br>  
		<label>Current Amount ($) : <?php 
			$conn = new mysqli("localhost", "devam", "cs434", "AuctionDatabase");
			
			if($conn->connect_errno) {
				echo "Failed to connect to MySQL: ". $conn -> connect_error;
				exit();
			}
			
			$sql = "SELECT Currently AS Currently FROM tblItems WHERE ItemID = ".$_GET['ItemID'].";";
			$result = $conn->query($sql);
			if($result){
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
					echo $row['Currently'];
				}
			}
		?>  </label>   
		<br><br>  
		<label>Your Bid Amount ($) : </label>   
		<input type="text" name="bidAmount">  
		<br><br>  
		<button type="submit">Place Bid</button>  	
		</div>   
	</form>
	
	<form action="search.php" method="GET">
		<input type="hidden" name="UserID" value="<?php echo $_GET['UserID']; ?>">
		<button type="submit">Return to Search</button>
	</form>
</body>
</center>
</html>

<?php
	
	// function when item is open for auction, allows user to place bid after some error checking
	function auctionIsOpen($conn){
		$bidAmount = $_GET['bidAmount'];
		
		
		$conn = new mysqli("localhost", "devam", "cs434", "AuctionDatabase");
			
		if($conn->connect_errno) {
			echo "Failed to connect to MySQL: ". $conn -> connect_error;
			exit();
		}
		
		// get current price from db and verify bid amount is valid
		$sql = "SELECT Currently AS Currently FROM tblItems WHERE ItemID = ".$_GET['ItemID'].";";
		$result = $conn->query($sql);
		if($result){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$currentAmount = $row['Currently'];
			}
		}
			
		
		if($bidAmount <= $currentAmount){
			echo '<script>alert("Bid amount must be greater than current amount!")</script>';
			
		} else {
		
			// create sql query for tblBid and insert the bid amount
			$numBids = 0;
			$resultNumBids = $conn->query("SELECT COUNT(BidID) as numBids FROM tblBids;");
			if($resultNumBids){
				while($row = $resultNumBids->fetch_array(MYSQLI_ASSOC)){
					$numBids = $row['numBids'];
				}
			}
			
			if($numBids != 0){
			
				// insert data into db
				$numBids = $numBids + 1;
				$sqlInsert = "INSERT INTO tblBids VALUES (".$numBids.","."\"".$_GET['UserID']."\",".$_GET['ItemID'].","."now(),".$bidAmount.");";
				$resultInsert = $conn->query($sqlInsert);
				if(!$resultInsert){
					echo '<script>alert("ERROR: Failed to place bid.")</script>';
				} else {
					echo '<script>alert("SUCCESS: Bid Placed Successfully.")</script>';
					header("Refresh: 0.5; url=bidding.php?UserID=".$_GET['UserID']."&ItemID=".$_GET['ItemID']);
					
				}
				
			} else {
				echo "Error: numBids failed to update!";
			}
		}
		
		
	}
	
	
	
	//entry point for placeBid.php
	$conn = new mysqli("localhost", "devam", "cs434", "AuctionDatabase");
	    
	if($conn->connect_errno) {
		echo "Failed to connect to MySQL: ". $conn -> connect_error;
		exit();
	}
	
	// query to check if current item is listed as active
	$sql = "SELECT * FROM tblItems WHERE ItemID = ".$_GET['ItemID']." AND Ends > now();";
	$result = $conn->query($sql);
	
	// if item is active, call auctionIsOpen()
	if($result){
		auctionIsOpen($conn);				
	}
	
	
	
	




?>
