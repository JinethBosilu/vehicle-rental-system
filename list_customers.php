<?php
include 'includes/db.php';

// Read selected status from dropdown
$statusFilter = $_GET['status'] ?? 'allStatus';

// Build the query based on selected filter
if ($statusFilter === 'allStatus') {
    $query = "SELECT * FROM users";
} else {
    $query = "SELECT * FROM users WHERE status = '$statusFilter'";
}

$result = mysqli_query($conn, $query);
?>