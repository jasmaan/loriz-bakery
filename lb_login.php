<?php
    session_start(); //Start the session
    //$error_message = "";

    if($_POST){
        include "connect_database.php";

        $username = $_POST["username"];
        $password = $_POST["password"]; 

        $query = 'SELECT * FROM lb_users WHERE username= :username AND user_pass= :password';
        $stmt = $conn->prepare($query);
        $stmt->bindParam('username', $username);
        $stmt->bindParam('password', $password);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $user = $stmt->fetchAll()[0];
        $_SESSION['user'] = $user;

        if ($user) {
            $logSuccess = "Login Successful!";
            header("Location: inv_dashboard.php");
            exit();
        } else {
            $logInvalid = "Invalid Username or Password.";
        }

    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Loriz Bakery - Login</title>       
        <link rel="stylesheet" type="text/css" href="css/global.css">
        <link rel="stylesheet" type="text/css" href="css/lb-login.css">
    </head>

    <body id="loginBody">
        <div class="loginContainer">
            <div class="loginHeader">
                <h1> Loriz Bakery</h1>
                <p> Online Pre-Order and Inventory System </p>
            </div>

            <div class="loginBody">
                <form action="lb_login.php" method="POST">
                    <!--Username and password input box--> 
                    <div class= "loginInputContainer">
                        <!-- Can be changed into an email input instead -->
                        <label for=""> Username </label>
                        <input placeholder= "Username" type="text" name= "username"/>
                    </div>

                    <div class= "loginInputContainer">
                        <label for=""> Password </label>
                        <input placeholder= "Password" type="password" name= "password"/>
                    </div>

                    <!--Login Button--> 
                    <div class= "loginButtonContainer">
                        <button> Login </button>
                    </div>
                </form>

                <!-- Error Message -->
                <?php /*if(!empty($error_message)) { ?>
                    <div id="errorMessage">
                        <p> Error: <?= $error_message ?> </p>
                    </div>
                <?php } */?>
                
                <?php /*if($user) { ?>
                    <div id="logMessage">
                        <p> <?= $logSuccess ?> </p>
                    </div>
                <?php } else { ?>
                    <div id="logMessage">
                        <p> <?= $logInvalid ?> </p>
                    </div>
                <?php } */?>
            </div>
        </div>
    </body>
</html>