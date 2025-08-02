<?php
include 'includes/db.php';
$result = $conn->query("SELECT * FROM vehicles");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Vehicle List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <h2>All Vehicles</h2>
  <a href="add_vehicle.php" class="btn btn-success mb-3">+ Add New</a>

  <table class="table table-bordered">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>Brand</th>
        <th>Model</th>
        <th>Type</th>
        <th>Status</th>
        <th>Price/Day</th>
        <th>Image</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['vehicle_id'] ?></td>
        <td><?= htmlspecialchars($row['brand']) ?></td>
        <td><?= htmlspecialchars($row['model']) ?></td>
        <td><?= $row['type'] ?></td>
        <td><?= $row['status'] ?></td>
        <td>Rs <?= number_format($row['price_per_day'], 2) ?></td>
        <td>
          <?php if ($row['image']): ?>
            <img src="<?= $row['image'] ?>" width="80">
          <?php else: ?> N/A <?php endif; ?>
        </td>
        <td>
          <a href="edit_vehicle.php?id=<?= $row['vehicle_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="delete_vehicle.php?id=<?= $row['vehicle_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this vehicle?')">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>
