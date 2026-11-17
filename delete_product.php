<?php
session_start();
if (!isset($_SESSION['user'])) header('location: lb_login.php');

include("connect_database.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM lb_products WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: view_product.php");
        exit();
    } catch (PDOException $e) {
        echo "Error deleting product: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
