<?php

	// create cookie for user upon successful login
	if (count($_POST) > 0) {
		$cookie_name = "user";
		$cookie_value = $_POST['username'];
		setcookie($cookie_name, $cookie_value);
	}
?>



<html>
<head>
	<title>iBay Login</title>
	
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


  <center> <h1> Welcome to iBay! </h1> </center>   
  <center> <h2> Please login or sign up </h2> </center>   

  <!-- form for user to input username and password and login -->
  <form action="login.php" method="POST">  
        <div class="container">   
            <label>Username : </label>   
            <input type="text" placeholder="Enter Username" name="username" required>  
            <label>Password : </label>   
            <input type="password" placeholder="Enter Password" name="password" required>  
            <button type="submit">Login</button>  
            <span class="psw">New User? <a href="signup.php"> Sign Up</a></span> 
        </div>   
    </form> 




</body>
</html>

<center>
<?php 
	
	
	$message = "";
	
	// when login is clicked, create connection to db and hash password and insert into db
	if (count($_POST) > 0) {
	    $isSuccess = 0;
	    $conn = new mysqli("localhost", "devam", "cs434", "AuctionDatabase");
	    
		if($conn->connect_errno) {
			echo "Failed to connect to MySQL: ". $conn -> connect_error;
			exit();
		}
	    	
    		$username = $_POST['username'];
		$sql = "SELECT * FROM tblUsers WHERE UserID = " . "\"" . $username . "\"" . ";";

		$result = $conn->query($sql);
		if($result){
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$expected = hash('ripemd160', $_POST['password']);
				if($expected === $row['Password']){
					$isSuccess = 1;
				}
			}
			
		} else {
			echo "No rows found.";
		}
		
		
		$result->close();
	        
		if ($isSuccess == 0) {
			$message = "Invalid Username or Password!";
			echo $message;
			
		} else {
		
			// after login, redirect user to search page
			header("Location: http://localhost/patelde23/search.php?UserID=" . $_POST['username']);
		}
		
		$conn->close();
	}

	
?>
</center>




