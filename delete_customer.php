<?php include 'db_config.php'; ?>

<?php
    $id = $_GET["id"];
    $sql = "DELETE FROM customers WHERE customers.id =$id";
    $delete = $conn->query($sql);

    if($conn->query($sql)) { header("Location: index.php");}
?>