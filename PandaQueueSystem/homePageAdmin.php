<?php
include('dbLogin.php');

$editPatientId = null;
$fullName = $dateOfBirth = $address = $gender = '';

// Check if editing a patient
if (isset($_GET['edit'])) {
    $editPatientId = $_GET['edit'];

    // Fetch the patient details to pre-fill the form
    $stmt = $conn->prepare("SELECT FullName, DateOfBirth, Address, Gender FROM patients WHERE PatientID = ?");
    $stmt->bind_param("i", $editPatientId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
        $fullName = $patient['FullName'];
        $dateOfBirth = $patient['DateOfBirth'];
        $address = $patient['Address'];
        $gender = $patient['Gender'];
    }
    $stmt->close();
}

// Handle POST requests for adding, updating, and deleting patients
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $action = $data['action'];

    switch ($action) {
        case 'add':
            // Adding a new patient
            $fullName = $conn->real_escape_string($data['FullName']);
            $dateOfBirth = $conn->real_escape_string($data['DateOfBirth']);
            $address = $conn->real_escape_string($data['Address']);
            $gender = $conn->real_escape_string($data['Gender']);

            $sql = "INSERT INTO `patients` (`FullName`, `DateOfBirth`, `Address`, `Gender`)
                    VALUES ('$fullName', '$dateOfBirth', '$address', '$gender')";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(['message' => 'Patient added successfully.']);
            } else {
                echo json_encode(['message' => 'Error adding patient: ' . $conn->error]);
            }
            break;

        case 'update':
            // Updating an existing patient
            $patientId = $conn->real_escape_string($data['PatientId']);
            $fullName = $conn->real_escape_string($data['FullName']);
            $dateOfBirth = $conn->real_escape_string($data['DateOfBirth']);
            $address = $conn->real_escape_string($data['Address']);
            $gender = $conn->real_escape_string($data['Gender']);

            $sql = "UPDATE patients SET FullName='$fullName', DateOfBirth='$dateOfBirth',
                    Address='$address', Gender='$gender'
                    WHERE PatientID='$patientId'";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(['message' => 'Patient updated successfully.']);
            } else {
                echo json_encode(['message' => 'Error updating patient: ' . $conn->error]);
            }
            break;

        case 'delete':
            // Deleting a patient
            $patientId = $conn->real_escape_string($data['PatientId']);

            $sql = "DELETE FROM patients WHERE PatientID='$patientId'";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(['message' => 'Patient deleted successfully.']);
            } else {
                echo json_encode(['message' => 'Error deleting patient: ' . $conn->error]);
            }
            break;

        default:
            echo json_encode(['message' => 'Invalid action.']);
            break;
    }

    $conn->close();
    exit; // Prevent further output
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            background-color: #96B6C5; 
            font-family: Arial, sans-serif;
            color: #333; 
            margin: 0;
            padding: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            text-align: center;
        }

        .container {
            background-color: #F1F0E8; 
            padding: 20px;
            border-radius: 5px;
        }

        .label-container {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-size: 1.2em; 
        }

        input[type="text"], input[type="date"], select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1em; 
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .button-container button {
            background-color: #4682A9; 
            color: #FFF; 
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1.2em; 
            width: 30%; /* Adjusted width for better layout */
            margin-right: 10px; /* Add spacing between buttons */
        }

        .button-container button:last-child {
            margin-right: 0; /* Remove margin from the last button */
        }

        .logout-container {
            margin-top: 10px; /* Added margin for spacing */
            text-align: center; /* Center align the back button */
        }

        .logout-container button {
            width: 20%; 
            background-color: #4682A9; 
            color: #FFF; 
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            font-size: 1.2em; 
        }

        .logout-container button:hover {
            background-color: #355D79; 
        }

        #message {
            text-align: center;
            font-size: 1.2em; 
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>WELCOME ADMIN</h1>
    </header>
    <main>
    <div class="container"> <!-- Wrap content in a container for styling -->

        <h2>Patient Details</h2> <!-- Added heading for clarity -->
        
        <div class="label-container">
            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" placeholder="Enter Full Name" value="<?php echo htmlspecialchars($fullName); ?>" required>
        </div>

        <div class="row"> <!-- New row for the next set of fields -->
            <div class="label-container">
                <label for="dateOfBirth">Date of Birth:</label>
                <input type="date" id="dateOfBirth" value="<?php echo htmlspecialchars($dateOfBirth); ?>" required>
            </div>
        </div>

        <div class="row"> <!-- New row for address and gender -->
            <div class="label-container">
                <label for="address">Address:</label>
                <input type="text" id="address" placeholder="Enter Address" value="<?php echo htmlspecialchars($address); ?>" required>
            </div>

            <div class="label-container">
                <label for="gender">Gender:</label>
                <select id="gender">
                    <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>
        </div>

        <div id="message"></div>

        <div class="button-container"> <!-- Button container for styling -->
            <button onclick="managePatient('add')">Add Patient</button>
            <button onclick="managePatient('update')">Update Patient</button>
            <button onclick="managePatient('delete')">Delete Patient</button>
        </div>

        <!-- Log Out Button -->
        <div class="logout-container">
            <button id="backButton" onclick="location.href='UserListEdited.php'" type="button">← BACK</button>
        </div>
    </div>
</main>

    <script>
        function managePatient(action) {
            const FullName = document.getElementById('fullName').value;
            const DateOfBirth = document.getElementById('dateOfBirth').value;
            const Address = document.getElementById('address').value;
            const Gender = document.getElementById('gender').value;

            // If updating or deleting, get the PatientId (assumed to be passed in query string)
            const PatientId = "<?php echo $editPatientId; ?>";

            const patientData = {
                action: action,
                PatientId: PatientId, // Include PatientId for update and delete actions
                FullName: FullName,
                DateOfBirth: DateOfBirth,
                Address: Address,
                Gender: Gender,
            };

            fetch('homePageAdmin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(patientData)
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('message').innerText = data.message;
            })
            .catch(error => {
                document.getElementById('message').innerText = 'Error: ' + error;
            });
        }
    </script>
</body>
</html>
