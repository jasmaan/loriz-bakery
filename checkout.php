<?php 
session_start();

include "header.php";
include("connect_database.php");

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get current session cart ID
if (!isset($_SESSION['cart_id'])) {
    $_SESSION['cart_id'] = uniqid('cart_', true);
}
$cart_id = $_SESSION['cart_id'];

// Fetch cart items
$stmt = $conn->prepare("
    SELECT 
        ci.id AS cart_item_id,
        ci.product_id,
        ci.quantity,
        ci.variant,
        p.name,
        p.price,
        p.image_url
    FROM lb_cart_items ci
    JOIN lb_products p ON ci.product_id = p.product_id
    WHERE ci.cart_id = ?
");
$stmt->execute([$cart_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Compute total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['quantity'] * $item['price'];
}

// Manage Variants
$hasVariant = false;

foreach ($cart_items as $ci) {
    if (!empty($ci['variant'])) {
        $hasVariant = true;
        break;
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Loriz Bakery - Checkout</title>
        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" type="text/css" href="css/cart.css">
        <link rel="stylesheet" type="text/css" href="css/checkout.css">
        <script src="https://kit.fontawesome.com/bfe7538a42.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="checkoutContainer">
            <div class="checkoutHeader">
                <h2>Checkout</h2>
            </div>

            <?php
            // Checks if cart has items
            if (count($cart_items) > 0):
            ?>

                <div class="checkoutGrid">
                    <!-- LEFT: Cart Summary -->
                    <div class="checkoutCart">
                        <h3>Order Summary</h3>
                        
                        <?php foreach ($cart_items as $item): ?>
                            <div class="checkoutItem">
                                <img class="cartItemImage" src="<?= htmlspecialchars($item['image_url']) ?>" alt="Image">
                                <div>
                                    <h4><?= htmlspecialchars($item['name']) ?></h4>
                                    <p>Quantity: <?= $item['quantity'] ?></p>
                                    <p>Price: $<?= number_format($item['price'], 2) ?></p>
                                    <p>Subtotal: $<?= number_format($item['quantity'] * $item['price'], 2) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="checkoutTotalBar">
                            <div class="checkoutTotalDetails">
                                <h3>Total: $<?= number_format($total, 2) ?></h3>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT: Customer Info & Payment -->
                    <div class="checkoutDetails">

                        <form method="POST" action="place_order.php">
                            <label>Name</label>
                            <input type="text" name="customer_name" placeholder="Name" required>
                            
                            <!-- FIX to send email alert when order has been placed -->
                            <label>Email</label>
                            <input type="email" name="customer_email" placeholder="Email" required>
                            
                            <!-- FIX to send text alert when order has been placed -->
                            <label>Phone Number</label>
                            <input type="tel" id="phone_number" name="phone_number" required pattern="[0-9]{10}" placeholder="Phone Number">

                            <label for="pickup_date">Pick-Up Date</label>
                            <input type="date" id="pickup_date" name="pickup_date" required min="<?= date('Y-m-d'); ?>">

                            <label>Payment Method</label>
                            <select name="payment_method" required>
                                <option value="debit">Debit</option>
                                <option value="credit">Credit</option>
                                <option value="paypal">PayPal</option>
                            </select>

                            <div class="buttonsContainer">
                                <div class="backToCartBttnContainer">
                                    <a href="/cart.php" class="backToCartBttn">
                                        <span><i class="fa-solid fa-arrow-left arrowIcon"></i> Back To Cart</span>
                                    </a>
                                </div>

                                <div class="placeOrderBttnContainer">
                                    <button type="submit" class="placeOrderBttn">Place Order</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <p class="checkoutEmpty"> Your Cart is Empty </p>
            <?php endif; ?>
        </div>
    </body>
</html>

