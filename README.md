# 🚘 Vehicle Rental Management System – Database Setup

This guide provides the SQL commands to set up the `vehicle_rental_temp` database with two main tables:

- `users` – Stores customer information
- `rentals` – Stores rental records

---

## 📦 Step 1: Create the Database

```sql
CREATE DATABASE IF NOT EXISTS vehicle_rental_temp;
USE vehicle_rental_temp;


Step 2: Create users Table
sql
Copy code


CREATE TABLE IF NOT EXISTS users (
  customer_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE, -- Email must be unique
  contact_number VARCHAR(20),
  status ENUM('active', 'banned', 'deleted') DEFAULT 'active',
  join_date DATE,
  rentals INT DEFAULT 0,
  total_spent DECIMAL(10,2) DEFAULT 0.00
);

Step 3: Create rentals Table
sql
Copy code


CREATE TABLE IF NOT EXISTS rentals (
  rental_id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT NOT NULL,
  vehicle VARCHAR(100) NOT NULL, -- Replaces 'vehicle_name'
  status ENUM('active', 'completed', 'pending') DEFAULT 'pending',
  start_date DATE,
  end_date DATE,
  amount DECIMAL(10,2),
  FOREIGN KEY (customer_id) REFERENCES users(customer_id) ON DELETE CASCADE
);

Insert Sample Data (Optional)
sql
Copy code


-- Sample users
INSERT INTO users (name, email, contact_number, status, join_date, rentals, total_spent)
VALUES
('John Doe', 'john@example.com', '0712345678', 'active', '2022-01-15', 3, 12500.00),
('Jane Smith', 'jane@example.com', '0723456789', 'banned', '2023-03-22', 1, 4500.00),
('Mike Lee', 'mike@example.com', '0734567890', 'deleted', '2021-07-10', 5, 23000.00);

-- Sample rentals
INSERT INTO rentals (customer_id, vehicle, status, start_date, end_date, amount)
VALUES
(1, 'Toyota Aqua', 'completed', '2023-06-01', '2023-06-05', 4500.00),
(1, 'Nissan Leaf', 'completed', '2023-07-10', '2023-07-15', 5500.00),
(2, 'Suzuki Wagon R', 'active', '2024-01-01', NULL, 4500.00);
```
