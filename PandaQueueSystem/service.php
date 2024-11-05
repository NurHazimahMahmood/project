<?php

if (!isset($_GET['PatientID'], $_GET['FullName'], $_GET['DateOfBirth'], $_GET['Address'], $_GET['Gender'])) {
    // If not, redirect to the index.php (or you can redirect to another page)
    header("Location: index.php");
    exit();
}

$patientID = $_GET['PatientID'];
$fullName = $_GET['FullName'];
$dateOfBirth = $_GET['DateOfBirth'];
$address = $_GET['Address'];
$gender = $_GET['Gender'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PandaQueue Peds - Services</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #F9D689;
            color: #333;
        }

        .container {
            padding: 30px;
        }

        .header {
            font-size: 36px;
            margin-bottom: 30px;
            color: #973131;
        }

        .back-button {
            padding: 10px 20px;
            background-color: #f4c531;
            color: #333;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 10px;
            display: inline-block;
        }

        .back-button:hover {
            background-color: #ffc857;
        }

        .patient-info {
            background-color: #F5E7B2;
            padding: 15px;
            border-radius: 5px;
            width: 300px;
            float: right;
            margin-bottom: 30px;
        }

        .patient-info p {
            margin: 5px 0;
        }

        .services {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .service-card {
            background-color: #E0A75E;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            margin: 10px;
            width: 30%;
            box-sizing: border-box;
        }

        .service-card img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .service-card h3 {
            margin: 15px 0;
            color: #fff;
        }

        .register-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #973131;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .register-link:hover {
            background-color: #a04b4b;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="header">PandaQueue Peds Services</h1>

        <!-- Back button to go back to patient.php -->
        <form action="patient.php" method="get">
            <button type="submit" class="back-button">&larr; BACK</button>
        </form>

        <!-- Displaying patient information -->
        <div class="patient-info">
            <p><strong>Patient ID:</strong> <?php echo $_GET['PatientID']; ?></p>
            <p><strong>Patient Name:</strong> <?php echo $_GET['FullName']; ?></p>
            <p><strong>Date of Birth:</strong> <?php echo $_GET['DateOfBirth']; ?></p>
            <p><strong>Address:</strong> <?php echo $_GET['Address']; ?></p>
            <p><strong>Gender:</strong> <?php echo $_GET['Gender']; ?></p>
        </div>

        <!-- Service cards -->
        <div class="services">
            <div class="service-card">
                <img src="PsychiatryPsychology.avif" alt="Psychiatry and Psychology">
                <h3>Psychiatry & Psychology</h3>
                <a href="appointment.php?ServiceName=Psychiatry&ServiceID=1&PatientID=<?php echo $_GET['PatientID']; ?>&FullName=<?php echo urlencode($_GET['FullName']); ?>&DateOfBirth=<?php echo $_GET['DateOfBirth']; ?>&Address=<?php echo urlencode($_GET['Address']); ?>&Gender=<?php echo $_GET['Gender']; ?>" class="register-link">Register</a>
            </div>
            <div class="service-card">
                <img src="Cardiology.avif" alt="Cardiology">
                <h3>Cardiology</h3>
                <a href="appointment.php?ServiceName=Cardiology&ServiceID=2&PatientID=<?php echo $_GET['PatientID']; ?>&FullName=<?php echo urlencode($_GET['FullName']); ?>&DateOfBirth=<?php echo $_GET['DateOfBirth']; ?>&Address=<?php echo urlencode($_GET['Address']); ?>&Gender=<?php echo $_GET['Gender']; ?>" class="register-link">Register</a>
            </div>
            <div class="service-card">
                <img src="Allergy&Immunology.avif" alt="Allergy and Immunology">
                <h3>Allergy & Immunology</h3>
                <a href="appointment.php?ServiceName=Allergy&ServiceID=3&PatientID=<?php echo $_GET['PatientID']; ?>&FullName=<?php echo urlencode($_GET['FullName']); ?>&DateOfBirth=<?php echo $_GET['DateOfBirth']; ?>&Address=<?php echo urlencode($_GET['Address']); ?>&Gender=<?php echo $_GET['Gender']; ?>" class="register-link">Register</a>
            </div>
            <div class="service-card">
                <img src="RehabilitationServices.avif" alt="Rehabilitation Services">
                <h3>Rehabilitation</h3>
                <a href="appointment.php?ServiceName=Rehabilitation&ServiceID=4&PatientID=<?php echo $_GET['PatientID']; ?>&FullName=<?php echo urlencode($_GET['FullName']); ?>&DateOfBirth=<?php echo $_GET['DateOfBirth']; ?>&Address=<?php echo urlencode($_GET['Address']); ?>&Gender=<?php echo $_GET['Gender']; ?>" class="register-link">Register</a>
            </div>
            <div class="service-card">
                <img src="Neurology.avif" alt="Neurology">
                <h3>Neurology</h3>
                <a href="appointment.php?ServiceName=Neurology&ServiceID=5&PatientID=<?php echo $_GET['PatientID']; ?>&FullName=<?php echo urlencode($_GET['FullName']); ?>&DateOfBirth=<?php echo $_GET['DateOfBirth']; ?>&Address=<?php echo urlencode($_GET['Address']); ?>&Gender=<?php echo $_GET['Gender']; ?>" class="register-link">Register</a>
            </div>
            <div class="service-card">
                <img src="Orthopedic.avif" alt="Orthopedic">
                <h3>Orthopedic</h3>
                <a href="appointment.php?ServiceName=Orthopedic&ServiceID=6&PatientID=<?php echo $_GET['PatientID']; ?>&FullName=<?php echo urlencode($_GET['FullName']); ?>&DateOfBirth=<?php echo $_GET['DateOfBirth']; ?>&Address=<?php echo urlencode($_GET['Address']); ?>&Gender=<?php echo $_GET['Gender']; ?>" class="register-link">Register</a>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    const services = [{
            name: "Psychiatry and Psychology",
            element: document.querySelectorAll('.service-card')[0]
        },
        {
            name: "Cardiology",
            element: document.querySelectorAll('.service-card')[1]
        },
        {
            name: "Allergy and Immunology",
            element: document.querySelectorAll('.service-card')[2]
        },
        {
            name: "Rehabilitation Services",
            element: document.querySelectorAll('.service-card')[3]
        },
        {
            name: "Neurology",
            element: document.querySelectorAll('.service-card')[4]
        },
        {
            name: "Orthopedic",
            element: document.querySelectorAll('.service-card')[5]
        }
    ];

    const searchBar = document.getElementById('search-bar');
    const searchTermDisplay = document.getElementById('search-term');

    function filterServices() {
        const searchTerm = searchBar.value.toLowerCase();
        let matched = false;

        services.forEach(service => {
            const isVisible = service.name.toLowerCase().includes(searchTerm);
            service.element.style.display = isVisible ? 'block' : 'none';
            matched = matched || isVisible;
        });

        searchTermDisplay.textContent = matched ? Showing results
        for: "${searchTerm}": 'No services found';
    }

    searchBar.addEventListener('input', filterServices);
</script>