<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trackcalorie";


try {
  $conn = new PDO("mysql:host=$servername;port=3307;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("connection failed: " . $e->getMessage());
}
