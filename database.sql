-- File: database.sql
-- Run this first to create your database

CREATE DATABASE IF NOT EXISTS supermarket_db2;
USE supermarket_db2;

-- Table 1: Products
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    price DECIMAL(10, 2) NOT NULL,
    stock_quantity INT NOT NULL,
    expiry_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 2: Customers
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    membership_date DATE DEFAULT (CURRENT_DATE)
);

-- Table 3: Sales (has FOREIGN KEY to products AND customers)
CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    customer_id INT NOT NULL,
    quantity_sold INT NOT NULL,
    total_price DECIMAL(10, 2),
    sale_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
);

-- Insert sample data
INSERT INTO products (name, category, price, stock_quantity) VALUES
('Rice 5kg', 'Grains', 25000.00, 50),
('Cooking Oil 2L', 'Groceries', 18000.00, 30),
('Milk 1L', 'Dairy', 5000.00, 40),
('Bread', 'Bakery', 3500.00, 25),
('Sugar 1kg', 'Groceries', 4000.00, 60);

INSERT INTO customers (name, email, phone) VALUES
('John Doe', 'john@email.com', '0700123456'),
('Jane Smith', 'jane@email.com', '0700789012'),
('Bob Wilson', 'bob@email.com', '0700567890');