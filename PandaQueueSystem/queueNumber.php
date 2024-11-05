<?php
// Retrieve the queue number from the query parameter
$queueNumber = $_GET['queue'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Queue Number</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F9D689;
            color: #333;
            padding: 20px;
            text-align: center;
        }

        .queue-number {
            font-size: 3em;
            font-weight: bold;
            margin-top: 50px;
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Your Appointment</h1>
    <p class="queue-number">Queue Number: <strong><?php echo htmlspecialchars($queueNumber); ?></strong></p>

    <button onclick="goHome()">← HOME</button>

    <script>
        function goHome() {
            window.location.href = 'patient.php';
        }
    </script>
</body>

</html>