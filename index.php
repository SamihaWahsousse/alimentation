<?php
session_start();
include_once('includes/header.php');
require_once("./bdd/Connexion.php");

// on stock la variable globale $_SESSION dans $user
$user = $_SESSION["user"];

// si un utilisateur n'st pas connecté -redirection page login
if (!$user) {
    header("location:login.php");
    exit;
}

// requete vers la BDD pour récupérér la nourriture à la date du jour 

$tabFood = [];

$sql = "SELECT * FROM food_table  where id_user= :user
ORDER BY id_food DESC
lIMIT 10";

$stmt = $conn->prepare($sql);
$stmt->bindValue(":user", $_SESSION["user"]["id"]);
$stmt->execute();

//convertir les données retournées depuis la BDD(object en array) en tableau associatif
$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

//extraire la colonne name_food du tableau stmt et les ajouter dans un nouveau tableau
$arrayNameFood = array_column($stmt, 'name_food');
$arrayCalorieFood = array_column($stmt, 'calorie_food');

//appel de la fonction setChart pour afficher notre doughnut chart avec les data+labels du tableau $stmt (résultat de la requete BDD) 
// utiliser la fonction json_encode pour passeer un tableau en php à une fonction javascript
echo '<script type="text/javascript">'
    . '$(document).ready(function(){'
    . 'setChart(' . json_encode($arrayNameFood) . ',' . json_encode($arrayCalorieFood) . '); });'
    . '</script>';


//function de calcule des calories à ne pas dépasser par jour en fonction de taille/poids/age
function calorieCalculator($weight, $size, $age)
{
    $weightCal = $weight * 13.7516;
    $sizeCal = ($size / 100) * 500.33;
    $weightSize = $weightCal + $sizeCal;
    $ageCal = $age * 6.7550;
    $resultCal = ($weightSize - $ageCal) + 66.473;

    //1.56 l'indice de l'activité physique moins de 3 fois/semaine 
    $totalLimitCalorie = $resultCal * 1.56;
    return round($totalLimitCalorie);
}

//test de la fonction par des valeurs de USER
$limitCaloriePerDay = calorieCalculator(65, 160, 30);

//ajouter une variable pour stocker la somme des calories à afficher dans le graph
$sumCalories = 0;

//inserer la nourriture récupérée dans un tableau-parcourir le tableau
foreach ($stmt as $food) {

    //ajouter une variable de type tab pour stocker les données récupérées dans $stmt
    $data = [
        "name" => $food["name_food"],
        "calorie" => $food["calorie_food"],
        "id_food" => $food["id_food"]
    ];
    array_push($tabFood, $data);

    $sumCalories = $sumCalories + $data['calorie'];

    //vérifier si la somme des calories de l'utilisateur sont supérieur au seuil calculé par la function calorieCalculator
    if ($sumCalories > $limitCaloriePerDay) {
        echo '<script type="text/javascript"> $( document ).ready(function(){$("#modalAlertCalorie").modal("show");}); </script>';
    }
}


$page = [
    "title" => "Track Calorie - Accueil"
];


//tester le serveur par la methode POST et vérifier si $POST n'est pas vide
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nameFood = $_POST["inputRepas"];
    $calorie = $_POST["inputCalories"];


    //insertion de la nourriture de l'utilisateur dans la BDD
    $sql = "INSERT INTO food_table(name_food, calorie_food, id_user) VALUES('$nameFood','$calorie',:user)";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":user", $user["id"]);

    $stmt->execute();
    $result = $stmt->fetchAll();
    array_push($tabFood, ["name" => $nameFood, "calorie" => $calorie]);

    //calcule de la somme des calories dans la column calorie du BDD



    //redirection vers index pour recharger les variable à nouveau 
    header("location:index.php");
}


?>

