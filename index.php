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
//connexion à la BDD
require_once("./bdd/Connexion.php");

// requeter la BDD pour récupérér la nourriture à la date du jour 
$tabFood=[];

$sql = "SELECT * FROM food_table  WHERE id_user=1";

$stmt = $conn->prepare($sql);
$stmt->execute();

// set the resulting array to associative
foreach ($stmt as $food) {
   //ajouter une variable de type tab pour stocker les 
   $data=[
    "name"=>$food["name_food"],
    "calorie"=>$food["calorie_food"]
        ];
    array_push($tabFood,$data);

  }

$page=[
    "title" => "Track Calorie - Accueil"
];

include_once('includes/header.php');


//tester le serveur par la methode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nameFood = $_POST["inputRepas"];
    $calorie= $_POST["inputCalories"];
    array_push($tabFood,["name"=>$nameFood ,"calorie"=>$calorie]);
}

var_dump($_POST);

?>

<div class="containerApp">
    <header>
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <h1>Track Calories</h1>
                </div>
                <div class="col-auto">
                    <div class="profil"><i class="bi bi-person"></i>
                        <?php echo $user['name']; ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>

        <section class="dataUser ">
            <div class="col text-center">
                <?php echo $user['IMC']; ?>
            </div>

            <div class="col">
                <div class="doughnut">
                    <canvas id="myChart"></canvas>
                    <div class="kcal">1200 kcal</div>
                </div>
            </div>
            <div class="col text-center">
                <?php echo $user['weight']; ?>Kg
            </div>



            <div class="custom-shape-divider-bottom-1671192619">
                <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                    preserveAspectRatio="none">
                    <path
                        d="M600,112.77C268.63,112.77,0,65.52,0,7.23V120H1200V7.23C1200,65.52,931.37,112.77,600,112.77Z"
                        class="shape-fill"></path>
                </svg>
            </div>

        </section>

        <section class="date">
            <div class="text-center py-3"><?php
                 $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
                echo $formatter->format(time()); ?>
            </div>
        </section>

        <section class="list" id="myList">
            <?php 
foreach ($tabFood as $food){?>
            <div class='food col'>
                <div class='titleFood'>
                    <h3><?php echo $food['name'];?></h3>
                </div>
                <div class='calorieFood '><?php echo $food['calorie'];?> kcal</div>
            </div>

            <?php }


            ?>

        </section>

        <!--mon ancien bouton
        <div class="text-center">
            <button class="d-block mt-5 btn btn-primary mx-auto" data-bs-toggle="modal"
                data-bs-target="#modalAddFood">Add food</button>
        </div>

         Button trigger modal -->

        <!-- Création Modal -->
        <div class="modal fade" id="modalAddFood" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Ajouter un repas</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="fermer"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Création Formulaire modal -->
                        <form method="post" class=" text-center " id="formAddFood">
                            <div class="mb-2 form-floating">
                                <input type="text" class="form-control" id="inputRepas"
                                    placeholder="Saisissez votre repas" name="inputRepas">
                                <label for="inputRepas" class="form-label">Repas</label>

                                <div class="mb-2 form-floating mt-2">
                                    <input type="text" class="form-control" id="inputCalories"
                                        placeholder="Saisissez le nombre de calories" name="inputCalories">
                                    <label for="inputCalories" class="form-label">Calories</label>
                                </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" form="formAddFood" class="btn btn-primary"
                                id="btnAddFood">Ajouter</button>
                        </div>
                    </div>
                </div>
            </div>
    </main>
</div>





<footer>
    <div class="text-center ">
        <button type="button" class="btn btn-primary d-block mt-5" data-bs-toggle="modal"
            data-bs-target="#modalAddFood">+</button>

    </div>
</footer>

<?php include_once('includes/footer.php'); ?>