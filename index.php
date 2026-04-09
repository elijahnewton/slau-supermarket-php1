<?php
// File: index.php
include 'db_config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Supermarket Management System</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .header { background: #2c3e50; color: white; padding: 20px; text-align: center; }
        .container { max-width: 1200px; margin: 20px auto; padding: 0 20px; }
        .menu { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
        .menu a { background: #3498db; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
        .menu a:hover { background: #2980b9; }
        table { width: 100%; background: white; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #2c3e50; color: white; }
        tr:hover { background: #f5f5f5; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 3px; }
        .btn-sell { background: #27ae60; color: white; }
        .btn-delete { background: #e74c3c; color: white; }
        .card { background: white; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        h2 { margin-bottom: 15px; color: #2c3e50; }
        .stats { display: flex; gap: 20px; margin-bottom: 20px; }
        .stat-box { background: white; padding: 15px; border-radius: 5px; flex: 1; text-align: center; }
        .stat-box h3 { color: #666; font-size: 14px; }
        .stat-box .number { font-size: 28px; font-weight: bold; color: #2c3e50; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏪 Supermarket Management System</h1>
    </div>
    
    <div class="container">
        <div class="menu">
            <a href="index.php">🏠 Dashboard</a>
            <a href="add_product.php">➕ Add Product</a>
            <a href="add_customer.php">👤 Add Customer</a>
            <a href="sell_product.php">💰 Make Sale</a>
            <a href="sales_report.php">📊 Sales Report</a>
        </div>

        <?php
        // Get statistics
        $product_count = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
        $customer_count = $conn->query("SELECT COUNT(*) as count FROM customers")->fetch_assoc()['count'];
        $total_sales = $conn->query("SELECT SUM(total_price) as total FROM sales")->fetch_assoc()['total'];
        ?>
        
        <div class="stats">
            <div class="stat-box">
                <h3>Total Products</h3>
                <div class="number"><?php echo $product_count; ?></div>
            </div>
            <div class="stat-box">
                <h3>Total Customers</h3>
                <div class="number"><?php echo $customer_count; ?></div>
            </div>
            <div class="stat-box">
                <h3>Total Sales</h3>
                <div class="number">UGX <?php echo number_format($total_sales ?? 0); ?></div>
            </div>
        </div>
        
        <div class="card">
            <h2>📦 Products in Inventory</h2>
             <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price (UGX)</th>
                    <th>Stock</th>
                    <th>Expiry Date</th>
                    <th>Action</th>
                </tr>
                <?php
                $result = $conn->query("SELECT * FROM products ORDER BY id DESC");
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['category']}</td>
                        <td>" . number_format($row['price']) . "</td>
                        <td>{$row['stock_quantity']}</td>
                        <td>{$row['expiry_date']}</td>
                        <td>
                            <a href='sell_product.php?id={$row['id']}' class='btn btn-sell'>Sell</a>
                            <a href='delete_product.php?id={$row['id']}' class='btn btn-delete' onclick='return confirm(\"Delete this product?\")'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
             </table>
        </div>
        
        <div class="card">
            <h2>👥 Recent Customers</h2>
             <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Member Since</th>
                    <th>Action</th>
                </tr>
                <?php
                $result = $conn->query("SELECT * FROM customers ORDER BY id DESC LIMIT 5");
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['membership_date']}</td>
                        <td>
                            <a href='update_customer.php?id={$row['id']}' class='btn btn-sell'>Update</a>
                            <a href='delete_customer.php?id={$row['id']}' class='btn btn-delete' onclick='return confirm(\"Delete this product?\")'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
             </table>
        </div>
    </div>
</body>
</html>