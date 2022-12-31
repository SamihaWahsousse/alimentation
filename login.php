<?php
session_start();

    $page=[
        "title" => "Track Calorie - Login"
    ];
    include_once('includes/header.php');
    //on vérifie si le formulaire a été envoyé
    if(!empty($_POST)){
        //on vérifie que tous les champs raquis sont remplis
        if((isset($_POST["mail"],$_POST["password"]) && !empty($_POST["mail"]) && !empty($_POST["password"]))
            ){
        //vérification si $_post ['email'] respecte le format d'un email
            if (!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)){
                die("Ce n'est pas un email!");
                                                                     }
    //on se connecte à la bdd
    include "./bdd/connexion.php";

    $sql = "SELECT * FROM `users`  WHERE `Email`= :mail";

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(":mail",$_POST["mail"]);
    
    $stmt->execute();
    $user= $stmt->fetch();
    
    if(!$user){
        die("l'utilisateur et/ou mot de passe est incorrect");
    }

    //l'utilisateur existe dans notre bdd,on peut vérifier le mot de passe 
    if(!password_verify($_POST["password"], $user["password"])){

        die("l'utilisateur et/ou mot de passe est incorrect");
                                                             }


     //l'utilisateur et mot de passe sont corrects,on ouvre une session PHP pour stocker les informations de connexion
     //de notre utilisateur connecté
     $_SESSION["user"]=[
            "id"=>$user["id"],
            "name"=>$user["name"],
            "email"=>$user["Email"],
            "Age"=>$user["age"],
            "Size"=>$user["size"],
            "Weight"=>$user["weight"],
            "Sexe"=>$user["sexe"]
     ];     
     
//on redirige l'utilisateur vers la page index.php

header("location:index.php");


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
                <form method="POST" class=" text-center ">
                    <div class="mb-2 form-floating">
                        <input type="email" name="mail" class="form-control" id="inputEmail"
                            placeholder="Saisissez votre email">
                        <label for="inputEmail" class="form-label">Email</label>

                    </div>
                    <div class="row">
                        <div class="mb-2 form-floating">
                            <input type="password" name="password" class="form-control" id="inputPassword"
                                placeholder="Saisissez votre mot de passe">
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



/*if(isset($POST['ok'])){

    

    if ($result->rowCount() == 1) {
  
            header("Location: ./index.php");
        } else {
            header("Location: .");
            echo"utilisateur inexistant dans la bdd";
            exit;
        }
        
    }
if($donnees=$result->fetch()){
header("Location: index.php");
} else {
header("Location: .");
echo'
<script>
document.getElementById(`error`).style.display = "block";
document.getElementById(`error`).style.color = "red";
</script> ;'

}*/
include_once('includes/footer.php');
?>