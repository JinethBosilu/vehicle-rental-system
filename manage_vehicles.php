<?php
include 'includes/db.php'; // DB connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Vehicles</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body {
      background: #f5f7fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .header {
      background: linear-gradient(to right, #667eea, #764ba2);
      padding: 2rem;
      border-radius: 12px;
      color: white;
      margin-bottom: 2rem;
    }
    .card {
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    .vehicle-img {
      width: 100px;
      height: 60px;
      object-fit: cover;
      border-radius: 6px;
    }
    .btn-primary {
      background: linear-gradient(to right, #667eea, #764ba2);
      border: none;
    }
    .btn-primary:hover {
      background: linear-gradient(to right, #5a67d8, #6b46c1);
    }
  </style>
</head>
<body class="container py-4">
  <div class="header">
    <h1 class="mb-0">Vehicle Management</h1>
    <p class="mb-0">Manage vehicles in your fleet, update details, or remove records</p>
  </div>

  <div class="card p-4">
    <a href="add_vehicle.php" class="btn btn-primary mb-3">+ Add New Vehicle</a>
    <div class="table-responsive">
      <table class="table table-bordered align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Brand + Model</th>
            <th>Type</th>
            <th>Status</th>
            <th>Price/Day</th>
            <th>Image</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM vehicles");
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['brand']} {$row['model']}</td>";
            echo "<td>{$row['type']}</td>";

            // Status badge
            $badgeColor = match($row['status']) {
                'available' => 'success',
                'rented' => 'warning',
                'maintenance' => 'danger',
                default => 'secondary',
            };
            echo "<td><span class='badge bg-{$badgeColor}'>{$row['status']}</span></td>";

            echo "<td>Rs. {$row['price_per_day']}</td>";

            // Vehicle image
            if (!empty($row['image'])) {
                echo "<td><img src='{$row['image']}' class='vehicle-img'></td>";
            } else {
                echo "<td><span class='text-muted'>No Image</span></td>";
            }

            // Action buttons
            echo "<td>
                    <a href='edit_vehicle.php?id={$row['id']}' class='btn btn-sm btn-outline-primary'>Edit</a>
                    <a href='delete_vehicle.php?id={$row['id']}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Are you sure?')\">Delete</a>
                  </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
