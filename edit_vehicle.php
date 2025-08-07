<?php
include("includes/db.php");

if (!isset($_GET['id'])) {
    echo "No vehicle ID specified.";
    exit;
}

$vehicle_id = $_GET['id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $type = $_POST['type'];
    $status = $_POST['status'];
    $price_per_day = $_POST['price_per_day'];

    // Optional: Handle image upload (skipped here)

    $query = "UPDATE vehicles SET 
                brand = ?, 
                model = ?, 
                type = ?, 
                status = ?, 
                price_per_day = ? 
              WHERE vehicle_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssdi", $brand, $model, $type, $status, $price_per_day, $vehicle_id);
    $stmt->execute();

    header("Location: manage_vehicles.php");
    exit;
}

// Fetch current vehicle details
$query = "SELECT * FROM vehicles WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $vehicle_id);
$stmt->execute();
$result = $stmt->get_result();
$vehicle = $result->fetch_assoc();

if (!$vehicle) {
    echo "Vehicle not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Vehicle</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    .btn-primary, .btn-success {
      background: linear-gradient(to right, #667eea, #764ba2);
      border: none;
    }
    .btn-primary:hover, .btn-success:hover {
      background: linear-gradient(to right, #5a67d8, #6b46c1);
    }
  </style>
</head>
<body class="container py-4">
  <div class="header">
    <h1 class="mb-0">Edit Vehicle - ID #<?= $vehicle_id ?></h1>
    <p class="mb-0">Update vehicle details including status and pricing</p>
  </div>

  <div class="card p-4">
    <form method="POST">
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Brand</label>
          <input type="text" name="brand" class="form-control" value="<?= $vehicle['brand'] ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Model</label>
          <input type="text" name="model" class="form-control" value="<?= $vehicle['model'] ?>" required>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Type</label>
          <select name="type" class="form-select" required>
            <?php foreach (["Car", "Van", "SUV", "Other"] as $type): ?>
              <option value="<?= $type ?>" <?= $vehicle['type'] === $type ? 'selected' : '' ?>><?= $type ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Status</label>
          <select name="status" class="form-select" required>
            <?php foreach (["available", "rented", "maintenance"] as $status): ?>
              <option value="<?= $status ?>" <?= $vehicle['status'] === $status ? 'selected' : '' ?>><?= ucfirst($status) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Price Per Day (LKR)</label>
          <input type="number" step="0.01" name="price_per_day" class="form-control" value="<?= $vehicle['price_per_day'] ?>" required>
        </div>
      </div>

      <button type="submit" class="btn btn-success">Update Vehicle</button>
      <a href="manage_vehicles.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</body>
</html>
