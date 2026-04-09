<?php
// File: sell_product.php
include 'db_config.php';

// Get product details if ID is provided
$product = null;
if(isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $result = $conn->query("SELECT * FROM products WHERE id = $product_id");
    $product = $result->fetch_assoc();
}

// Get all customers for dropdown
$customers = $conn->query("SELECT * FROM customers ORDER BY name");

// Process sale
if(isset($_POST['sell'])) {
    $product_id = $_POST['product_id'];
    $customer_id = $_POST['customer_id'];
    $quantity = $_POST['quantity'];
    
    // Get product price
    $prod_result = $conn->query("SELECT * FROM products WHERE id = $product_id");
    $product_data = $prod_result->fetch_assoc();
    $total_price = $product_data['price'] * $quantity;
    
    // Check if enough stock
    if($product_data['stock_quantity'] >= $quantity) {
        // Insert sale record
        $sql = "INSERT INTO sales (product_id, customer_id, quantity_sold, total_price) 
                VALUES ($product_id, $customer_id, $quantity, $total_price)";
        
        if($conn->query($sql)) {
            // Update stock quantity
            $new_stock = $product_data['stock_quantity'] - $quantity;
            $conn->query("UPDATE products SET stock_quantity = $new_stock WHERE id = $product_id");
            
            header("Location: sales_report.php?success=1");
            exit();
        } else {
            $error = "Sale failed: " . $conn->error;
        }
    } else {
        $error = "Insufficient stock! Only {$product_data['stock_quantity']} items available.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Make a Sale</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .container { max-width: 500px; margin: 50px auto; background: white; padding: 30px; border-radius: 5px; }
        select, input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 3px; }
        button { background: #27ae60; color: white; padding: 10px 20px; border: none; border-radius: 3px; cursor: pointer; width: 100%; }
        button:hover { background: #219a52; }
        .product-info { background: #e8f4f8; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .error { color: red; margin: 10px 0; }
        a { display: inline-block; margin-top: 10px; color: #3498db; }
    </style>
</head>
<body>
    <div class="container">
        <h2>💰 Make a Sale</h2>
        
        <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
        
        <?php if($product): ?>
            <div class="product-info">
                <strong>Product:</strong> <?php echo $product['name']; ?><br>
                <strong>Price:</strong> UGX <?php echo number_format($product['price']); ?><br>
                <strong>Available Stock:</strong> <?php echo $product['stock_quantity']; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <label>Select Product:</label>
            <select name="product_id" required>
                <option value="">-- Choose Product --</option>
                <?php
                $products = $conn->query("SELECT * FROM products WHERE stock_quantity > 0 ORDER BY name");
                while($p = $products->fetch_assoc()) {
                    $selected = ($product && $product['id'] == $p['id']) ? "selected" : "";
                    echo "<option value='{$p['id']}' $selected>{$p['name']} - UGX " . number_format($p['price']) . " (Stock: {$p['stock_quantity']})</option>";
                }
                ?>
            </select>
            
            <label>Select Customer:</label>
            <select name="customer_id" required>
                <option value="">-- Choose Customer --</option>
                <?php while($c = $customers->fetch_assoc()): ?>
                    <option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?> - <?php echo $c['phone']; ?></option>
                <?php endwhile; ?>
            </select>
            
            <label>Quantity:</label>
            <input type="number" name="quantity" min="1" required>
            
            <button type="submit" name="sell">Complete Sale</button>
        </form>
        <a href="index.php">← Back to Dashboard</a>
    </div>
</body>
</html>