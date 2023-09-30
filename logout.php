<?php
//il faut d'abord démarrer la session user 
session_start();
 //si l'utilisateur est déjà deconnecté il pourra aller à login  
 if (!isset($_SESSION["user"])){
    header("location:login.php");
    exit; 
   }
//on supprime la variable qui contient toutes les données de session de l'utilisateur
unset($_SESSION["user"]);
header("location: login.php");



?>