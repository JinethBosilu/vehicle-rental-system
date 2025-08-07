<?php
include("includes/db.php");

if (!isset($_GET['id'])) {
    echo "No vehicle ID specified.";
    exit;
}

$vehicle_id = $_GET['id'];

// Optional: you can first fetch and delete the vehicle's image file here if stored

$query = "DELETE FROM vehicles WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $vehicle_id);
$stmt->execute();

header("Location: manage_vehicles.php");
exit;
?>
