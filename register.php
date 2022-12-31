<?php
    $page=[
        "title" => "Track Calorie - Register"
    ];
    include_once('includes/header.php');
    //on vérifie si le formulaire a été bien envoyée

    if (!empty($_POST)) {
        //on récupère les données  en les protègeant
        $userName = strip_tags($_POST['firstName']);
        $mail=$_POST['email'];
        $pwd =$_POST['password'];
        $age=$_POST['Age'];
        $size=$_POST['Size'];
        $weight=$_POST['Weight'];
        $sexe=$_POST['Sexe'];
        //$calcImc=($weight/10)/()
       // var_dump($_POST);
        //on vérifie que tous les champs requis son remplis
            if(isset($userName,$mail,$pwd,$age,$size,$weight,$sexe) && 
            !empty($mail) && !empty($pwd) && !empty($age) && !empty($size) && !empty($weight) &&
            !empty($sexe)
            ){
        //le formulaire est complet
        //vérification si $_post ['email'] respecte le format d'un email
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)){
                die("l'adresse mail est incorrect!");
            }

        //hasher les mots de passe 
            $passHach=password_hash($pwd,PASSWORD_BCRYPT);

        //on enregistre dans la bdd
        require_once "./bdd/connexion.php";
        $sql = "INSERT INTO `users` (`name`,`Email`,`password`,`age`,`size`,`weight`,`sexe`) VALUES('$userName','$mail','$passHach','$age','$size','$weight','$sexe')";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        /*on récupère l'id de l'utilisateur nouvellement crée pour
        l'ajouter dans la variable $_SESSION*/
        $id= $conn->lastInsertId();

        //ici on connecte l'utilisateur
        //on démarre une session PHP
        session_start();
        
        //on stocke les informations de user dans $_SESSION
        $_SESSION["user"]=[
            "id"=>$id,
            "name"=>$userName,
            "email"=>$mail,
            "Age"=>$age,
            "Size"=>$size,
            "Weight"=>$weight,
            "Sexe"=>$sexe
     ];     
     
//on redirige l'utilisateur vers la page index.php

header("location:index.php");



                

            }else{
                die("le formulaire est incomplet");

            }
        
        }

?>

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

                <form method="post">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">Nom</label>
                        <input type="text" class="form-control" name="firstName">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" name="password">
                    </div>

                    <div class="mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="range" class="form-range" name="Age" id="age" min="18" max="100" step="1"
                            oninput="sliderChange1(this.value)" value="">
                        <span id="age-number"></span>
                    </div>

                    <div class="mb-4">
                        <label for="size" class="form-label">Taille(cm)</label>
                        <input type="range" class="form-range" name="Size" id="size" min="50" max="220" step="1"
                            oninput="sliderChange2(this.value)" value="">
                        <span id="size-number"></span>
                    </div>

                    <div class="mb-4">
                        <label for="weight" class="form-label">Poids(kg)</label>
                        <input type="range" class="form-range" name="Weight" id="weight" min="30" max="200" step="1"
                            oninput="sliderChange3(this.value)" value="">
                        <span id="weight-number"></span>
                    </div>

                    <select class="form-select" name="Sexe" id="floatingSelect"
                        aria-label="Floating label select example">
                        <option selected>Choisir votre sexe</option>
                        <option value="Homme">Homme</option>
                        <option value="Femme">Femme</option>
                    </select>

                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-primary">S'inscrire</button>
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