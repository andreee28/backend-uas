<?php
    function getConnection() {
        $host = 'localhost';
        $dbname = 'andrejoh_andrejohan';
        $username = 'andrejoh_andrejohan';
        $password = 'uaspweb2023';

        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
?>