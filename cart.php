<!DOCTYPE html>
    <head>
        <title> Loriz Bakery - Add to Cart </title>
        <link rel="stylesheet" type="text/css" href="css/global.css">
        <link rel="stylesheet" type="text/css" href="css/cart.css">
        <script src="https://kit.fontawesome.com/bfe7538a42.js" crossorigin="anonymous"></script>
    </head>
    
    <body>
       <?php
        session_start();

        include "header.php";
        include("connect_database.php");
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Generate a session cart ID if not exists
        if (!isset($_SESSION['cart_id'])) {
            $_SESSION['cart_id'] = uniqid('cart_', true);
        }
        $cart_id = $_SESSION['cart_id'];

        // Handle cart item deletion
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete') {
            $delete_id = $_POST['delete_item_id'];
            $stmt = $conn->prepare("DELETE FROM lb_cart_items WHERE id = ? AND cart_id = ?");
            $stmt->execute([$delete_id, $cart_id]);

            // Redirect to prevent resubmission
            header("Location: cart.php");
            exit;
        }

        // Handle product quantity update
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update_quantity') {
            $item_id = $_POST['cart_item_id'];
            $change = $_POST['change']; // increase or decrease product qty

            // Get current quantity
            $stmt = $conn->prepare("SELECT quantity FROM lb_cart_items WHERE id = ? AND cart_id = ?");
            $stmt->execute([$item_id, $cart_id]);
            $item = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($item) {
                $current_qty = $item['quantity'];
                if ($change === 'increase') {
                    $new_qty = $current_qty + 1;
                } elseif ($change === 'decrease' && $current_qty > 1) {
                    $new_qty = $current_qty - 1;
                } else {
                    $new_qty = 1;
                }

                $stmt = $conn->prepare("UPDATE lb_cart_items SET quantity = ? WHERE id = ? AND cart_id = ?");
                $stmt->execute([$new_qty, $item_id, $cart_id]);
            }

            header("Location: cart.php");
            exit;
        }

        // Handle incoming POST (Add to Cart)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add') {
            $product_id = $_POST['product_id'] ?? null;
            $variant = $_POST['variant'] ?? '';
            $quantity = $_POST['quantity'] ?? 1;

            if ($product_id && $quantity > 0) {
                try {
                    $stmt = $conn->prepare("INSERT INTO lb_cart_items (cart_id, product_id, variant, quantity) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$cart_id, $product_id, $variant, $quantity]);

                    // Redirect to prevent resubmission
                    header('Location: cart.php');
                    exit;
                } catch (PDOException $e) {
                    echo "Database error: " . $e->getMessage();
                }
            } else {
                echo "Invalid cart submission.";
            }
        }

        // Fetch all items in the user's cart
        $stmt = $conn->prepare("
            SELECT 
                ci.id AS cart_item_id,
                ci.quantity,
                ci.variant,
                p.name,
                p.description,
                p.price,
                p.image_url
            FROM lb_cart_items ci
            JOIN lb_products p ON ci.product_id = p.product_id
            WHERE ci.cart_id = ?
        ");
        $stmt->execute([$cart_id]);
        $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <!-- Cart Page HTML -->
        <div class="cartContainer">
            <h2>My Cart</h2>
            <!-- ADD number of items currently in your cart -->

            <?php
            $hasVariant = false;

            $total = 0;

            foreach ($cart_items as $ci) {
                if (!empty($ci['variant'])) {
                    $hasVariant = true;
                    break;
                }
            }

            if (count($cart_items) > 0): 
            ?>
                
                <div class="cartList">
                    <table class="cartListTable">
                        <!-- FIX items tied to a certain session for users; if possible without signing up -->
                        <thead>
                            <tr>
                                <th class="regItem"> Item(s) </th>
                                <?php if ($hasVariant): ?>
                                    <th class="centerItem"> Variant </th>
                                <?php endif; ?>
                                <th class="centerItem"> Quantity </th>
                                <th class="centerItem"> Price </th> 
                                <th class="centerItem"> Subtotal </th>
                                <th class="centerItem"> </th>    
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($cart_items as $item): ?>
                            <tr class="cartListBody">
                                <!-- NAME -->
                                <td class="regItem">
                                    <div class="itemDetails">
                                        <div class="cartItemImage" style="background-image: url('<?= htmlspecialchars($item['image_url']) ?>');"></div>
                                        <div class="cartItemName">
                                            <p><strong><?= htmlspecialchars($item['name']) ?></strong></p>
                                        </div>
                                    </div>
                                </td>

                                <!-- VARIANT -->
                                <?php if ($hasVariant): ?>
                                    <td class="centerItem">
                                        <?= !empty($item['variant']) ? htmlspecialchars($item['variant']) : '-' ?>
                                    </td>
                                <?php endif; ?>

                                <!-- QUANTITY -->
                                <td class="centerItem">
                                    <form method="POST" action="cart.php" class="quantityForm">
                                        <input type="hidden" name="action" value="update_quantity">
                                        <input type="hidden" name="cart_item_id" value="<?= $item['cart_item_id'] ?>">

                                        <div class="quantityControls">
                                            <button type="submit" name="change" value="decrease" id="qtyMinus" class="qtyButton">
                                                <i class="fa-solid fa-circle-minus"></i>
                                            </button>
                                            <span class="qtyDisplay"><?= $item['quantity'] ?></span>
                                            <button type="submit" name="change" value="increase" id="qtyAdd" class="qtyButton">    
                                                <i class="fa-solid fa-circle-plus"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>

                                <!-- PRICE -->
                                <td class="centerItem"><p> $<?= number_format($item['price'], 2) ?></p></td>

                                <!-- SUBTOTAL -->
                                <?php
                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
                                ?>

                                <td class="centerItem"><p>$<?= number_format($subtotal, 2) ?></p></td>

                                <!-- DELETE -->
                                <td class="centerItem">
                                    <form method="POST" action="cart.php" onsubmit="return confirm('Remove this item?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="delete_item_id" value="<?= $item['cart_item_id'] ?>">
                                        <button type="submit" class="removeBttn"><i class="fa-solid fa-trash removeIcon"></i></button>
                                    </form>        
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- TOTAL -->
                    <div class="cartTotalContainer">
                        <div class="cartTotalDetails">
                            <h3>Total: $<?= number_format($total, 2) ?></h3>
                            <a href="/checkout.php">
                                <button type="submit" class="checkoutBttn">Checkout</button>
                            </a>
                        </div>
                    </div>
                    
                </div>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>
    </body>
</html>