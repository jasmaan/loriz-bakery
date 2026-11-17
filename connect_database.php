<?php
    //Load database credentials from config.php, which is kept out of Git.
    //To set up: copy config.example.php to config.php and fill in your values.
    require __DIR__ . '/config.php';

    //Establishing a Connection to Database
    //PDO = PHP Data Objects
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        //Set PDO error handling
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo"Connected successfully.";
    }catch (PDOException $e) {
        $error_message = $e->getMessage();
    }
?>