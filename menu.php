<!DOCTYPE html>
    <head>
        <title> Loriz Bakery - Menu </title>
        <link rel="stylesheet" type="text/css" href="css/global.css">
        <link rel="stylesheet" type="text/css" href="css/menu.css">
        <script src="https://kit.fontawesome.com/bfe7538a42.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="pageWrapper">
            <!-- For Search and Filter functions -->
            <?php
            include "header.php";
            include("connect_database.php");

            $searchTerm = $_GET['search'] ?? '';
            $category = $_GET['category'] ?? '';
            $selectedCategory = $category;

            $query = "SELECT * FROM lb_products WHERE 1=1";
            $params = [];

            if (!empty($searchTerm)) {
                $query .= " AND LOWER(name) LIKE LOWER(?)";
                $params[] = "%$searchTerm%";
            }

            if (!empty($category)) {
                $query .= " AND category = ?";
                $params[] = $category;
            }

            $stmt = $conn->prepare($query);
            $stmt->execute($params);
            $products = $stmt->fetchAll();
            ?>

            <div class="menuBanner">
                <h2> Menu and Pre-Order </h2>
                <form method="GET" action="menu.php" class="menuSearchFilter">
                    <div class="searchBox">
                        <input type="text" name="search" placeholder="What are you looking for?" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"/>   
                        <button class="searchButton" type="submit"> Search </button>
                    </div>

                    <div class="menuFilterContainer" id="menuFilterContainer">
                        <label class="filterItems"> Filter Items </label>
                        <select class="filterSelect" name="category" onchange="this.form.submit()">
                            <option value="" <?= $selectedCategory === '' ? 'selected' : '' ?>>All</option>
                            <option value="Loaves" <?= $selectedCategory === 'Loaves' ? 'selected' : '' ?>>Loaves</option>
                            <option value="Buns" <?= $selectedCategory === 'Buns' ? 'selected' : '' ?>>Buns</option>
                            <option value="Snacks" <?= $selectedCategory === 'Snacks' ? 'selected' : '' ?>>Snacks</option>
                        </select>
                        <a href="menu.php" class="clearFilters">Clear Filters</a>
                    </div>
                </form>
                
            </div>

            <div class="menuContainer">
                <h3> Filipino Baked Goods </h3>

                <!-- Product Tiles -->
                <div class="menuTilesContainer">
                    <?php if (count($products) > 0): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="menuTile">
                                <div class="menuImageContainer" style="background-image: url('<?= $product['image_url'] ?>');"></div>

                                <div class="menuTextContainer">
                                    <h4 class="product_name"><?= htmlspecialchars($product['name']) ?></h4> 
                                    <p class="product_price"><?= htmlspecialchars($product['price']) ?></p>
                                    <p class="product_desc"><?= htmlspecialchars($product['description']) ?></p>
                                </div>
                                
                                <div class="menuPopUpContainer">
                                    <a href="javascript:void(0);" class="menuPopUp" data-product-id="<?= $product['product_id'] ?>"> Add to Cart <i class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="text-align: center;">No products found.</p>
                    <?php endif; ?>
                </div>

                <!-- Product Modal -->
                <form id="addToCartForm" method="POST">

                    <!-- Hidden Inputs to Send to Database -->
                     <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" id="modalProductIdInput">
                    <input type="hidden" name="variant" id="modalVariantInput">
                    <input type="hidden" name="quantity" id="modalQtyInput">

                    <div id="productModalContainer" class="modal">
                        <div class="productModalContent">
                            <i class="fa-solid fa-rectangle-xmark closeBttn"></i>
                            <div id="modalProductImage" class="modalProductImage"></div>
                            <div class="modalDetails">
                                <h3 id="modalProductName"></h3>
                                <p id="modalProductDesc"></p>
                                <p id="modalProductPrice"></p>
                                <!-- TEST -->
                                <p> Expiration Date: 10 days </p>
                            
                                <!-- For White Bread option only -->
                                <div id="modalOptions" class="modalOptions">
                                    <label class="custom_radio">
                                        <input type="radio" name="variant_option" value="Sliced"> 
                                        <span class="radio_custom">Sliced</span>
                                    </label>
                                    <label class="custom_radio">
                                        <input type="radio" name="variant_option" value="Unsliced"> 
                                        <span class="radio_custom">Unsliced</span>
                                    </label>
                                </div>

                                <div id="modalQty" class="modalQty">
                                    <button type="button" id="qtyMinus" class="qtyButton">
                                        <i class="fa-solid fa-circle-minus"></i>
                                    </button>
                                    <p id="qtyValue"> 1 </p>
                                    <button type="button" id="qtyAdd" class="qtyButton">    
                                        <i class="fa-solid fa-circle-plus"></i>
                                    </button>
                                </div>

                                <div class="addToCartBttnContainer">
                                    <button type="submit" id="addToCartBttn" class="addToCartBttn">Confirm Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Add to Cart Pop Up -->
                <div id="atcPopUpContainer" class="atcPopUpContainer">
                    <div id="atcPopUpContent" class="atcPopUpContent">
                        <h3> This Item Was Added to Your Cart </h3>
                        <div class="atcBttnWrapper">
                            <a id="cartBttn" class="cartBttn" href="/cart.php">
                                <button class="popUpBttn"> Go to My Cart </button>
                            </a>
                            <a id="backBttn" class="backBttn" href="/menu.php">
                                <button class="popUpBttn"> Continue Shopping </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <?php include "footer.php"; ?>
        </div>
    </body>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById("productModalContainer");
        const modalProductName = document.getElementById("modalProductName");
        const modalProductPrice = document.getElementById("modalProductPrice");
        const modalProductDesc = document.getElementById("modalProductDesc");
        const modalProductImage = document.getElementById("modalProductImage");
        const closeBttn = document.querySelector(".closeBttn");
        const modalProductIdInput = document.getElementById('modalProductIdInput');
        const modalVariantInput = document.getElementById('modalVariantInput');
        const modalQtyInput = document.getElementById('modalQtyInput');

        // Handle quantity for each product
        const minusBtn = document.getElementById('qtyMinus');
        const plusBtn  = document.getElementById('qtyAdd');
        const qtyField = document.getElementById('qtyValue');

        minusBtn.addEventListener('click', () => {
        let qty = parseInt(qtyField.innerText, 10);
        if (qty > 1) qtyField.innerText = qty - 1;
        });

        plusBtn.addEventListener('click', () => {
        let qty = parseInt(qtyField.innerText, 10);
        qtyField.innerText = qty + 1;
        });

        // Handle variant for each product
        document.querySelectorAll('input[name="variant_option"]').forEach(radio => {
            radio.addEventListener('change', () => {
                modalVariantInput.value = radio.value;
            });
        });

        document.querySelectorAll('.menuPopUp').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const tile = this.closest('.menuTile');
                const name = tile.querySelector('.product_name').innerText;
                const price = tile.querySelector('.product_price').innerText;
                const desc = tile.querySelector('.product_desc').innerText;
                const bgImage = tile.querySelector('.menuImageContainer').style.backgroundImage;
                
                const productId = this.getAttribute('data-product-id');
                modalProductIdInput.value = productId;

                qtyField.innerText = "1";
                modalQtyInput.value = 1;
                modalVariantInput.value = '';

                modalProductName.textContent = name;
                modalProductPrice.textContent = "Price: " + price;
                modalProductDesc.textContent = desc;
                modalProductImage.style.backgroundImage = bgImage;
                
                // Show radio options only for "White Bread"
                if (name.trim().toLowerCase() === "white bread") {
                    document.getElementById('modalOptions').style.display = 'block';

                    // Find the selected radio
                    const selectedVariant = document.querySelector('input[name="variant_option"]:checked');
                    modalVariantInput.value = selectedVariant ? selectedVariant.value : "";
                } else {
                    document.getElementById('modalOptions').style.display = 'none';
                    modalVariantInput.value = ""; //to clear the selection
                }

                modal.style.display = "flex"; 
            });
        });

        // Show the Pop Up When URL is Altered
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('added') === '1') {
            const popup = document.getElementById('atcPopUpContainer');
            if (popup) popup.style.display = 'flex';

            // Remove ?added=1 from the URL without reloading
            const url = new URL(window.location);
            url.searchParams.delete('added');
            window.history.replaceState({}, document.title, url.toString());
        }

        // Confirm Add to Cart Pop Up
        const form = document.getElementById('addToCartForm');
        const popup = document.getElementById('atcPopUpContainer');

        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Stop normal form submission

            // Get form data
            modalQtyInput.value = qtyField.innerText.trim();
            const formData = new FormData(form);

            // Send data to cart.php using fetch
            fetch('cart.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(response => {
                // Show popup on success
                popup.style.display = 'flex';
            })
            .catch(err => {
                alert('Error adding item to cart.');
                console.error(err);
            });
        });

        // Close modal
        closeBttn.onclick = () => {
            modal.style.display = "none";
        };
        window.onclick = (e) => {
            if (e.target === modal) {
                modal.style.display = "none";
            }
        };
    });
    </script>
</html>