<?php 
session_start();

// Check if there is an appointment to cancel
if (!isset($_SESSION['appointment_data'])) {
    // Redirect to the appointment page if no appointment is found
    header("Location: appointment.php");
    exit;
}

// Handle the cancellation request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Clear the appointment data from session
    unset($_SESSION['appointment_data']);
    
    // Redirect to a confirmation page
    header("Location: appointmentCancelled.php");
    exit;
}

$appointmentData = $_SESSION['appointment_data'];
$fullName = $appointmentData['FullName'] ?? '';
$serviceName = $appointmentData['ServiceName'] ?? '';
$appointmentDate = $appointmentData['date'] ?? '';
$appointmentTime = $appointmentData['time'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Appointment</title>
    <link rel="stylesheet" href="cancelAppointment.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #F9D689; 
            color: #333;
        }

        .container {
            background-color: #F5E7B2; 
            border: 1px solid #E0A75E; 
            border-radius: 5px;
            padding: 20px;
            max-width: 600px; 
            margin: auto; 
            position: relative;
        }

        h2 {
            margin-top: 0;
        }

        p {
            font-size: 1.5em; 
            margin: 5px 0; 
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            margin: 5px; 
        }

        #confirmCancelBtn {
            background-color: #973131; 
            color: white; 
            position: absolute;
            bottom: -50px; 
            left: 0; 
        }

        #goBackBtn {
            background-color: #F4C531; 
            color: #333;
            position: absolute;
            bottom: -50px; 
            right: 0; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cancel Appointment</h2>
        <p>Are you sure you want to cancel your appointment?</p>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($fullName); ?></p>
        <p><strong>Service:</strong> <?php echo htmlspecialchars($serviceName); ?></p>
        <p><strong>Appointment Date:</strong> <?php echo htmlspecialchars($appointmentDate); ?></p>
        <p><strong>Appointment Time:</strong> <?php echo htmlspecialchars($appointmentTime); ?></p>

        <!-- Buttons positioned below the information box -->
        <button id="confirmCancelBtn">Yes, Cancel Appointment</button>
        <a href="queueNumber.php"><button type="button" id="goBackBtn">No, Go Back</button></a>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Are you really sure you want to cancel this appointment?</p>
            <form method="POST" action="">
                <button type="submit">Yes, Cancel</button>
                <button type="button" class="close">No, Keep Appointment</button>
            </form>
        </div>
    </div>

    <style>
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0, 0, 0, 0.4); 
        }

        .modal-content {
            background-color: #F9D689; 
            margin: 15% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
            border-radius: 5px; 
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

        <script>
            var modal = document.getElementById("myModal");
            var btn = document.getElementById("confirmCancelBtn");
            var span = document.getElementsByClassName("close");
            btn.onclick = function() {
                modal.style.display = "block";
            }

            for (let i = 0; i < span.length; i++) {
                span[i].onclick = function() {
                    modal.style.display = "none";
                }
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
</body>
</html>
