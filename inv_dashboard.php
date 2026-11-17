<!DOCTYPE html>
    <head>
        <title> Loriz Bakery - Dashboard </title>
        <link rel="stylesheet" type="text/css" href="css/global.css">
        <link rel="stylesheet" type="text/css" href="css/inv_dashboard.css">
        <link rel="stylesheet" type="text/css" href="css/dashboard_header.css">
        <script src="https://kit.fontawesome.com/bfe7538a42.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div id="dbContainer">
            <!-- SIDEBAR -->
            <?php include("dashboard_sidebar.php"); ?>

            <div id="dbBody">
                <!-- HEADER -->
                <?php include("dashboard_header.php"); ?>

                <!-- Have these sections in clickable tiles -->
                <div class="dbContent">
                    <div class="menuTile">
                        <a href="" class="tileLink">
                            <i class="fa-solid fa-square-arrow-up-right expandIcon"></i>
                            <div class="orderSummary">
                                <h3> List of Pre-Orders </h3>
                                <!-- Displays Pre-Order List, their status, and generated order number -->
                                <table class="orderSummaryTable">
                                    <thead>
                                        <tr>
                                            <th> Order No. </th>
                                            <th> Item </th>
                                            <th> Status </th>
                                            <th> Date </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> 000123 </td>
                                            <td> White Bread </td>
                                            <td> Pick-Up </td>
                                            <td> 07/15/2025 </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </a>
                    </div>

                    <div class="menuTile">
                        <a href="" class="tileLink">
                            <i class="fa-solid fa-square-arrow-up-right expandIcon"></i>
                            <div class="highestSoldProduct">
                                <h3> Highest Sold Products </h3>
                                <!-- Displays stats for each product, how many orders it has in the most recent week -->
                            </div>
                        </a>
                    </div>

                    <div class="menuTile">
                        <a href="" class="tileLink">
                            <i class="fa-solid fa-square-arrow-up-right expandIcon"></i>
                            <div class="activeProducts">
                                <h3> Active Products </h3>
                                <!-- Displays which products are up for listing on the menu -->
                            </div>
                        </a>
                    </div>

                </div>
            </div>

            
        </div>

        

    </body>

    <script src="js/inv_sidebar.js"></script>
</html>