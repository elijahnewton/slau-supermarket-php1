<?php
// File: add_product.php
include 'db_config.php';

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $expiry = $_POST['expiry_date'];
    
    $sql = "INSERT INTO products (name, category, price, stock_quantity, expiry_date) 
            VALUES ('$name', '$category', '$price', '$qty', '$expiry')";
    
    if($conn->query($sql)) {
        header("Location: index.php");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .container { max-width: 500px; margin: 50px auto; background: white; padding: 30px; border-radius: 5px; }
        input, select { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 3px; }
        button { background: #27ae60; color: white; padding: 10px 20px; border: none; border-radius: 3px; cursor: pointer; }
        button:hover { background: #219a52; }
        .error { color: red; margin-bottom: 10px; }
        a { display: inline-block; margin-top: 10px; color: #3498db; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Product</h2>
        <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Product Name" required>
            <input type="text" name="category" placeholder="Category (e.g., Groceries, Dairy)">
            <input type="number" step="0.01" name="price" placeholder="Price (UGX)" required>
            <input type="number" name="qty" placeholder="Stock Quantity" required>
            <input type="date" name="expiry_date" placeholder="Expiry Date">
            <button type="submit" name="submit">Save Product</button>
        </form>
        <a href="index.php">← Back to Dashboard</a>
    </div>
</body>
</html>