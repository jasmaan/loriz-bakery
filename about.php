<!DOCTYPE html>
    <head>
        <title> Loriz Bakery - About </title>
        <link rel="stylesheet" type="text/css" href="css/global.css">
        <link rel="stylesheet" type="text/css" href="css/home.css">
        <link rel="stylesheet" type="text/css" href="css/about.css">
        <script src="https://kit.fontawesome.com/bfe7538a42.js" crossorigin="anonymous"></script>
    </head>

    <body class="homeBody">
        <!-- call the header global template file -->
        <?php include 'header.php'; ?>

        <div class="aboutBanner">
            <div class="overlay"></div>
            <div class="homeContainer">
                <div class="homeBannerHeader">
                    <p> About Us</p>
                    <h1> Loriz Bakery </h1>
                </div>
            </div>
        </div>

        <div class="aboutHistory">
            <div class="historyWrapper">
                <div class="historyHeader">
                    <h2> Our History </h2>
                </div>

                <div class="historyBody">
                    <h3> A True Taste Of Home In Calgary </h3>
                    <p> Loriz Bakery began as a small family business in Calgary, dedicated to sharing the comforting taste of Filipino bread and pastries with the local community. It started as a neighbourhood bakery serving Calgary’s Filipino population but quickly flourished into a beloved spot embraced by many cultures across the city. We welcome people of all backgrounds who have come to enjoy the authentic flavours and hospitality that define our heritage. From freshly baked pandesal to hopia, Loriz Bakery is where tradition and community come together through food. </p>
                </div>
            </div>
        </div>
        
        <div class="aboutMission">
            <div class="missionHeader">
                <h2> Mission Statement </h2>
                <p> At Loriz Bakery, our mission is to create a welcoming space and provide fresh, authentic Filipino baked goods. Our goals are broken down into these key areas: </p>
            </div>

            <div class="missionWrapper">
                <div class="percentCont">
                    <h2> 40% </h2>
                    <h3> Authentic Filipino Recipes </h3>
                    <p> We stay close to our roots by using traditional recipes that reflect Filipino heritage and deliver a genuine taste of home. </p>
                </div>

                <div class="percentCont">
                    <h2> 30% </h2>
                    <h3> Freshness and Quality </h3>
                    <p> Our goods are baked fresh with care, using ingredients that customers can trust are high quality. </p>
                </div>

                <div class="percentCont">
                    <h2> 30% </h2>
                    <h3> Customer Experience </h3>
                    <p> Our bakery aims to make every customer feel like family through friendly service and a warm atmosphere. </p>
                </div>
            </div>
        </div>

        <div class="empty">

        </div>

        <!-- call the footer global template file -->
        <?php include "footer.php"; ?>
    </body>
    
</html>
