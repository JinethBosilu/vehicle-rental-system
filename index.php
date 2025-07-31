<?php
    include 'list_customers.php';
    include 'ban_unban_delete_customers.php';
    include 'includes/db.php';
    include 'includes/stats.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management System</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .stats-container {
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card.active {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
        
        .stat-card.banned {
            background: linear-gradient(135deg, #fc466b 0%, #3f5efb 100%);
        }
        
        .stat-card.revenue {
            background: linear-gradient(135deg, #fdbb2d 0%, #22c1c3 100%);
        }
        
        .stat-title {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 0.5rem;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: bold;
        }
        
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 20px 20px;
        }
        
        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .table thead th {
            background-color: #495057;
            color: white;
            border: none;
            font-weight: 600;
            padding: 1rem;
        }
        
        .table tbody tr {
            transition: background-color 0.3s ease;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-active {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-banned {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .btn-action {
            margin: 0 2px;
            border-radius: 8px;
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
        }
        
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }
        
        .search-container {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .filter-container {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>

    <script>
        function showHistory(customerId) {
            const modal = new bootstrap.Modal(document.getElementById('historyModal'));
            modal.show();
            
            document.getElementById('historyContent').innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';

            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_rental_history.php?customer_id=' + customerId, true);
            xhr.onload = function () {
                if (this.status == 200) {
                    document.getElementById('historyContent').innerHTML = this.responseText;
                } else {
                    document.getElementById('historyContent').innerHTML = '<div class="alert alert-danger">Error loading history.</div>';
                }
            };
            xhr.send();
        }

        function filterTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const table = document.getElementById('customerTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let found = false;

                for (let j = 0; j < cells.length - 1; j++) {
                    if (cells[j].textContent.toLowerCase().includes(searchInput)) {
                        found = true;
                        break;
                    }
                }

                row.style.display = found ? '' : 'none';
            }
        }
    </script>
</head>

<body>
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="mb-0"><i class="bi bi-people-fill me-3"></i>Customer Management</h1>
                    <p class="mb-0 mt-2 opacity-75">Manage customers, view rental history, and moderate user accounts</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-title"><i class="bi bi-people me-2"></i>Total Customers</div>
                        <div class="stat-value"><?= $totalCustomers ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card active">
                        <div class="stat-title"><i class="bi bi-check-circle me-2"></i>Active</div>
                        <div class="stat-value"><?= $activeCustomers ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card banned">
                        <div class="stat-title"><i class="bi bi-ban me-2"></i>Banned</div>
                        <div class="stat-value"><?= $bannedCustomers ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card revenue">
                        <div class="stat-title"><i class="bi bi-currency-dollar me-2"></i>Revenue</div>
                        <div class="stat-value">Rs. <?= number_format($totalRevenue, 2) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="search-container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Search customers by name, contact, or any field..." onkeyup="filterTable()">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-end">
                        <small class="text-muted">Search through all customer data instantly</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Dropdown -->
        <div class="filter-container">
            <form method="GET" action="index.php" class="row align-items-center">
                <div class="col-md-4">
                    <label for="status" class="form-label fw-bold"><i class="bi bi-funnel me-2"></i>Filter by Status:</label>
                    <select name="status" id="status" class="form-select" onchange="this.form.submit()">
                        <option value="active" <?= $statusFilter == 'active' ? 'selected' : '' ?>>Active Users</option>
                        <option value="banned" <?= $statusFilter == 'banned' ? 'selected' : '' ?>>Banned Users</option>
                        <option value="allStatus" <?= $statusFilter == 'allStatus' ? 'selected' : '' ?>>All Status</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <div class="text-end">
                        <small class="text-muted">Showing <?= mysqli_num_rows($result) ?> customers</small>
                    </div>
                </div>
            </form>
        </div>

        <!-- Customer Table -->
        <div class="table-container">
            <div class="p-4">
                <h3 class="mb-4"><i class="bi bi-table me-2"></i>Customer List</h3>
                
                <div class="table-responsive">
                    <table class="table table-hover" id="customerTable">
                        <thead>
                            <tr>
                                <th><i class="bi bi-person me-2"></i>Customer</th>
                                <th><i class="bi bi-telephone me-2"></i>Contact</th>
                                <th><i class="bi bi-shield me-2"></i>Status</th>
                                <th><i class="bi bi-calendar me-2"></i>Join Date</th>
                                <th><i class="bi bi-car-front me-2"></i>Rentals</th>
                                <th><i class="bi bi-currency-dollar me-2"></i>Total Spent</th>
                                <th><i class="bi bi-gear me-2"></i>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-3">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold"><?= htmlspecialchars($row['name']) ?></div>
                                                <small class="text-muted">ID: <?= $row['customer_id'] ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($row['contact_number']) ?></td>
                                    <td>
                                        <span class="status-badge <?= $row['status'] === 'active' ? 'status-active' : 'status-banned' ?>">
                                            <i class="bi bi-<?= $row['status'] === 'active' ? 'check-circle' : 'ban' ?> me-1"></i>
                                            <?= ucfirst(htmlspecialchars($row['status'])) ?>
                                        </span>
                                    </td>
                                    <td><?= date('M d, Y', strtotime($row['join_date'])) ?></td>
                                    <td><span class="badge bg-primary"><?= htmlspecialchars($row['rentals']) ?></span></td>
                                    <td><strong>Rs. <?= number_format($row['total_spent'], 2) ?></strong></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-outline-info btn-action" onclick="showHistory(<?= $row['customer_id'] ?>)" title="View History">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            
                                            <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to <?= $row['status'] === 'banned' ? 'unban' : 'ban' ?> this customer?');">
                                                <input type="hidden" name="action" value="<?= $row['status'] === 'banned' ? 'unban' : 'ban' ?>">
                                                <input type="hidden" name="customer_id" value="<?= $row['customer_id'] ?>">
                                                <input type="hidden" name="current_filter" value="<?= htmlspecialchars($statusFilter) ?>">
                                                <button type="submit" class="btn <?= $row['status'] === 'banned' ? 'btn-success' : 'btn-warning' ?> btn-action" title="<?= $row['status'] === 'banned' ? 'Unban' : 'Ban' ?> Customer">
                                                    <i class="bi bi-<?= $row['status'] === 'banned' ? 'check-circle' : 'ban' ?>"></i>
                                                </button>
                                            </form>
                                            
                                            <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this customer? This action cannot be undone.');">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="customer_id" value="<?= $row['customer_id'] ?>">
                                                <input type="hidden" name="current_filter" value="<?= htmlspecialchars($statusFilter) ?>">
                                                <button type="submit" class="btn btn-outline-danger btn-action" title="Delete Customer">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>

                            <?php if (mysqli_num_rows($result) === 0) { ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox display-1"></i>
                                            <h5 class="mt-3">No customers found</h5>
                                            <p>Try adjusting your search or filter criteria</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- History Modal -->
    <div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="historyModalLabel">
                        <i class="bi bi-clock-history me-2"></i>Rental History
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="historyContent">Loading...</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .avatar-circle {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }
    </style>
</body>

<?php mysqli_close($conn); ?>
</html>