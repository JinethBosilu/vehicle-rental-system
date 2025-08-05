<!DOCTYPE html>
<html>
<head>
    <title>Vehicle Search</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
        }

        form {
            max-width: 500px;
            padding: 20px;
            border: 1px solid #ccc;
            background: #f9f9f9;
            border-radius: 10px;
        }

        label {
            font-weight: bold;
        }

        input[type="number"],
        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            margin: 6px 0 15px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <h2>Search Vehicles</h2>

    <form method="GET" action="testsearch.php">
        <label for="type">Vehicle Type:</label>
        <select name="type" id="type" placeholder="Type">
            <option value="SUV">SUV</option>
            <option value="Car">Car</option>
            <option value="Van">Van</option>
        </select>

        <label for="min_price">Price Range (Per Day):</label>
        <input type="number" name="min_price" id="min_price" placeholder="Minimum Price">
        <input type="number" name="max_price" id="max_price" placeholder="Maximum Price">

        <label for="availability">Availability:</label>
        <select name="availability" id="availability">
            
            <option value="1">Available</option>
            <option value="0">Not Available</option>
        </select>

        <label for="brand_model">Brand or Model:</label>
        <input type="text" name="brand_model" id="brand_model" placeholder="e.g., Toyota, Civic">

        <input type="submit" value="Search">
    </form>

</body>
</html>