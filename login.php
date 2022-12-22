<?php

    $page=[
        "title" => "Track Calorie - Login"
    ];
    include_once('includes/header.php');
    //include "Connexion.php";
?>


<div class="containerApp">
    <header>
        <div class="row text-center"></div>
        <div class="col-auto">
            <h1>Login Page</h1>
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
                            <p style="display:none" id="error">Nom d'utilisateur ou mot de passe incoorect!
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

include "connexion.php";

/*if(isset($_POST['ok']))
$_['mail']) && isset($_POST['password']) ){

    
    // création de connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // vérifier connexion 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $mail = $_POST['mail'];
    $pwd = $_POST['password'];
    $sql = "SELECT * FROM `utilisateur` WHERE `email` = '$mail' AND `password` = '$pwd' ";

    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        header("Location: ./AjouterCarnetRappel.php");
    } else {
        header("Location: .");
        exit;
    }
    $conn->close();
}

?>

*/

if(isset($POST['ok'])){

$mail = $_POST['mail'];
$pwd = $_POST['password'];
$sql = "SELECT * FROM users WHERE Email = '$mail' AND `password`='$pwd'";
$result = $conn->query($sql);

if ($result->rowCount() == 1) {



if($donnees=$result->fetch()){
header("Location: index.php");
} else {
header("Location: .");
echo"

else{

echo"
<script>
document.getElementById(`error`).style.display = 'block';
document.getElementById(`error`).style.color = 'red';
</script> ";

}





exit;

?
>

<?php include_once('includes/footer.php'); ?>