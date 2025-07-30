<?php
include 'includes/db.php';
//$statusFilter = $_GET['status'] ?? 'allStatus';
// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
    $action = $_POST['action'];
    $currentFilter = $_POST['current_filter']; 

    if ($action === 'ban') {
        $banQuery = "UPDATE users SET status = 'banned' WHERE customer_id = $customer_id";
        mysqli_query($conn, $banQuery);
    }

    
    if ($action === 'unban') {
        $unbanQuery = "UPDATE users SET status = 'active' WHERE customer_id = $customer_id";
        mysqli_query($conn, $unbanQuery);
    }


    if ($action === 'delete') {
        $deleteQuery = "DELETE FROM users WHERE customer_id = $customer_id";
        mysqli_query($conn, $deleteQuery);
    }
    header("Location: index.php?status=$currentFilter");
    exit;
}
?>
