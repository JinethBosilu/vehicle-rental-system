<?php
include 'includes/db.php';

// Fetch vehicles
$sql = "SELECT * FROM vehicles";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Vehicles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
        }
        .container {
            width: 90%;
            margin: auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        img {
            width: 100px;
        }
        .btn {
            padding: 6px 12px;
            margin: 2px;
            border: none;
            color: white;
            cursor: pointer;
        }
        .btn-add { background: #28a745; }
        .btn-edit { background: #007bff; }
        .btn-delete { background: #dc3545; }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <h2>Vehicle Management Dashboard</h2>

    <div class="container">
        <div class="top-bar">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search by Brand or Model..." />
                <button type="submit">Search</button>
            </form>
            <a href="add_vehicle.php" class="btn btn-add">+ Add Vehicle</a>
        </div>

        <table>
            <tr>
                <th>Image</th>
                <th>Type</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Price/Day</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><img src="uploads/<?php echo $row['image']; ?>" alt="Vehicle Image"></td>
                    <td><?php echo $row['type']; ?></td>
                    <td><?php echo $row['brand']; ?></td>
                    <td><?php echo $row['model']; ?></td>
                    <td>$<?php echo $row['price_per_day']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <a href="edit_vehicle.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                        <a href="delete_vehicle.php?id=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this vehicle?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
