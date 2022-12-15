<?php
// connexion à la BDD
// un user s'est connecté
// on stock les informations de user dans une variable

$user=[
  "id"=>1,
  "name"=>"samiha",
  "age "=>30,
  "sexe"=>"Femme",
  "weight"=>65,
  "size"=>160,
  "IMC"=>25,
  "email"=>"samiha@mail.com",
  "isLogged"=>true

];
if(!$user ["isLogged"]){
    header("location:login.php");
    exit;
}


$page=[
    "title" => "Track Calorie - Accueil"
];

include_once('includes/header.php');

?>

<div class="container">
  <header>
    <div class="title">Track Calories</div>
    <div class="profil"><?php echo $user['name']; ?></div>
  </header>

  <section class="dataUser">
    <div >Graph</div>
    <div>IMC</div>
    <div><?php echo $user['weight']; ?>Kg</div>
  </section>

  <section class="date">
    <div><?php echo date('l d M Y'); ?></div>

  </section>

  <section class="list">
    <div class="food">
      <div class="titleFood">Pizza</div>
      <div class="calorieFood">504kcal</div>
    </div>
  </section>

  <footer>
   <button>+</button>
  </footer>

</div>

 
<?php include_once('includes/footer.php'); ?>