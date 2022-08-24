<?php
$host = "localhost";
$db_name = "stand_blog";
$user = "root";
$password = "";
date_default_timezone_set("Asia/Dhaka");

try{
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

//  Student Data Count
function admin($col,$id){
    global $pdo;
    $stm=$pdo->prepare("SELECT $col FROM admin WHERE id=?");
    $stm->execute(array($id));
    $results = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $results[0][$col];
}





?>