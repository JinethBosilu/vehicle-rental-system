<?php
    include 'list_customers.php';
    include 'ban_unban_delete_customers.php';
    include 'includes/db.php';
    include 'includes/stats.php';
?>



<html>
  <head>
    <script>
function showHistory(customerId) {
    document.getElementById('historyModal').style.display = 'block';
    document.getElementById('historyContent').innerHTML = 'Loading...';

    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_rental_history.php?customer_id=' + customerId, true);
    xhr.onload = function () {
        if (this.status == 200) {
            document.getElementById('historyContent').innerHTML = this.responseText;
        } else {
            document.getElementById('historyContent').innerHTML = 'Error loading history.';
        }
    };
    xhr.send();
}

function closeHistory() {
    document.getElementById('historyModal').style.display = 'none';
}
</script>

  <link rel="stylesheet" type="text/css" href="includes/styles.css">

  </head>
  <body>
    <h1>Customer Management</h1>
    <!-- Stats UI -->


<div class="stats-container">
  <div class="stat-box">
    <div class="stat-title">Total Customers</div>
    <div class="stat-value"><?= $totalCustomers ?></div>
  </div>
  <div class="stat-box">
    <div class="stat-title">Active</div>
    <div class="stat-value"><?= $activeCustomers ?></div>
  </div>
  <div class="stat-box">
    <div class="stat-title">Banned</div>
    <div class="stat-value"><?= $bannedCustomers ?></div>
  </div>
  <div class="stat-box">
    <div class="stat-title">Revenue</div>
    <div class="stat-value">Rs. <?= number_format($totalRevenue, 2) ?></div>
  </div>
</div>


    <!-- Dropdown as a form (GET method) -->
    <form method="GET" action="index.php">
      <label for="status">Filter by Status:</label>
      <select name="status" id="status" onchange="this.form.submit()">
        <option value="active" <?= $statusFilter == 'active' ? 'selected' : '' ?>>Active</option>
        <option value="banned" <?= $statusFilter == 'banned' ? 'selected' : '' ?>>Banned</option>
        <option value="allStatus" <?= $statusFilter == 'allStatus' ? 'selected' : '' ?>>All Status</option>
      </select>
    </form>

    <br><br>
    

    <div>
      <h2>Customer List</h2>
      <table border="1" cellpadding="5" cellspacing="0">
        <tr>
          <th>Customer</th>
          <th>Contact</th>
          <th>Status</th>
          <th>Join Date</th>
          <th>Rentals</th>
          <th>Total Spent</th>
          <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['contact_number']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td><?= htmlspecialchars($row['join_date']) ?></td>
            <td><?= htmlspecialchars($row['rentals']) ?></td>
            <td><?= number_format($row['total_spent'], 2) ?></td>
            <td>
                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to <?= $row['status'] === 'banned' ? 'unban' : 'ban' ?> this customer?');">
                    <input type="hidden" name="action" value="<?= $row['status'] === 'banned' ? 'unban' : 'ban' ?>">
                    <input type="hidden" name="customer_id" value="<?= $row['customer_id'] ?>">
                    <input type="hidden" name="current_filter" value="<?= htmlspecialchars($statusFilter) ?>">
                    <input type="submit" value="<?= $row['status'] === 'banned' ? 'Unban Customer' : 'Ban Customer' ?>">
                </form>
                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="customer_id" value="<?= $row['customer_id'] ?>">
                    <input type="hidden" name="current_filter" value="<?= htmlspecialchars($statusFilter) ?>">
                    <input type="submit" value="Delete Customer">
                </form>
                <button onclick="showHistory(<?= $row['customer_id'] ?>)">View History</button>
            </td>
          </tr>
        <?php } ?>

        <?php if (mysqli_num_rows($result) === 0) { ?>
          <tr><td colspan="6">No users found.</td></tr>
        <?php } ?>
      </table>
    </div>
    <!-- History Modal -->
    <div id="historyModal" style="display:none; position:fixed; top:10%; left:10%; width:80%; background:#fff; padding:20px; border:1px solid #ccc; z-index:999;">
      <h3>Rental History</h3>
      <div id="historyContent">Loading...</div>
      <br>
      <button onclick="closeHistory()">Close</button>
    </div>

  </body>
  <?php mysqli_close($conn); ?>
</html>
