<?php
 session_start();

include "./bdd/connexion.php";
//récuperer
$id= $_GET['id_food'];
$sql= "DELETE FROM `food_table` WHERE id_food=$id";
$stmt = $conn->prepare($sql);
$stmt->execute();
header("Location:index.php");
?>