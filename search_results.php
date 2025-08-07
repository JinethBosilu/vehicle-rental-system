<?php
// Connect to database
include 'includes/db.php'; 

// Get filter values
$type = $_GET['type'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$status = $_GET['status'] ?? '';
$brand_model = $_GET['brand_model'] ?? '';

// Build dynamic query
$query = "SELECT * FROM vehicles WHERE 1=1";

if (!empty($type)) {
    $type = $conn->real_escape_string($type);
    $query .= " AND type = '$type'";
}

if (!empty($min_price)) {
    $query .= " AND price_per_day >= " . (float)$min_price;
}

if (!empty($max_price)) {
    $query .= " AND price_per_day <= " . (float)$max_price;
}

if (!empty($status)) {
    $status = $conn->real_escape_string($status);
    $query .= " AND status = '$status'";
}

if (!empty($brand_model)) {
    $brand_model = $conn->real_escape_string($brand_model);
    $query .= " AND (brand LIKE '%$brand_model%' OR model LIKE '%$brand_model%')";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
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
        .vehicle-card {
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            background: white;
            margin-bottom: 1.5rem;
        }
        .vehicle-img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-top: 1rem;
        }
        .btn-back {
            background: linear-gradient(to right, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
        }
        .btn-back:hover {
            background: linear-gradient(to right, #5a67d8, #6b46c1);
            color: white;
        }
    </style>
</head>
<body class="container py-4">

    <div class="header">
        <h2 class="mb-0">Vehicle Search Results</h2>
        <p class="mb-0">Showing matching vehicles from your search criteria</p>
    </div>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="vehicle-card">
                <h4><?= htmlspecialchars($row['brand']) . ' ' . htmlspecialchars($row['model']) ?></h4>
                <p><strong>Type:</strong> <?= htmlspecialchars($row['type']) ?></p>
                <p><strong>Status:</strong> <?= htmlspecialchars($row['status']) ?></p>
                <p><strong>Price Per Day:</strong> Rs. <?= htmlspecialchars($row['price_per_day']) ?></p>
                <?php if (!empty($row['image'])): ?>
                    <img src="<?= htmlspecialchars($row['image']) ?>" class="vehicle-img" alt="Vehicle Image">
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-warning">No vehicles found matching your criteria.</div>
    <?php endif; ?>

    <a href="search_form.php" class="btn-back">← Back to Search</a>

</body>
</html>

<?php $conn->close(); ?>
