<?php

    $page=[
        "title" => "Track Calorie - Register"
    ];


    include_once('includes/header.php');
?>
<header>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Register Page</h1>
            </div>
        </div>
    </div>
</header>


<main>
    <div class="container ">
        <div class="row justify-content-center">
            <!-- Responsive form-->
            <div class="col-lg-6 col col-md-8">

                <form>
                    <div class="mb-3">
                        <label for="firstName" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="firstName">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email">
                    </div>

                    <div class="mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="range" class="form-range" id="age" min="18" max="100" step="1"
                            oninput="sliderChange1(this.value)" value="">
                        <span id="age-number"></span>
                    </div>

                    <div class="mb-4">
                        <label for="size" class="form-label">Taille</label>
                        <input type="range" class="form-range" id="size" min="50" max="220" step="1"
                            oninput="sliderChange2(this.value)" value="">
                        <span id="size-number"></span>
                    </div>

                    <div class="mb-4">
                        <label for="weight" class="form-label">Poids</label>
                        <input type="range" class="form-range" id="weight" min="30" max="200" step="1"
                            oninput="sliderChange3(this.value)" value="">
                        <span id="weight-number"></span>
                    </div>

                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                        <option selected>Open this select menu</option>
                        <option value="1">Homme</option>
                        <option value="2">Femme</option>
                        <option value="3">Mixte</option>
                    </select>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Submit</button>
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