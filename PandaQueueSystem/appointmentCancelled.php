<?php
session_start();

// Clear appointment data if needed
if (isset($_SESSION['appointment_data'])) {
    unset($_SESSION['appointment_data']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Cancelled</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f2f2f2;
        }

        .message-box {
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #F5E7B2;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #800000;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #6b0000;
        }
    </style>
</head>

<body>
    <div class="message-box">
        <h2>You Already Cancelled Your Appointment</h2>
        <p>You can register for another child or go back to the previous page.</p>
        <a href="patient.php"><button class="back-button">Go to Registration</button></a>
    </div>
</body>

</html>