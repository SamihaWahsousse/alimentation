<?php
session_start();
include_once('includes/header.php');
require_once  "./bdd/connexion.php";

$page = [
    "title" => "Track Calorie - Login"
];

// on vérifie si l'utilisateur est déjà connecté 
if (isset($_SESSION["user"]) && !empty($_SESSION["user"]["id"])) {
    header("Location:index.php");
}

//on vérifie si le formulaire a été bien envoyé
if (!empty($_POST)) {

    //on vérifie que tous les champs requis sont remplis
    if ((isset($_POST["mail"], $_POST["password"]) && !empty($_POST["mail"]) && !empty($_POST["password"]))) {

        //on vérifie si $_post ['mail'] respecte le format d'un email
        if (!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["errorMessage"] = "l'adresse mail est incorrect!.";
        }

        //on vérife si l'email existe dans la BDD
        $sql = "SELECT * FROM `users`  WHERE `Email`= :mail";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(":mail", $_POST["mail"], PDO::PARAM_STR);

        $stmt->execute();
        $user = $stmt->fetch();


        if (!$user) {
            $_SESSION["errorMessage"] = "l'utilisateur et/ou mot de passe est incorrect.";
        }


        //l'utilisateur existe dans notre bdd,on vérifie le mot de passe 
        if (!password_verify($_POST["password"], $user["password"])) {
            $_SESSION["errorMessage"] = "l'utilisateur et/ou mot de passe est incorrect.";
        } else {

            //formule pour calculer l'IMC de l'utilisateur à partir de la variable de session
            $calcImc = (round($user["weight"]) / pow((($user["size"]) / 100), 2));

            //créer une session pour le calcul IMC qui ne fait pas partie des paramètres $_POST envoyées par l'utilisateur dans le formulaire register
            $user["IMC"] = $calcImc;

            //l'utilisateur et mot de passe sont corrects,on ouvre une session PHP pour stocker les informations de connexion de notre utilisateur connecté
            $_SESSION["user"] = $user;

            // supprimer les messages d'erreurs affichés
            unset($_SESSION["errorMessage"]);

            //on redirige l'utilisateur vers la page index.php
            header("location:index.php");
        }
    }
}

?>
<div class="containerApp">
    <header>
        <div class="row text-center"></div>
        <div class="col-auto">
            <h1 class="text-center">Login Page</h1>
        </div>
    </header>

    <div class="container mt-5 w-50">
        <div class="row">
            <div class="col">
                <div class="errorMessage">
                    <?php
                    if (isset($_SESSION["errorMessage"])) {
                        echo ($_SESSION["errorMessage"]);
                    } ?>
                </div>
                <form method="POST" class=" text-center ">
                    <div class="mb-2 form-floating">
                        <input type="email" name="mail" class="form-control" id="inputEmail" placeholder="Saisissez votre email" autocomplete="off">
                        <label for="inputEmail" class="form-label">Email</label>

                    </div>
                    <div class="row">
                        <div class="mb-2 form-floating">
                            <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Saisissez votre mot de passe" autocomplete="off">
                            <label for="inputPassword" class="form-label">Password</label>
                            <p style="display:none" id="error">Nom d'utilisateur ou mot de passe incorecct!
                            </p>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-3">
        <button type="submit" class="btn btn-primary" name="ok">Login</button>
    </div>
    </form>

    <div class="text-center mt-3">
        <span> Tu n'as pas encore de compte ? </span>
        <span class="linkRegister">
            <a href="register.php">Inscrivez-vous</a>
        </span>
    </div>
</div>


<?php
include_once('includes/footer.php');
?>