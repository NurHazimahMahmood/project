<?php
include('dbLogin.php');

// Fetch relevant data from the patient table
$sql = "SELECT p.PatientID, p.FullName, p.DateOfBirth, p.Address, p.Gender, 
               a.AppointmentDate, a.AppointmentTime, a.QueueNumber
        FROM patients p
        LEFT JOIN appointment a ON p.PatientID = a.PatientID"; 
$rs_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        body {
            background-color: #96B6C5; 
            font-family: Arial, sans-serif;
            color: #333; 
            margin: 0;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 1.5em; 
        }

        th {
            background-color: #4682A9;
            color: #FFF; 
            padding: 10px; 
        }

        td {
            padding: 10px;
            color: #333; 
        }

        tr:nth-child(even) {
            background-color: #F1F0E8; 
        }

        button {
            background-color: #F1F0E8; 
            color: #333; 
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1.2em; 
            margin-top: 20px; 
        }

        button:hover {
            background-color: #D8D8D8;
        }

        p {
            font-size: 2em;
            text-align: center; 
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <form name="FormUserList" action="" method="POST">
        <p><strong>List of Patients</strong></p>
        <table border="1">
            <tr>
                <th>Patient ID</th>
                <th>Full Name</th>
                <th>Date Of Birth</th>
                <th>Address</th>
                <th>Gender</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Queue Number</th>
            </tr>

            <?php while ($row = $rs_result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row["PatientID"]; ?></td>
                <td><?php echo $row["FullName"]; ?></td>
                <td><?php echo $row["DateOfBirth"]; ?></td>
                <td><?php echo $row["Address"]; ?></td>
                <td><?php echo $row["Gender"]; ?></td>
                <td><?php echo $row["AppointmentDate"] ?? 'N/A'; ?></td> <!-- Display N/A if no appointment -->
                <td><?php echo $row["AppointmentTime"] ?? 'N/A'; ?></td>
                <td><?php echo $row["QueueNumber"] ?? 'N/A'; ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="6"><a href='UserListEdited.php'>Refresh Listing</a></td>
            </tr>
        </table>
        <div class="button-container">
            <button id="exit-button" onclick="location.href='index.php'" type="button">Log Out</button>
        </div>
    </form>
</body>
</html>
