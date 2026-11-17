<!-- FIX database table lb_order_items -->
<!-- NOT DISPLAYING product name, variant (if there is any), and subtotal --> 

<?php
session_start();
include("connect_database.php");

$cart_id = $_SESSION['cart_id'] ?? null;
if (!$cart_id) {
    die("No cart session found.");
}

$customer_name = $_POST['customer_name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone_number'] ?? '';
$payment_method = $_POST['payment_method'] ?? '';

// 1. Fetch cart items
$stmt = $conn->prepare("
    SELECT 
        ci.product_id,
        ci.quantity,
        ci.variant,
        p.price
    FROM lb_cart_items ci
    JOIN lb_products p ON ci.product_id = p.product_id
    WHERE ci.cart_id = ?
");
$stmt->execute([$cart_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($cart_items) === 0) {
    die("No items in cart.");
}

// 2. Insert into lb_orders
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['quantity'] * $item['price'];
}

$order_id = random_int(100000, 999999);
$pickup_date = $_POST['pickup_date'] ?? null;

$stmt = $conn->prepare("
    INSERT INTO lb_orders (order_id, customer_name, email, phone_number, payment_method, total_amount, pickup_date, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
");
$stmt->execute([$order_id, $customer_name, $email, $phone, $payment_method, $total, $pickup_date]);


// 3. Insert each cart item into lb_order_items
foreach ($cart_items as $item) {
    $stmt = $conn->prepare("
        INSERT INTO lb_order_items (order_id, product_id, quantity, variant, price)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$order_id, $item['product_id'], $item['quantity'], $item['variant'], $item['price']]);
}

// 4. Clear the cart
$stmt = $conn->prepare("DELETE FROM lb_cart_items WHERE cart_id = ?");
$stmt->execute([$cart_id]);

// 5. Redirect or confirmation
header("Location: order_success.php?order_id=$order_id");
exit;
?>
