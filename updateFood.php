<?php
        session_start();

require_once "./bdd/connexion.php";

//var_dump($_POST);

if(isset($_POST['inputRepasEdit']) && !empty($_POST['inputRepasEdit']) && isset($_POST['inputCaloriesEdit'])
 && !empty($_POST['inputCaloriesEdit']) && isset($_POST['inputIdFood']) && !empty ($_POST['inputIdFood'])){
    
            $nameFood=htmlspecialchars($_POST['inputRepasEdit']);
            $calorieFood=htmlspecialchars($_POST['inputCaloriesEdit']);
            
        

$namefoodUpdate=$_POST['inputRepasEdit'];
$calorieFoodUpdate=$_POST['inputCaloriesEdit'];   
$idFood= $_POST['inputIdFood'];
     
        $sql= "UPDATE food_table SET name_food='$namefoodUpdate',calorie_food='$calorieFoodUpdate' WHERE id_food='$idFood'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        header("Location:index.php");

    }
    
?>