<body>
    <div class="containerApp">
        <header>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col">
                        <h1>Track Calories</h1>
                    </div>
                    <div class="col-auto">
                        <div class="profil"><a class="btn" href="logout.php"><i class="bi bi-person" style="color: white"><?php echo $user["name"]; ?>
                                    |</i></a>
                            <!-- <?php echo $user["name"]; ?> -->
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main>

            <section class=" dataUser ">
                <div class=" col text-center">
                    IMC: <?php echo $user["IMC"]; ?>
                </div>

                <div class="col">
                    <div class="doughnut">
                        <canvas id="myChart"></canvas>
                        <div class="kcal"> <?php echo $sumCalories ?> kcals</div>
                    </div>
                </div>
                <div class="col text-center">
                    <?php echo $user["weight"]; ?>Kg
                </div>



                <div class="custom-shape-divider-bottom-1671192619">
                    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                        <path d="M600,112.77C268.63,112.77,0,65.52,0,7.23V120H1200V7.23C1200,65.52,931.37,112.77,600,112.77Z" class="shape-fill"></path>
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
                foreach ($tabFood as $food) { ?>
                    <div class='food col d-flex align-items-center justify-content-between '>
                        <div class="foodContainer d-flex flex-column">
                            <div class='titleFood'>
                                <h3><?php echo $food['name']; ?></h3>
                            </div>
                            <div class='calorieFood '><?php echo $food['calorie']; ?> kcal</div>
                        </div>
                        <div class="button Container d-flex">
                            <!--Update food !-->
                            <a class="btn" role="button" data-bs-toggle="modal" data-bs-target="#modalEditFood" id=<?php echo $food["id_food"] ?> <?php echo ' onclick="editLink(\'' . $food['name'] . '\',  \'' . $food['calorie'] . '\' ,\'' . $food['id_food'] . '\')"' ?>>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                </svg>
                            </a>

                            <!-- suppression food !-->
                            <a class="btn" href="deleteFood.php?id_food=<?php echo $food["id_food"]   ?>" role="button">

                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash me-3" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                </svg>
                            </a>

                        </div>
                    </div>


                <?php }


                ?>

            </section>




            <!-- edit FOOD Modal -->
            <div class="modal fade" id="modalEditFood" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                    <input type="text" class="form-control" id="inputRepasEdit" placeholder="Saisissez votre repas" name="inputRepasEdit">
                                    <label for="inputRepasEdit" class="form-label">Repas</label>
                                </div>
                                <div class="mb-2 form-floating mt-2">
                                    <input type="text" class="form-control" id="inputCaloriesEdit" placeholder="Saisissez le nombre de calories" name="inputCaloriesEdit">
                                    <label for="inputCaloriesEdit" class="form-label">Calories</label>
                                </div>
                            </form>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" form="formEditFood" class="btn btn-primary" id="btnEditFood" name="editFood">Modifier</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ADD FOOD Modal -->
            <div class="modal fade" id="modalAddFood" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Ajouter un repas</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="fermer"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" class=" text-center " id="formAddFood">
                                <div class="mb-2 form-floating">
                                    <input type="text" class="form-control" id="inputRepas" placeholder="Saisissez votre repas" name="inputRepas">
                                    <label for="inputRepas" class="form-label">Repas</label>
                                </div>
                                <div class="mb-2 form-floating mt-2">
                                    <input type="text" class="form-control" id="inputCalories" placeholder="Saisissez le nombre de calories" name="inputCalories">
                                    <label for="inputCalories" class="form-label">Calories</label>
                                </div>
                            </form>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" form="formAddFood" class="btn btn-primary" id="btnAddFood">Ajouter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Alert dépassement calories-->
            <div class="modal fade" id="modalAlertCalorie" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header float-right">
                            <h4>Attention!</h4>
                            <div class="text-right">
                                <i data-dismiss="modal" aria-label="Close" class="fa fa-close"></i>
                            </div>
                        </div>
                        <div class="modal-body">
                            <h6>Le seuil de calories recommandés par jour a été dépassé!</h6>
                            <p> Calories consommés : <?php echo $sumCalories ?> Kcals</br>
                                Besoins caloriques journalier: <?php echo $limitCaloriePerDay ?> Kcals
                            </p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>





        </main>

        <footer>
            <div class="text-center ">
                <button type="button" class="btn btn-primary d-block mt-5" data-bs-toggle="modal" data-bs-target="#modalAddFood">ajouter repas</button>

            </div>
        </footer>
    </div>

    <?php include_once('includes/footer.php'); ?>
</body>

</html>