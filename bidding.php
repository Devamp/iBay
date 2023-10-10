
<html>
<head> <title> Bidding Page </title> 

</head>

<br><br> 
<center><h2> Bidding Form: <?php

// create connection to DB
$conn = new mysqli("localhost", "devam", "cs434", "AuctionDatabase");
			
			if($conn->connect_errno) {
				echo "Failed to connect to MySQL: ". $conn -> connect_error;
				exit();
			}
			
			// get ItemID from db and print on bidding page
			$sql = "select ItemName as name from tblItems where ItemID =".$_GET['ItemID'].";";
			$result = $conn->query($sql);
			if($result){
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
					echo $row['name'];
				}
			}
			
 ?> </h2>
 
<h3> Please veify the information below and place your bid.</h3>
***********************************************************************************
<br> <br> 

<body>
	<!-- Form which submits to placeBid once user clicks bid button,
	     the form also reads all of the item attributes from DB and prints updated values
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
	
	<!-- on click of submit button, this page will be called again and execute php code-->
	<form action="search.php" method="GET">
		<input type="hidden" name="UserID" value="<?php echo $_GET['UserID']; ?>">
		<button type="submit">Return to Search</button>
	</form>

</body>
</center>
</html>

<?php
	
	// function to verify the current user's login
	function verifyCookie(){
		$cookieName = "user";
		if($_COOKIE[$cookieName] != $_GET['UserID']) {
			echo '<script>alert("Invalid cookie authorization. Please login again.")</script>';
			header("Refresh: 0.5; url=login.php");
			return FALSE;
			
		}
		return TRUE;
	}
	
	// function which is called when auction is closed, to print the error message and redirect user
	function auctionClosed(){
		echo '<script>alert("Bidding for this item has CLOSED. You will be redirected to search page.")</script>';
		header("Refresh: 0.5; url=search.php?UserID=".$_GET['UserID']);
	}
	
	
	// when user is verified, create db connection and allow user to bid
	if(verifyCookie() === TRUE){
		//process bid
		$conn = new mysqli("localhost", "devam", "cs434", "AuctionDatabase");
		    
		   
		if($conn->connect_errno) {
			echo "Failed to connect to MySQL: ". $conn -> connect_error;
			exit();
		}
		
		// query to check if current item is listed as active
		$sql = "SELECT * FROM tblItems WHERE ItemID = ".$_GET['ItemID']." AND Ends > now();";
		$result = $conn->query($sql);
		
		
		if($result){
			// if numRows == 0; that means the auction is already closed.
			if($result->num_rows === 0){
				auctionClosed();
			} 		
		}
	}
	
?>

