<?php
    session_start();

    if (!isset($_SESSION['user'])) header('location: lb_login.php');
    $user = $_SESSION['user'];
?>

<!DOCTYPE html>

    <head>
        <link rel="stylesheet" type="text/css" href="css/global.css">
        <link rel="stylesheet" type="text/css" href="css/dashboard_sidebar.css">
        <script src="https://kit.fontawesome.com/bfe7538a42.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div id="dbSidebar">
            <div class="dbLogoContainer">
                <img src="../images/loriz-logo.png" alt="LorizLogo" id="dbLogo">
            </div>

            <div id="dbSidebarUser">
                <img src="" alt="UserImage" id="userImage"/>
                <span id="userName"><?= $user['first_name'] ?></span> 
            </div>

            <div class="dbSidebarMenu">
                <ul id="dbMenuList">
                    <li class="mainMenus">
                        <a href="inv_dashboard.php" class="menuActive"><i class="fa-solid fa-gauge menuIcons"></i><span class="menuText">Dashboard</span></a>
                    </li>

                    <li class="mainMenus">
                        <a href="javascript:void(0);" class="toggleSubMenu">
                            <i class="fa-solid fa-box-archive menuIcons"></i><span class="menuText">Product Management</span>
                            <i class="fa-solid fa-chevron-down menuExpand"></i>
                        </a>
                            

                        <ul class="subMenus">
                            <li><a href="view_product.php" class="subMenuLink"><i class="fa-solid fa-list-ul"></i> View Products </a></li>
                            <li><a href="add_product.php" class="subMenuLink"><i class="fa-solid fa-plus"></i> Add Products </a></li>
                        </ul>
                        
                    </li>

                    <li class="mainMenus">
                        <a href=""><i class="fa-solid fa-gear menuIcons"></i><span class="menuText">Settings</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </body>

    <script src="js/inv_sidebar.js"></script>

</html>
