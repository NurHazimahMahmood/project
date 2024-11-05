<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent's Registration</title>
    <link rel="stylesheet" href="parent.css">
</head>
<body>
	<div class="container">
        <form method="POST" id="registrationForm">
            <fieldset>
                <legend>Parent/Guardian Information</legend>
                <div class="row">
                    <div class="column">
                        <label for="firstName">First Name:</label>
                        <input type="text"name="FName" required>
                    </div>
                    <div class="column">
                        <label for="lastName">Last Name:</label>
                        <input type="text" name="LName" required>
                    </div>
                </div>

                <div class="row">
                    <div class="column">
                        <label for="gender">Gender:</label>
                        <select id="gender" name="Gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="column">
                        <label for="relationship">Relationship to the Child:</label>
                        <input type="text" name="Relationship" required>
                    </div>
                </div>

                <div class="row">
                    <div class="column">
                        <label for="contact">Phone Number:</label>
                        <input type="tel" name="PhoneNumber" required>
                    </div>
                    <div class="column">
                        <label for="email">Email Address:</label>
                        <input type="email" name="Email" required>
                    </div>
                </div>

                <label for="guardianAddress">Address:</label>
                <textarea id="guardianAddress" name="Address" required></textarea>
				
				<h1>Login Information</h1>
				<div>
					<label for="username">Username:</label>
					<input type="text" name="Username" required>
				</div>
				
				<div>
					<label for="password">Password:</label>
					<input type="password" name="Password" required>
				</div>

            </fieldset>
            <button type="submit" id="registerButton">Submit</button>
        </form>
    </div>

    <script src="parent.js"></script>
</body>
</html>

<?php
include('dbLogin.php');
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $Firstname = $_POST['FName'];  
    $Lastname = $_POST['LName'];
    $Relationship = $_POST['Relationship'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $Email = $_POST['Email'];
    $Address = $_POST['Address']; 
    $Gender = $_POST['Gender'];
    $Username = $_POST['Username']; 
    $Password = $_POST['Password']; 
    $userType = 'user'; 

    if (!empty($Username) && !empty($Password) && !is_numeric($Username)) {
        $query = "INSERT INTO `users` (`Username`, `Password`, `FName`, `LName`, `Relationship`, `PhoneNumber`, 
        `Email`, `Address`, `Gender`, `userType`) 
        VALUES ('$Username', '$Password', '$Firstname', '$Lastname', 
        '$Relationship', '$PhoneNumber', '$Email', '$Address', '$Gender', '$userType')";

        if (mysqli_query($conn, $query)) {  
            echo "<script type='text/javascript'> alert('Signup is Successful')</script>";
            header("Location: index.php");
            exit();
        } else {
            echo "<script type='text/javascript'> alert('Error: " . mysqli_error($conn) . "')</script>";
        }
    } else {
        echo "<script type='text/javascript'> alert('Signup is Unsuccessful. Please enter valid information!')</script>";
    }
}

?>
