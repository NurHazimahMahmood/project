<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panda Login Form | SortedCoding</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container">
        <form name="form1" method="POST">
            <label for="username">Username:</label>
            <input name="Username" type="text" id="username" placeholder="Enter username" required /><br>
            <label for="password">Password:</label>
            <input name="Password" type="password" id="password" placeholder="Enter password" required /><br>
            <p>Don't have an account? <a href="parent.php">Sign up here</a></p>
            <button type="submit" value="Login">Log In</button>
    </form>

        
    <div class="ear-l"></div>
    <div class="ear-r"></div>
    <div class="panda-face">
        <div class="blush-l"></div>
        <div class="blush-r"></div>
        <div class="eye-l">
            <div class="eyeball-l"></div>
        </div>
        <div class="eye-r">
            <div class="eyeball-r"></div>
        </div>
        <div class="nose"></div>
        <div class="mouth"></div>
    </div>
    <div class="hand-l"></div>
    <div class="hand-r"></div>
    <div class="paw-l"></div>
    <div class="paw-r"></div>
</div>
    
    <script src="index.js"></script>
	
</body>
</html>

<?php
session_start();

include('dbLogin.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];

    if (!empty($Username) && !empty($Password) && !is_numeric($Username)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE Username = ? AND Password = ?");
        $stmt->bind_param("ss", $Username, $Password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) { 
            $user = $result->fetch_assoc();
            $_SESSION['UserID'] = $user['UserID'];

            // Check user type and redirect accordingly
            if ($user['userType'] == 'admin') {
                header("Location: UserListEdited.php"); // Redirect to admin page
            } elseif ($user['userType'] == 'user') {
                header("Location: patient.php"); // Redirect to user service page
            }
            exit(); // Ensure to exit after redirection
        } else {
            echo "<script type='text/javascript'>alert('Wrong username or password');</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('Please fill in all fields correctly.');</script>";
    }
}

$conn->close();
?>
