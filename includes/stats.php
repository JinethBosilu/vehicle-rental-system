<?php
include 'db.php';

// Total customers
$totalQuery = "SELECT COUNT(*) AS total FROM users";
$totalResult = mysqli_query($conn, $totalQuery);
$totalCustomers = mysqli_fetch_assoc($totalResult)['total'];

// Active
$activeQuery = "SELECT COUNT(*) AS active FROM users WHERE status = 'active'";
$activeResult = mysqli_query($conn, $activeQuery);
$activeCustomers = mysqli_fetch_assoc($activeResult)['active'];

// Banned
$bannedQuery = "SELECT COUNT(*) AS banned FROM users WHERE status = 'banned'";
$bannedResult = mysqli_query($conn, $bannedQuery);
$bannedCustomers = mysqli_fetch_assoc($bannedResult)['banned'];

// Revenue
$revenueQuery = "SELECT SUM(amount) AS total_revenue FROM rentals";
$revenueResult = mysqli_query($conn, $revenueQuery);
$totalRevenue = mysqli_fetch_assoc($revenueResult)['total_revenue'] ?? 0;
?>
