<?php
    include 'list_customers.php';
    include 'ban_unban_delete_customers.php';
    include 'includes/db.php';
?>



<html>
  <body>
    <h1>Customer Management</h1>

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
            </td>
          </tr>
        <?php } ?>

        <?php if (mysqli_num_rows($result) === 0) { ?>
          <tr><td colspan="6">No users found.</td></tr>
        <?php } ?>
      </table>
    </div>
  </body>
  <?php mysqli_close($conn); ?>
</html>
