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

$sql = "SELECT * FROM food_table  WHERE id_user=1 
ORDER BY id_food DESC
lIMIT 10";

$stmt = $conn->prepare($sql);
$stmt->execute();

//inserer la nourriture récupérée dans un tableau-parcourir le tableau
foreach ($stmt as $food) {
   //ajouter une variable de type tab pour stocker les données récupérées dans $stmt
   $data=[
    "name"=>$food["name_food"],
    "calorie"=>$food["calorie_food"],
    "id_food"=>$food["id_food"]
        ];
    array_push($tabFood,$data);
  }

 
$page=[
    "title" => "Track Calorie - Accueil"
];

include_once('includes/header.php');


//tester le serveur par la methode POST et vérifier si $POST n'est pas vide
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nameFood = $_POST["inputRepas"];
    $calorie= $_POST["inputCalories"];
    
    
    //insertion de la nourriture de l'utilisateur dans la BDD
    $sql="INSERT INTO food_table(name_food, calorie_food, id_user) VALUES('$nameFood','$calorie','1')";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    array_push($tabFood,["name"=>$nameFood ,"calorie"=>$calorie]);
    //redirection vers index pour recharger les variable à nouveau 
    header("location:index.php");
}



//var_dump($tabFood);

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
            <div class='food col d-flex align-items-center justify-content-between '>
                <div class="foodContainer d-flex flex-column">
                    <div class='titleFood'>
                        <h3><?php echo $food['name'];?></h3>
                    </div>
                    <div class='calorieFood '><?php echo $food['calorie'];?> kcal</div>
                </div>
                <div class="button Container d-flex">
                    <!--Update food !-->
                    <a class="btn" role="button" data-bs-toggle="modal" data-bs-target="#modalEditFood"
                        id=<?php echo $food["id_food"] ?>
                        <?php echo ' onclick="editLink(\''.$food['name'] .'\',  \'' .$food['calorie'].'\' ,\''.$food['id_food'].'\')"' ?>>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path
                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                            <path fill-rule="evenodd"
                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                        </svg>
                    </a>

                    <!-- suppression food !-->
                    <a class="btn" href="deleteFood.php?id_food=<?php echo $food["id_food"]   ?>" role="button">

                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-trash me-3" viewBox="0 0 16 16">
                            <path
                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                            <path fill-rule="evenodd"
                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                        </svg>
                    </a>

                    <!--<button id="trash btn btn-primary" type="submit">
                        <a href="deleteFood.php?id_food=<?php echo $food["id_food"]   ?>">
                            
                        </a> 
                    </button>!-->
                </div>
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



        <!-- edit FOOD Modal -->
        <div class="modal fade" id="modalEditFood" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel2">Modifier le repas</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="fermer"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Création Formulaire modal -->
                        <form method="post" action="updateFood.php" class=" text-center " id="formEditFood">
                            <!--stocker l'id du food !-->
                            <input type="hidden" id="inputIdFood" name="inputIdFood">
                            <div class=" mb-2 form-floating">
                                <input type="text" class="form-control" id="inputRepasEdit"
                                    placeholder="Saisissez votre repas" name="inputRepasEdit">
                                <label for="inputRepasEdit" class="form-label">Repas</label>
                            </div>
                            <div class="mb-2 form-floating mt-2">
                                <input type="text" class="form-control" id="inputCaloriesEdit"
                                    placeholder="Saisissez le nombre de calories" name="inputCaloriesEdit">
                                <label for="inputCaloriesEdit" class="form-label">Calories</label>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" form="formEditFood" class="btn btn-primary" id="btnEditFood"
                                name="editFood">Modifier</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ADD FOOD Modal -->
        <div class="modal fade" id="modalAddFood" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Ajouter un repas</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="fermer"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" class=" text-center " id="formAddFood">
                            <div class="mb-2 form-floating">
                                <input type="text" class="form-control" id="inputRepas"
                                    placeholder="Saisissez votre repas" name="inputRepas">
                                <label for="inputRepas" class="form-label">Repas</label>
                            </div>
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
        </div>
    </main>

    <footer>
        <div class="text-center ">
            <button type="button" class="btn btn-primary d-block mt-5" data-bs-toggle="modal"
                data-bs-target="#modalAddFood">+</button>

        </div>
    </footer>
</div>

<?php include_once('includes/footer.php'); ?>