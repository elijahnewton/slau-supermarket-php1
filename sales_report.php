<?php
// File: sales_report.php
include 'db_config.php';

// Get all sales with JOIN to show product and customer names
$sql = "SELECT s.*, p.name as product_name, c.name as customer_name 
        FROM sales s
        JOIN products p ON s.product_id = p.id
        JOIN customers c ON s.customer_id = c.id
        ORDER BY s.sale_date DESC";

$sales = $conn->query($sql);

// Get totals
$total_sales = $conn->query("SELECT SUM(total_price) as total FROM sales")->fetch_assoc()['total'];
$total_transactions = $conn->query("SELECT COUNT(*) as count FROM sales")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .container { max-width: 1200px; margin: 20px auto; padding: 0 20px; }
        .menu { margin-bottom: 20px; }
        .menu a { background: #3498db; color: white; padding: 10px 20px; text-decoration: none; border-radius: 3px; }
        .stats { display: flex; gap: 20px; margin-bottom: 20px; }
        .stat-box { background: white; padding: 20px; border-radius: 5px; flex: 1; text-align: center; }
        .stat-box h3 { margin-bottom: 10px; color: #666; }
        .stat-box .number { font-size: 32px; font-weight: bold; color: #27ae60; }
        table { width: 100%; background: white; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #2c3e50; color: white; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 3px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="menu">
            <a href="index.php">← Back to Dashboard</a>
        </div>
        
        <?php if(isset($_GET['success'])): ?>
            <div class="success">✓ Sale completed successfully!</div>
        <?php endif; ?>
        
        <div class="stats">
            <div class="stat-box">
                <h3>Total Revenue</h3>
                <div class="number">UGX <?php echo number_format($total_sales ?? 0); ?></div>
            </div>
            <div class="stat-box">
                <h3>Total Transactions</h3>
                <div class="number"><?php echo $total_transactions; ?></div>
            </div>
        </div>
        
        <h2>Sales History</h2>
         <table>
            <tr>
                <th>Sale ID</th>
                <th>Product</th>
                <th>Customer</th>
                <th>Quantity</th>
                <th>Total Price (UGX)</th>
                <th>Date & Time</th>
            </tr>
            <?php if($sales->num_rows > 0): ?>
                <?php while($row = $sales->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['quantity_sold']; ?></td>
                        <td><?php echo number_format($row['total_price']); ?></td>
                        <td><?php echo $row['sale_date']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">No sales recorded yet</td>
                </tr>
            <?php endif; ?>
         </table>
    </div>
</body>
</html>