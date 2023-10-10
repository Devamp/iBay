


<html>
<head>
	<title>iBay Sign Up</title>
	
	<style>   
Body {  
  font-family: Calibri, Helvetica, sans-serif;  
  background-color: #C7FFAC;  
}  
button {   
       background-color: #4CAF50;   
       width: 100%;  
        color: orange;   
        padding: 15px;   
        margin: 10px 0px;   
        border: none;   
        cursor: pointer;   
         }   
 form {   
 	margin-left: 690px;
        width: 440px;
        border: 3px solid black;   
    }   
 input[type=text], input[type=password] {   
        width: 100%;   
        margin: 8px 0;  
        padding: 12px 20px;   
        display: inline-block;   
        border: 2px solid green;   
        box-sizing: border-box;   
    }  
 button:hover {   
        opacity: 0.7;   
    }     
            
 .container {   
        padding: 20px;
        background-color: #B3FFF4;  
        width: 400px;
    }   
</style>   
</head>

<body>


  <center> <h1> Sign Up For iBay! </h1> </center>   

<!-- simple sign up form for user to register into tblUsers-->
  <form action="signup.php" method="post">  
        <div class="container">   
            <label>New Username : </label>   
            <input type="text" placeholder="Enter Username" name="newUsername" required>  
            <label>New Password : </label>   
            <input type="password" placeholder="Enter Password" name="newPassword" required> 
            <label>Location : </label>   
            <input type="text" placeholder="Enter Location" name="newLocation"> 
            <label>Country : </label>   
            <input type="text" placeholder="Enter Country" name="newCountry"> 
            <button type="submit">Sign Up</button>  
            <span class="psw">Return to <a href="login.php"> Login </a></span> 
        </div>   
    </form> 




</body>
</html>

<center>
<?php
	
	// function to hash password
	function getHashedPassword($password){
		return hash('ripemd160', $password);
	}
	
	
	// upon submission, setup connection and insert user info into tblUsers with hashed password
	if (count($_POST) > 0) {
	    $isSuccess = 0;
	    $conn = new mysqli("localhost", "devam", "cs434", "AuctionDatabase");
	    
		if($conn->connect_errno) {
			echo "Failed to connect to MySQL: ". $conn -> connect_error;
			exit();
		} 
	    	
    		$username = $_POST['username'];
    		
    		// userid rating location country password
		$sql = "INSERT INTO tblUsers (UserID, Rating, Location, Country, Password) VALUES (" . "\"" . $_POST['newUsername']. "\"," . "0," . "\"" . $_POST['newLocation']. "\"," . "\"" . $_POST['newCountry']. "\"," .  "\"" . getHashedPassword($_POST['newPassword']) . "\"" . ");";
		
		if ($conn->query($sql) === TRUE) {
		  echo "Registration was successful! Please return to the login page and sign in.";
		} else {
		  echo "Error: " . $sql . "<br>" . $conn->error;
		}
	        
		
		$conn->close();
	}

?>
</center>
