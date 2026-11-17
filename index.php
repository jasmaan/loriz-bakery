<!DOCTYPE html>
    <head>
        <title> Loriz Bakery - Homepage </title>
        <link rel="stylesheet" type="text/css" href="css/global.css">
        <link rel="stylesheet" type="text/css" href="css/home.css">
        <script src="https://kit.fontawesome.com/bfe7538a42.js" crossorigin="anonymous"></script>
    </head>

    <body class="homeBody">
        <!-- call the header global template file -->
        <?php include "header.php"; ?> 

        <div class="homeBanner">
            <div class="overlay"></div>
            <div class="homeContainer">
                <div class="homeBannerHeader">
                    <p> Online Pre-Order and Inventory System</p>
                    <h1> Loriz Bakery </h1>
                    <a href="/menu.php"><button class="bannerButton"> Pre-Order Now </button></a>
                </div>
            </div>
        </div>

        <div class="introWrapper">
            <div class="homeIntro">
                <p class="introHeader"> Pre-Order Now </p>
                <h2> Your Favourite Filipino Baked Goods </h2>
                <p class="introBody"> At Loriz Bakery, we use traditional Filipino recipes with a passion for quality to bring you fresh breads and pastries every day. As a family run business, we welcome everyone to share in the warmth, flavours, and hospitality that have made us a neighbourhood favourite. Whether you’re stopping by for a quick treat or picking up something special, we’re here to make your visit memorable. </p>
            </div>
        </div>

        <div class="homeViewMenu">
            <h2> Delicious Bread and Pastries You'll Love </h2>

            <div class="contWrapper">
                <div class="homeContLeft">
                    <img src="../images/pandesal.jpg" alt="pandesal" class="contImage">
                    <p> We offer a delicious variety of breads and pastries made with care. From pandesal to twisted donuts and more, each baked good is crafted to bring the comforting taste of Filipino tradition to your table. </p>
                </div>
                <div class="homeContRight">
                    <img src="../images/twisted-donut.jpg" alt="twisted-donut" class="contImage">
                    <p> If you’re in the mood for something buttery, creamy, or chewy, there’s always something fresh coming out of our oven. Explore the menu and find your next favourite food today! </p>
                </div>
            </div>
        
            <div class="viewMenuWrapper">
                <div class="viewMenuText">
                    <h3> View Our Menu </h3>
                    <p> Click the button on the right or use the navigation at the top to explore our products. </p>
                </div>
                <div class="viewMenuButton">
                    <a href ="/menu.php"><button class="bodyButton"> MENU <i class="fa-solid fa-arrow-right-long"></i> </button></a>
                </div>
            </div>
        </div>

        <!-- call the footer global template file -->
        <?php include "footer.php"; ?>
    </body>
</html>