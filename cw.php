<?php
// Database connection settings
$host = 'localhost';
$dbname = 'led_db';
$username = 'root';
$password = 'umeshi04';

// Create database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $bulb1 = isset($_POST['bulb1']) ? $_POST['bulb1'] : null;
    $bulb2 = isset($_POST['bulb2']) ? $_POST['bulb2'] : null;

    // Prepare and execute SQL insert statement
    try {
        // Check if record already exists
        $stmt = $pdo->prepare("SELECT * FROM led_control");
        $stmt->execute();
        $existingRecord = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingRecord) {
            // Record exists, update instead of insert
            $stmt = $pdo->prepare("UPDATE led_control SET bulb1 = ?, bulb2 = ?");
            $stmt->execute([$bulb1, $bulb2]);
            $message = "Data updated successfully.";
        } else {
            // Record does not exist, insert new record
            $stmt = $pdo->prepare("INSERT INTO led_control (bulb1, bulb2) VALUES (?, ?)");
            $stmt->execute([$bulb1, $bulb2]);
            $message = "Data stored successfully.";
        }

        // If insertion/update is successful
        $response = array("success" => true, "message" => $message);
        echo json_encode($response);
    } catch (PDOException $e) {
        // If an error occurs during insertion/update
        $response = array("success" => false, "message" => "Error: " . $e->getMessage());
        echo json_encode($response);
    }
} else {
    // If request method is not POST
    $response = array("success" => false, "message" => "Invalid request method.");
    echo json_encode($response);
}
?>