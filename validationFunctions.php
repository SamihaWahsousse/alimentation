<?php

require_once('./bdd/Connexion.php');


//function to verify if the email is already registred - is already stored in database

// $email = $_POST['email']; // Assuming you're getting the email from a form

$sql = "SELECT COUNT(*) FROM users WHERE Email = :email";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();

$count = $stmt->fetchColumn();

if ($count > 0) {
    echo "Email already exists in the database.";
} else {
    echo "Email is not in the database, you can proceed with registration.";
}

// $conn = null; // Close the database connection