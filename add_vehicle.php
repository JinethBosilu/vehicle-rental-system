<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $type = $_POST['type'];
    $status = $_POST['status'];
    $price = $_POST['price_per_day'];

    // Handle image upload
    $image_path = "";
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $target_dir = "uploads/";
        $image_path = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image_path);
    }

    $stmt = $conn->prepare("INSERT INTO vehicles (brand, model, type, status, price_per_day, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssds", $brand, $model, $type, $status, $price, $image_path);
    $stmt->execute();

    $success = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Vehicle</title>
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
    <h1 class="mb-0">Add New Vehicle</h1>
    <p class="mb-0">Add vehicles to your rental fleet with status, pricing, and image</p>
  </div>

  <?php if (!empty($success)): ?>
    <div class="alert alert-success">Vehicle added successfully!</div>
  <?php endif; ?>

  <div class="card p-4">
    <form method="POST" enctype="multipart/form-data">
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Brand</label>
          <input type="text" name="brand" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Model</label>
          <input type="text" name="model" class="form-control" required>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Type</label>
          <select name="type" class="form-select" required>
            <option>Car</option>
            <option>Van</option>
            <option>SUV</option>
            <option>Other</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option>Available</option>
            <option>Rented</option>
            <option>Maintenance</option>
          </select>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Price per day (LKR)</label>
          <input type="number" name="price_per_day" class="form-control" required step="0.01">
        </div>
        <div class="col-md-6">
          <label class="form-label">Upload Image</label>
          <input type="file" name="image" class="form-control">
        </div>
      </div>

      <button class="btn btn-primary">Add Vehicle</button>
    </form>
  </div>
</body>
</html>