<?php
    include("connect_database.php");

    //Fetch Product Infos
    $stmt = $conn -> prepare("SELECT * FROM lb_products");
    $stmt -> execute();
    $products = $stmt -> fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
    <head>
        <title> Loriz Bakery - View Products </title>
        <link rel="stylesheet" type="text/css" href="css/global.css">
        <link rel="stylesheet" type="text/css" href="css/inv_dashboard.css">
        <link rel="stylesheet" type="text/css" href="css/dashboard_header.css">
        <link rel="stylesheet" type="text/css" href="css/view_product.css">
        <script src="https://kit.fontawesome.com/bfe7538a42.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div id="dbContainer">
            <!-- SIDEBAR -->
            <?php include("dashboard_sidebar.php"); ?>

            <div id="dbBody">
                <!-- HEADER -->
                <?php include("dashboard_header.php"); ?>

                <div class="dbContentContainer">
                    <div class="dbContent">
                        <div class="dbContentHeader">
                            <h3> Loriz Bakery Product List </h3>
                        </div>

                        <div class="dbContentBody">
                            <table class="viewProductTable">
                                <thead>
                                    <tr>
                                        <th> Product Name </th>
                                        <th> Product Price </th>
                                        <th> Product Description </th>
                                        <th> Availability </th>
                                        <th> Quantity </th>
                                        <th> Best-Before Date </th>
                                        <th> Action </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($product['name']) ?></td>
                                        <td><?= number_format($product['price'], 2) ?></td>
                                        <td><?= htmlspecialchars($product['description']) ?></td>
                                        <td><?= htmlspecialchars($product['availability'] ?? 'In Stock') ?></td>
                                        <td><?= htmlspecialchars($product['quantity']) ?></td>
                                        <td><?= htmlspecialchars($product['bb_date']) ?></td>
                                        <td>
                                            <a href="" class="editProd"><i class="fa-solid fa-pen"></i> Edit </a>
                                            <a href="delete_product.php?id=<?= $product['name'] ?>" class="deleteProd" 
                                                data-pname="<?= $product['name'] ?>" 
                                                data-pprice="<?= $product['price'] ?>" 
                                                data-pdesc="<?= $product['description'] ?>" 
                                                data-pavail="<?= $product['availability'] ?>">
                                                <i class="fa-solid fa-trash"></i> Delete 
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                                
                            </div>
                            
                        </div>
                        
                </div>
            </div>
        </div>
    </body>
    <script src="js/inv_sidebar.js"></script>

    <script>
        function inventoryScript() {

            this.initialize = function(){
                this.registerEvents();
            },

            this.registerEvents = function(){
                document.addEventListener('click', function(e){
                    targetElement = e.target;
                    classList = targetElement.classList;

                    if(classList.contains('deleteProd')){
                        e.preventDefault();
                        const pName = targetElement.dataset.pname;
                        const href = targetElement.getAttribute('href');

                        if(window.confirm('Are you sure you want to delete ' + pName + '?')){
                            window.location.href = href;

                        } else {

                        }
                    }
                })
            }
        }
        const script = new inventoryScript;
        script.initialize();
    </script>
</html>