<?php
include 'db.php';

$type = $_GET['type'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$availability = $_GET['availability'] ?? '';
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

if ($availability !== '') {
    $query .= " AND availability = " . (int)$availability;
}

if (!empty($brand_model)) {
    $brand_model = $conn->real_escape_string($brand_model);
    $query .= " AND (brand LIKE '%$brand_model%' OR model LIKE '%$brand_model%')";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
        }

        .vehicle {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            background: #f7f7f7;
        }

        .vehicle h3 {
            margin: 0 0 10px;
        }

        .back-link {
            margin-top: 20px;
            display: inline-block;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
        }

        .back-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h2>Search Results</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="vehicle">
                <h3><?= htmlspecialchars($row['brand']) . ' ' . htmlspecialchars($row['model']) ?></h3>
                <p><strong>Type:</strong> <?= htmlspecialchars($row['type']) ?></p>
                <p><strong>Price Per Day:</strong> Rs. <?= htmlspecialchars($row['price_per_day']) ?></p>
                <p><strong>Availability:</strong> <?= $row['availability'] ? "Available" : "Not Available" ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No vehicles found matching your criteria.</p>
    <?php endif; ?>

    <a href="index.php" class="back-link">← Back to Search</a>

</body>
</html>

<?php
$conn->close();
?>