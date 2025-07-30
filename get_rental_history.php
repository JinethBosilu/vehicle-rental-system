<?php
include 'includes/db.php';

$customerId = intval($_GET['customer_id']);

// Get customer info (name, join_date)
$infoQuery = "SELECT name, join_date FROM users WHERE customer_id = $customerId";
$infoResult = mysqli_query($conn, $infoQuery);
$info = mysqli_fetch_assoc($infoResult);

// Get rental stats
$statsQuery = "SELECT COUNT(*) AS total_rentals, SUM(amount) AS total_spent FROM rentals WHERE customer_id = $customerId";
$statsResult = mysqli_query($conn, $statsQuery);
$stats = mysqli_fetch_assoc($statsResult);

$joinYear = date('Y', strtotime($info['join_date']));
$totalRentals = $stats['total_rentals'] ?? 0;
$totalSpent = $stats['total_spent'] ?? 0;

// Display summary boxes
echo "
<div style='display:flex; gap:20px; margin-bottom:15px;'>
  <div style='background:#f2f2f2; padding:10px 15px; border-radius:8px; text-align:center;'>
    <strong>Total Rentals:</strong><br>$totalRentals
  </div>
  <div style='background:#f2f2f2; padding:10px 15px; border-radius:8px; text-align:center;'>
    <strong>Total Spent:</strong><br>Rs. " . number_format($totalSpent, 2) . "
  </div>
  <div style='background:#f2f2f2; padding:10px 15px; border-radius:8px; text-align:center;'>
    <strong>Joined Year:</strong><br>$joinYear
  </div>
</div>
";

// Get full rental history
$historyQuery = "SELECT * FROM rentals WHERE customer_id = $customerId ORDER BY start_date DESC";
$historyResult = mysqli_query($conn, $historyQuery);

if (mysqli_num_rows($historyResult) > 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Rental ID</th><th>Vehicle</th><th>Status</th><th>Start Date</th><th>End Date</th><th>Amount</th></tr>";
    while ($row = mysqli_fetch_assoc($historyResult)) {
        echo "<tr>
                <td>{$row['rental_id']}</td>
                <td>{$row['vehicle']}</td>
                <td>{$row['status']}</td>
                <td>{$row['start_date']}</td>
                <td>{$row['end_date']}</td>
                <td>" . number_format($row['amount'], 2) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No rental history found for this customer.";
}

mysqli_close($conn);
?>
