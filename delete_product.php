<?php
// File: delete_product.php
include 'db_config.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Check if product has any sales
    $check = $conn->query("SELECT COUNT(*) as count FROM sales WHERE product_id = $id");
    $has_sales = $check->fetch_assoc()['count'];
    
    if($has_sales == 0) {
        $conn->query("DELETE FROM products WHERE id = $id");
        header("Location: index.php");
    } else {
        // Product has sales, cannot delete
        echo "<script>alert('Cannot delete product with sales history!'); window.location='index.php';</script>";
    }
} else {
    header("Location: index.php");
}
?>