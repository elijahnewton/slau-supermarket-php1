<?php include 'db_config.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Customer</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .container { max-width: 500px; margin: 50px auto; background: white; padding: 30px; border-radius: 5px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 3px; }
        button { background: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 3px; cursor: pointer; }
        button:hover { background: #2980b9; }
        a { display: inline-block; margin-top: 10px; color: #3498db; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Customer</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address">
            <input type="text" name="phone" placeholder="Phone Number">
            <button type="submit" name="submit">Save Customer</button>
        </form>
        <a href="index.php">← Back to Dashboard</a>
    </div>
</body>
</html>

<?php
    if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $id = $_GET["id"];
    $sql = "UPDATE customers SET `name` = $name, email = $email, phone = $phone WHERE customers.id = $id";
    $update = $conn->query($sql);

        
    if($conn->query($sql)) {
        header("Location: index.php");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>