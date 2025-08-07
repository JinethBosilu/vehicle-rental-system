<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customerName = $_POST['customer_name'];
    $nic = $_POST['nic'];
    $vehicleType = $_POST['vehicle_type'];
    $model = $_POST['model'];
    $fuelType = $_POST['fuel_type'];
    $regNumber = $_POST['registration_number'];
    $paymentMethod = $_POST['payment_method'];

    // Send data to JavaScript via echo
    echo "<script>
        alert(`Payment Details Submitted:\\n
        Customer Name: $customerName\\n
        NIC: $nic\\n
        Vehicle Type: $vehicleType\\n
        Model: $model\\n
        Fuel Type: $fuelType\\n
        Registration No: $regNumber\\n
        Payment Method: $paymentMethod`);
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            margin-top: 10px;
            margin-left: 30px;
            margin-right: 30px;
        }
        .form-container {
            max-width: 700px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: 600;
        }
        input, select {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .buttons {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }
        .pay-btn {
            background: #6366f1;
            color: white;
        }
        .back-btn {
            background: #6b7280;
            color: white;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Payment Management</h2>
    <p>Manage customer rental payments easily</p>
</div>

<div class="form-container">
    <form method="POST">
        <div class="form-group">
            <label>Customer Name</label>
            <input type="text" name="customer_name" required>
        </div>

        <div class="form-group">
            <label>NIC</label>
            <input type="text" name="nic" required>
        </div>

        <div class="form-group">
            <label>Vehicle Type</label>
            <select name="vehicle_type" required>
                <option>Car</option>
                <option>Van</option>
                <option>SUV</option>
                <option>Bike</option>
            </select>
        </div>

        <div class="form-group">
            <label>Model</label>
            <input type="text" name="model" required>
        </div>

        <div class="form-group">
            <label>Fuel Type</label>
            <input type="text" name="fuel_type" required>
        </div>

        <div class="form-group">
            <label>Registration Number</label>
            <input type="text" name="registration_number" required>
        </div>

        <div class="form-group">
            <label>Payment Method</label>
            <select name="payment_method" required>
                <option>Cash</option>
                <option>Credit Card</option>
                <option>Debit Card</option>
            </select>
        </div>

        <div class="buttons">
            <button type="submit" class="pay-btn">Pay</button>
            <button type="button" class="back-btn" onclick="window.history.back()">Back</button>
        </div>
    </form>
</div>

</body>
</html>
