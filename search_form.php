<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Search</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f5f7fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .search-header {
            background: linear-gradient(to right, #667eea, #764ba2);
            padding: 2rem;
            border-radius: 12px;
            color: white;
            margin-bottom: 2rem;
            text-align: center;
        }
        .search-form {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .search-form label {
            font-weight: 600;
        }
        .search-form .form-control {
            margin-bottom: 1rem;
        }
        .search-form .btn {
            background: linear-gradient(to right, #667eea, #764ba2);
            border: none;
        }
        .search-form .btn:hover {
            background: linear-gradient(to right, #5a67d8, #6b46c1);
        }
    </style>
</head>
<body class="container py-4">

    <div class="search-header">
        <h2 class="mb-0">Search Vehicles</h2>
        <p class="mb-0">Find vehicles by type, price range, status or brand/model</p>
    </div>

    <form method="GET" action="search_results.php" class="search-form">
        <div class="mb-3">
            <label for="type" class="form-label">Vehicle Type:</label>
            <select name="type" id="type" class="form-control">
                <option value="">-- Any --</option>
                <option value="SUV">SUV</option>
                <option value="Car">Car</option>
                <option value="Van">Van</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Price Range (Per Day):</label>
            <div class="row">
                <div class="col">
                    <input type="number" name="min_price" id="min_price" class="form-control" placeholder="Minimum Price">
                </div>
                <div class="col">
                    <input type="number" name="max_price" id="max_price" class="form-control" placeholder="Maximum Price">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status:</label>
            <select name="status" id="status" class="form-control">
                <option value="">-- Any --</option>
                <option value="available">Available</option>
                <option value="rented">Rented</option>
                <option value="maintenance">Under Maintenance</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="brand_model" class="form-label">Brand or Model:</label>
            <input type="text" name="brand_model" id="brand_model" class="form-control" placeholder="e.g., Toyota, Civic">
        </div>

        <div class="text-center">
            <input type="submit" value="Search" class="btn btn-primary px-5">
        </div>
    </form>

</body>
</html>
