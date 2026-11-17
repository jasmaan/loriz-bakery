<!DOCTYPE html>
    <head>
        <title> Loriz Bakery - Add a Product </title>
        <link rel="stylesheet" type="text/css" href="css/global.css">
        <link rel="stylesheet" type="text/css" href="css/inv_dashboard.css">
        <link rel="stylesheet" type="text/css" href="css/dashboard_header.css">
        <link rel="stylesheet" type="text/css" href="css/add_product.css">
        <script src="https://kit.fontawesome.com/bfe7538a42.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <?php
        ob_start();
        
        include ("connect_database.php");
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $price = $_POST["price"];
            $description = $_POST["description"];

            try {
                $stmt = $conn-> prepare("INSERT INTO lb_products(name, price, description) VALUES (?, ?, ?)");
                $stmt-> execute([$name, $price, $description]);
                $success = "Product added successfully!";
            } catch (PDOException $e) {
                $error = "Error: " . $e->getMessage();
            }
        }
        ?>

        <div id="dbContainer">
            <!-- SIDEBAR -->
            <?php include("dashboard_sidebar.php"); ?>

            <div id="dbBody">
                <!-- HEADER -->
                <?php include("dashboard_header.php"); ?>

                <div class="dbContentContainer" id="dbContentContainer">
                    <div class="dbContent">
                        <div class="dbContentHeader">
                            <h3> Add a Product </h3>
                        </div>

                        <div class="dbContentBody">
                            <form method="POST">
                            <label class="pname"> Product Name: <input type="text" name="name" required></label><br>
                            <label class="price"> Price: <input type="text" name="price" required></label><br>
                            <label class="desc"> Description: <textarea name="description"</textarea></textarea></label><br>    
                            <button class="submitBttn" type="submit"> Add Product </button>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
    </body>
    <script src="js/inv_sidebar.js"></script>
</html>