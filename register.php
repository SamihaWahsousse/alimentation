<?php
include_once('includes/header.php');
require_once './bdd/Connexion.php';

$page = [
    "title" => "Track Calorie - Register"
];


//on vérifie si le formulaire a été bien envoyée
if (!empty($_POST)) {

    //on récupère les données
    $userName = strip_tags($_POST['firstName']);
    $mail = $_POST['email'];
    $pwd = $_POST['password'];
    $age = $_POST['Age'];
    $size = $_POST['Size'];
    $weight = $_POST['Weight'];
    $sexe = $_POST['Sexe'];

    //on vérifie que tous les champs requis sont remplis
    if (
        isset($userName, $mail, $pwd, $age, $size, $weight, $sexe) &&
        !empty($mail) && !empty($pwd) && !empty($age) && !empty($size) && !empty($weight) &&
        !empty($sexe)
    ) {

        //vérification si l'email indiqué par le user respecte le format du mail - on récupère les données 
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["errorMessage"] = "l'adresse mail est incorrect!.";
        }

        //vérifier si l'adresse mail est déjà stockée dans la BDD 
        $sql = "SELECT COUNT(*) FROM users WHERE Email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $mail, PDO::PARAM_STR);
        $stmt->execute();

        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $_SESSION["errorMessage"] = "Email already exists in the database.";
        } else {

            //hasher le mot de passe entré par l'utilisateur
            $passHach = password_hash($pwd, PASSWORD_ARGON2I);

            $sql = "INSERT INTO `users`(`name`,`Email`,`password`,`age`,`size`,`weight`,`sexe`) VALUES(:firstName,:email,:password,:Age,:Size,:Weight,:Sexe)";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":firstName", $userName, PDO::PARAM_STR);
            $stmt->bindValue(":email", $mail, PDO::PARAM_STR);
            $stmt->bindValue(':password', $passHach, PDO::PARAM_STR);
            $stmt->bindValue(":Age", $age, PDO::PARAM_INT);
            $stmt->bindValue(":Size", $size, PDO::PARAM_INT);
            $stmt->bindValue(":Weight", $weight, PDO::PARAM_INT);
            $stmt->bindValue(":Sexe", $sexe, PDO::PARAM_STR);

            $stmt->execute();

            //on récupère l'id de l'utilisateur nouvellement crée pour l'ajouter dans la variable $_SESSION
            $id = $conn->lastInsertId();

            header("Location:index.php");
        }
    } else {
        $_SESSION["errorMessage"] = "Veuillez remplir les champs du formulaire.";
    }
}

?>



<!-- HTML FORM REGISTER -->
<header>
    <div class="container text-center">
        <div class="row">
            <div class="col">
                <h1>Register Page</h1>
            </div>
        </div>
    </div>
</header>


<main>
    <div class="container mt-4 ">
        <div class="row justify-content-center">

            <!-- Responsive form-->
            <div class="col-lg-6 col col-md-8">
                <div class="errorMessage">
                    <?php
                    if (isset($_SESSION["errorMessage"])) {
                        echo ($_SESSION["errorMessage"]);
                    } ?>
                </div>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">Nom</label>
                        <input type="text" class="form-control" name="firstName" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" name="password">
                    </div>

                    <div class="mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="range" class="form-range" name="Age" id="age" min="18" max="100" step="1" oninput="sliderChange1(this.value)" value="">
                        <span id="age-number"></span>
                    </div>

                    <div class="mb-4">
                        <label for="size" class="form-label">Taille(cm)</label>
                        <input type="range" class="form-range" name="Size" id="size" min="50" max="220" step="1" oninput="sliderChange2(this.value)" value="">
                        <span id="size-number"></span>
                    </div>

                    <div class="mb-4">
                        <label for="weight" class="form-label">Poids(kg)</label>
                        <input type="range" class="form-range" name="Weight" id="weight" min="30" max="200" step="1" oninput="sliderChange3(this.value)" value="">
                        <span id="weight-number"></span>
                    </div>

                    <select class="form-select" name="Sexe" id="floatingSelect" aria-label="Floating label select example">
                        <option selected>Choisir votre sexe</option>
                        <option value="Homme">Homme</option>
                        <option value="Femme">Femme</option>
                    </select>

                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-primary" name="submitRegisterForm">S'inscrire</button>
                    </div>
                </form>

                <a href="login.php">login</a>

            </div>
        </div>
    </div>

</main>

<footer>


</footer>

<?php include_once('includes/footer.php'); ?>