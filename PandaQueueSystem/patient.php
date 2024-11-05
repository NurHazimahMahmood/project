<body>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F9D689;
            margin: 0;
            padding: 20px;
            color: #000;
            height: 100vh;
            display: flex;
        }

        .container {
            display: flex;
            flex: 1;
        }

        .sidebar {
            background-color: maroon;
            padding: 5px;
            border-radius: 5px;
            width: 8%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            height: 40%;
        }

        .content {
            display: flex;
            flex-direction: column;
            /* Stack content vertically */
            flex: 1;
            /* Take the remaining space */
        }

        .patient-detail,
        .patient-list {
            background-color: #E0A75E;
            padding: 5px;
            border-radius: 5px;
            margin-bottom: 10px;
            /* Space between patient detail and patient list */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding-bottom: 40px;
        }

        h2 {
            text-align: center;
            color: white;
        }

        h3 {
            text-align: center;
            color: #FABC3F;
        }

        h3.title {
            text-align: center;
            color: #333;
        }

        form {
            margin-bottom: 5px;
            text-align: center;
            /* Center the form content */
        }

        table {
            width: 60%;
            border-collapse: collapse;
            /* Collapse borders for table */
            margin: 0 auto;
            /* Center the table */
        }

        table,
        th,
        td {
            border: 1px solid #000;
            /* Table border */
        }

        th {
            background-color: #CCCCCC;
            /* Header background color */
        }

        td {
            padding: 8px;
            /* Cell padding */
        }

        input[type="text"],
        input[type="date"],
        select {
            width: calc(100% - 16px);
            /* Full width for input fields with padding adjustment */
            padding: 8px;
            margin: 5px 0;
            /* Margin for inputs */
            border: 1px solid #ccc;
            border-radius: 4px;
            max-width: 300px;
            /* Adjust this to set maximum width */
        }

        input[type="submit"] {
            background-color: #007BFF;
            /* Button background color */
            color: white;
            border: none;
            padding: 10px 15px;
            margin: 5px 0;
            cursor: pointer;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
            /* Button hover color */
        }

        .sidebar a {
            display: block;
            color: #fff;
            padding: 10px;
            text-decoration: none;
            text-align: center;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        .sidebar a:hover {
            background-color: #c69c5e;
            /* Change hover color for links */
        }
    </style>

    <?php
    session_start();
    include("dbLogin.php");

    // Check if user is logged in
    if (isset($_SESSION['UserID'])) {
        $loggedInUserID = $_SESSION['UserID'];
    } else {
        header("Location: index.php");
        exit();
    }

    // Initialize patient row for edit mode
    $row = null;
    if (isset($_GET['PatientID'])) {
        $patientID = $_GET['PatientID'];
        if (!empty($patientID)) {
            $sql = "SELECT * FROM patients WHERE PatientID='$patientID' AND UserID='$loggedInUserID'";
            $rs_result = $conn->query($sql);
            $row = $rs_result->fetch_assoc();
        }
    }

    // Query to retrieve patients with non-empty queues
    $sqlQueue = "SELECT p.PatientID, p.FullName, p.DateOfBirth, p.Address, p.Gender, 
    a.AppointmentDate, a.AppointmentTime, a.QueueNumber
    FROM patients p
    LEFT JOIN appointment a ON p.PatientID = a.PatientID
    WHERE a.QueueNumber IS NOT NULL AND a.QueueNumber != ''AND UserID='$loggedInUserID'";
    $rs_queue_result = $conn->query($sqlQueue);
    ?>

    <div class="container">
        <div class="sidebar">
            <h3>PandaQueue Peds</h3>
            <a href="patient.php">Patient Register</a>
            <a href="index.php">Log Out</a>
        </div>
        <div class="content">
            <div class="patient-detail">
                <h3 class='title'>PATIENT DETAIL</h3>
                <form name="patient_form" method="post" action="patient.php<?php if (isset($_GET['PatientID'])) {
                                                                                echo '?PatientID=' . $_GET['PatientID'];
                                                                            } ?>">
                    <table>
                        <tr>
                            <td>Full Name:</td>
                            <td><input type="text" name="FullName" value="<?php echo isset($row["FullName"]) ? $row["FullName"] : ''; ?>" required /></td>
                        </tr>
                        <tr>
                            <td>Gender:</td>
                            <td>
                                <select name="Gender" required>
                                    <option value="Male" <?php echo (isset($row["Gender"]) && $row["Gender"] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo (isset($row["Gender"]) && $row["Gender"] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Birth Date:</td>
                            <td><input type="date" id="datareg" name="DateOfBirth" value="<?php echo isset($row["DateOfBirth"]) ? $row["DateOfBirth"] : ''; ?>" required /></td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td><input type="text" name="Address" value="<?php echo isset($row["Address"]) ? $row["Address"] : ''; ?>" required /></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" name="add" value="Add" />
                                <input type="submit" name="update" value="Update" />
                                <input type="submit" name="delete" value="Delete" />
                            </td>
                        </tr>
                    </table>
                    <a href='patient.php'>Refresh View</a>
                </form>

                <h3 class='title'>VIEW LIST OF PATIENTS</h3>
                <form name="patientInfo" method="post" action="">
                    Search by name: <input type="text" name="txtName" value="">
                    <input type="submit" name="search" value="view">
                </form>

                <?php
                // Handle form submissions
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['add'])) {
                        // Insert new patient data
                        $FullName = $_POST['FullName'];
                        $Gender = $_POST['Gender'];
                        $DateOfBirth = $_POST['DateOfBirth'];
                        $Address = $_POST['Address'];

                        if (!empty($FullName) && !empty($Gender) && !empty($DateOfBirth) && !empty($Address)) {
                            $stmt = $conn->prepare("INSERT INTO patients (FullName, Gender, DateOfBirth, Address, UserID) VALUES (?, ?, ?, ?, ?)");
                            $stmt->bind_param("ssssi", $FullName, $Gender, $DateOfBirth, $Address, $loggedInUserID);
                            if ($stmt->execute()) {
                                echo "<script type='text/javascript'>alert('New patient added successfully');</script>";
                            } else {
                                echo "<script type='text/javascript'>alert('Error: " . $stmt->error . "');</script>";
                            }
                            $stmt->close();
                        }
                    } elseif (isset($_POST['update'])) {
                        // Update existing patient data
                        $FullName = $_POST['FullName'];
                        $Gender = $_POST['Gender'];
                        $DateOfBirth = $_POST['DateOfBirth'];
                        $Address = $_POST['Address'];
                        $patientID = $_GET['PatientID'];

                        if (!empty($FullName) && !empty($Gender) && !empty($DateOfBirth) && !empty($Address)) {
                            $stmt = $conn->prepare("UPDATE patients SET FullName=?, Gender=?, DateOfBirth=?, Address=? WHERE PatientID=? AND UserID=?");
                            $stmt->bind_param("ssssis", $FullName, $Gender, $DateOfBirth, $Address, $patientID, $loggedInUserID);
                            if ($stmt->execute()) {
                                echo "<script type='text/javascript'>alert('Patient updated successfully');</script>";
                            } else {
                                echo "<script type='text/javascript'>alert('Error: " . $stmt->error . "');</script>";
                            }
                            $stmt->close();
                        }
                    } elseif (isset($_POST['delete'])) {
                        // Delete patient data
                        $patientID = $_GET['PatientID'];
                        $deleteAppointments = $conn->prepare("DELETE FROM appointment WHERE PatientID=?");
                        $deleteAppointments->bind_param("i", $patientID);
                        $deleteAppointments->execute();
                        $stmt = $conn->prepare("DELETE FROM patients WHERE PatientID=? AND UserID=?");
                        $stmt->bind_param("si", $patientID, $loggedInUserID);
                        if ($stmt->execute()) {
                            echo "<script type='text/javascript'>alert('Patient deleted successfully');</script>";
                        } else {
                            echo "<script type='text/javascript'>alert('Error: " . $stmt->error . "');</script>";
                        }
                        $stmt->close();
                    }
                }

                // Search functionality
                $search = isset($_POST['txtName']) ? $_POST['txtName'] : '';
                $stmt = $conn->prepare("SELECT * FROM patients WHERE FullName LIKE ? AND UserID=?");
                $searchTerm = "%$search%";
                $stmt->bind_param("si", $searchTerm, $loggedInUserID);
                $stmt->execute();
                $rs_result = $stmt->get_result();
                ?>
                <div>
                    <table border=1 class="a-table">
                        <tr bgcolor="#CCCCCC">
                            <th> Patient ID </th>
                            <th> Full Name </th>
                            <th> Gender </th>
                            <th> Date of Birth </th>
                            <th> Address </th>
                            <th> Action </th>
                        </tr>
                        <?php while ($row = $rs_result->fetch_assoc()) { ?>
                            <tr>
                                <td align=center><?php echo $row["PatientID"]; ?></td>
                                <td align=left><?php echo $row["FullName"]; ?></td>
                                <td align=center><?php echo $row["Gender"]; ?></td>
                                <td align=center><?php echo $row["DateOfBirth"]; ?></td>
                                <td align=center><?php echo $row["Address"]; ?></td>
                                <td align="center">
                                    <a href='patient.php?PatientID=<?php echo $row["PatientID"]; ?>'>Edit</a> |
                                    <a href='service.php?PatientID=<?php echo $row["PatientID"]; ?>&FullName=<?php echo $row["FullName"]; ?>&DateOfBirth=<?php echo $row["DateOfBirth"]; ?>&Address=<?php echo $row["Address"]; ?>&Gender=<?php echo $row["Gender"]; ?>'>Book</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>

                <h3 class='title'>PATIENTS WITH ACTIVE QUEUES</h3>
                <div>
                    <table border="1" class="a-table">
                        <tr bgcolor="#CCCCCC">
                            <th>Patient ID</th>
                            <th>Full Name</th>
                            <th>Gender</th>
                            <th>Date of Birth</th>
                            <th>Address</th>
                            <th>Appointment Date</th>
                            <th>Appointment Time</th>
                            <th>Queue Number</th>
                        </tr>
                        <?php while ($queueRow = $rs_queue_result->fetch_assoc()) { ?>
                            <tr>
                                <td align="center"><?php echo $queueRow["PatientID"]; ?></td>
                                <td align="left"><?php echo $queueRow["FullName"]; ?></td>
                                <td align="center"><?php echo $queueRow["Gender"]; ?></td>
                                <td align="center"><?php echo $queueRow["DateOfBirth"]; ?></td>
                                <td align="center"><?php echo $queueRow["Address"]; ?></td>
                                <td align="center"><?php echo $queueRow["AppointmentDate"]; ?></td>
                                <td align="center"><?php echo $queueRow["AppointmentTime"]; ?></td>
                                <td align="center"><?php echo $queueRow["QueueNumber"]; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
                $("#datareg").datepicker({
                    dateFormat: "yy-mm-dd"
                });
            });
        </script>
    </div>
    </div>
    </div>
</body>