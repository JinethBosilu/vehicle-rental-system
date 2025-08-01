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
        $target_dir = "assets/images/";
        $image_path = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image_path);
    }

    $stmt = $conn->prepare("INSERT INTO vehicles (brand, model, type, status, price_per_day, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssds", $brand, $model, $type, $status, $price, $image_path);
    $stmt->execute();

    echo "<div class='alert alert-success'>Vehicle added successfully!</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Vehicle</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <h2>Add New Vehicle</h2>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Brand</label>
      <input type="text" name="brand" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Model</label>
      <input type="text" name="model" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Type</label>
      <select name="type" class="form-control" required>
        <option>Car</option>
        <option>Van</option>
        <option>SUV</option>
        <option>Other</option>
      </select>
    </div>
    <div class="mb-3">
      <label>Status</label>
      <select name="status" class="form-control">
        <option>available</option>
        <option>rented</option>
        <option>maintenance</option>
      </select>
    </div>
    <div class="mb-3">
      <label>Price per day (LKR)</label>
      <input type="number" name="price_per_day" class="form-control" required step="0.01">
    </div>
    <div class="mb-3">
      <label>Upload Image</label>
      <input type="file" name="image" class="form-control">
    </div>
    <button class="btn btn-primary">Add Vehicle</button>
  </form>
</body>
</html>
