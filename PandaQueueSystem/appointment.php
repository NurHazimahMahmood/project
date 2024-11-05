<?php
session_start();
include('dbLogin.php');

if (isset($_GET['PatientID'])) {
    $patientID = $_GET['PatientID'];
    $fullName = $_GET['FullName'];
    $dateOfBirth = $_GET['DateOfBirth'];
    $address = $_GET['Address'];
    $gender = $_GET['Gender'];
    $serviceID = $_GET['ServiceID'];

    // Check if the patient exists
    $checkQuery = "SELECT * FROM patients WHERE PatientID = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("i", $patientID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch service name
        $serviceQuery = "SELECT ServiceName FROM service WHERE ServiceID = ?";
        $stmt = $conn->prepare($serviceQuery);
        $stmt->bind_param("i", $serviceID);
        $stmt->execute();
        $service = $stmt->get_result()->fetch_assoc();
        $serviceName = $service['ServiceName'] ?? 'Service not found';

        // Store patient info in session
        $_SESSION['patient_info'] = [
            'PatientID' => $patientID,
            'fullName' => $fullName,
            'dateOfBirth' => $dateOfBirth,
            'address' => $address,
            'gender' => $gender,
            'serviceName' => $serviceName
        ];
    } else {
        echo "Error: Patient does not exist. Please register first.";
        exit();
    }
} else {
    header("Location: service.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointmentDate = $_POST['Date'];
    $appointmentTime = $_POST['Time'];

    if (!empty($appointmentDate) && !empty($appointmentTime)) {
        // Fetch the last queue number for the selected service
        $queueQuery = "SELECT LastQueueNumber FROM service_queues WHERE ServiceID = ? FOR UPDATE";
        $stmt = $conn->prepare($queueQuery);
        $stmt->bind_param("i", $serviceID);
        $stmt->execute();
        $result = $stmt->get_result();
        $queueData = $result->fetch_assoc();

        $lastQueueNumber = $queueData['LastQueueNumber'] ?? 0;
        $newQueueNumber = $lastQueueNumber + 1;

        // Format the queue number with ServiceID prefix (e.g., 1001, 2002)
        $formattedQueueNumber = $serviceID . str_pad($newQueueNumber, 3, '0', STR_PAD_LEFT);

        // Update the last queue number in the database
        $updateQueueQuery = "UPDATE service_queues SET LastQueueNumber = ? WHERE ServiceID = ?";
        $stmt = $conn->prepare($updateQueueQuery);
        $stmt->bind_param("ii", $newQueueNumber, $serviceID);
        $stmt->execute();

        // Insert the appointment details
        $insertQuery = "INSERT INTO appointment (PatientID, ServiceID, AppointmentDate, AppointmentTime, QueueNumber)
                        VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param('iisss', $patientID, $serviceID, $appointmentDate, $appointmentTime, $formattedQueueNumber);

        if ($stmt->execute()) {
            // Redirect to the confirmation page with queue number as a query parameter
            header("Location: queueNumber.php?queue=" . urlencode($formattedQueueNumber));
            exit();
        } else {
            echo "Error: " . htmlspecialchars($stmt->error);
        }
    } else {
        echo "Please select both appointment date and time.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booking</title>
    <style>
        /* CSS styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #F9D689;
            /* Set background color */
            color: #333;
        }

        .container {
            display: flex;
            justify-content: space-between;
            padding: 30px;
        }

        fieldset {
            border: 1px solid #E0A75E;
            /* Service box color */
            border-radius: 5px;
            padding: 20px;
            background-color: #F5E7B2;
            /* Patient info box color */
            width: 45%;
            font-size: 1.2em;
            /* Increase font size for fieldset */
        }

        legend {
            font-weight: bold;
            color: #973131;
            /* Title color */
            font-size: 1.5em;
            /* Increase font size for legend */
        }

        .info-row {
            margin-bottom: 10px;
            font-size: 1.2em;
            /* Increase font size for info rows */
        }

        .date-time-selection {
            margin-top: 20px;
            font-size: 1.2em;
            /* Increase font size for date/time selection */
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            font-size: 1.2em;
            /* Increase font size for buttons */
        }

        #backButton {
            background-color: #F4C531;
            /* BACK button color */
            color: #333;
            position: absolute;
            /* Positioning for the BACK button */
            bottom: 20px;
            left: 20px;
        }

        #getQueueNumberButton {
            background-color: #973131;
            /* Get Queue Number button color */
            color: white;
            /* Button text color */
            position: absolute;
            /* Positioning for the Get Queue Number button */
            bottom: 20px;
            right: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <fieldset>
            <legend>Patient Details</legend>
            <div class="info-row">
                <span>Patient ID: <span id="PatientID"><?php echo htmlspecialchars($patientID); ?></span></span>
            </div>
            <div class="info-row">
                <span>Patient Name: <span id="FullName"><?php echo htmlspecialchars($fullName); ?></span></span>
            </div>
            <div class="info-row">
                <span>Date Of Birth: <span id="DateOfBirth"><?php echo htmlspecialchars($dateOfBirth); ?></span></span>
            </div>
            <div class="info-row">
                <span>Address: <span id="Address"><?php echo htmlspecialchars($address); ?></span></span>
            </div>
            <div class="info-row">
                <span>Gender: <span id="Gender"><?php echo htmlspecialchars($gender); ?></span></span>
            </div>
            <div class="info-row">
                <span>Service Name: <span id="ServiceName"><?php echo htmlspecialchars($serviceName); ?></span></span>
            </div>
            <button id="backButton" onclick="goBack()">← BACK</button>
        </fieldset>

        <fieldset>
            <legend>Select Appointment Date and Time</legend>
            <form method="POST" action="">
                <div class="date-time-selection">
                    <label for="Date">Choose Date:</label>
                    <input type="date" id="Date" name="Date" required>

                    <label for="Time">Choose Time:</label>
                    <input type="time" id="Time" name="Time" required>
                </div>
                <button type="submit" id="getQueueNumberButton">Get Queue Number</button>
            </form>
        </fieldset>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>