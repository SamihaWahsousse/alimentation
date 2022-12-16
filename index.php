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

<div class="containerApp">
    <header>
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <h1>Track Calories</h1>
                </div>
                <div class="col-auto">
                    <div class="profil"><i class="bi bi-person"></i>
                    </div>
                    <?php echo $user['name']; ?>
                </div>
            </div>
        </div>


    </header>
    <main>
        <section class="dataUser">

            <div class="doughnut">
                <canvas id="myChart"></canvas>
                <div class="kcal">1200 kcal</div>
            </div>

            <div>IMC</div>
            <div><?php echo $user['weight']; ?>Kg</div>
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
            <div><?php
        //date default timezone
       // date_default_timezone_set('Europe/Paris');
        //instnaciation a new dateTime object
        //$dateTimeObj= new DateTime('now', new DateTimeZone('Europe/Paris'));
        $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        echo $formatter->format(time()); ?>


                <?php echo date('l d M Y'); ?></div>

        </section>

        <section class="list">
            <div class="food">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius eos quos accusamus, molestiae adipisci
                dolorum nam itaque eligendi! At, deleniti dolor pariatur assumenda modi cum delectus qui. Pariatur,
                explicabo harum.
                Tenetur, aliquid. Quis nemo mollitia debitis adipisci possimus laboriosam iste quo dolorum, provident
                tempore! Earum libero cupiditate optio dolore doloribus iure numquam nulla facere, necessitatibus iste
                exercitationem soluta eveniet nesciunt.
                Debitis consequuntur odit veniam sed quia, facilis autem eveniet consequatur odio ratione! Aperiam vel
                consequatur voluptas veritatis recusandae dolores optio ex repudiandae illum? Maxime odit minima,
                molestias hic rerum possimus!
                Doloribus natus laudantium, cumque distinctio non ut minus excepturi. Culpa amet voluptate, aliquid,
                nihil rerum quas molestias, iusto sit pariatur tenetur fuga earum. Explicabo corporis eius nemo harum!
                Illo, debitis?
                Amet odio aliquam fuga voluptatem, incidunt error inventore numquam facere! Omnis ullam eaque hic.
                Recusandae, ex aliquid alias corporis fugit numquam quis dicta ducimus, aliquam nisi obcaecati
                consectetur molestias quam.
                Odit, ut non mollitia sint ipsum consequatur cumque officia sed vitae, quia fugiat, quae ipsam?
                Voluptates esse eius nemo, porro doloribus quas hic quos rerum vitae nisi totam explicabo accusantium!
                Explicabo temporibus perspiciatis dolorem ducimus quos? Ducimus quidem labore voluptatum inventore
                recusandae veniam rerum eaque exercitationem. Voluptate quos repellendus distinctio eius, dolore
                veritatis ratione maxime ut minima voluptatem recusandae dolor!
                Dolorem autem voluptas facere aut vitae sed obcaecati saepe rem error in, accusamus iusto, ea mollitia
                ipsum illo? Quos error id mollitia asperiores rerum aut laudantium quibusdam quas tempora ratione.
                Mollitia at ex aut expedita rerum quod beatae earum dolorem minima placeat, corrupti dolores iste! Eum
                cumque et aspernatur, voluptatum in totam tempora voluptatem enim laudantium placeat amet non voluptate?
                Maiores ipsa ex voluptatibus odit eligendi sequi excepturi quod iusto, sed nisi quas dolores accusamus
                fuga illo eos quia, quibusdam quis sunt! Fugiat quasi esse, ipsa soluta commodi reiciendis vel?
                Inventore, pariatur id similique nihil dolore odit quam maiores! Distinctio ipsam deserunt quis tempora
                molestiae sint molestias beatae est corrupti, necessitatibus cumque, maiores nisi fuga autem quaerat
                nesciunt? At, laudantium!
                Neque, eligendi dignissimos. Distinctio similique dolores harum itaque repudiandae corporis doloribus in
                natus consequuntur. Distinctio repudiandae beatae maiores voluptate explicabo ab vel adipisci asperiores
                magnam, non illo atque tempore! Fugiat.
                Tempore a ex omnis eveniet necessitatibus nihil aliquam unde reiciendis, porro possimus maiores iste
                doloribus delectus? Quia doloribus nam illum, quisquam rerum facere natus reprehenderit suscipit magnam
                doloremque provident sit?
                Quos modi cum voluptas eos unde nisi, officia obcaecati nesciunt dignissimos sit cumque nemo ut,
                deleniti dolorem, laboriosam pariatur amet repudiandae nobis vel eaque voluptatem natus. Vitae eos ad
                iste.
                Culpa et ex, ullam quibusdam exercitationem quis praesentium aut corrupti eveniet inventore autem,
                minima a provident sapiente sit, omnis nemo placeat natus maxime! Dignissimos blanditiis placeat hic,
                dolorum sit quisquam?
                Ipsa eum fugit repellat, dolorem incidunt nulla nemo magni itaque possimus placeat eaque minima autem
                dolores vero cupiditate nesciunt enim nihil id excepturi numquam inventore quibusdam delectus.
                Explicabo, voluptate iure?
                Inventore veritatis qui, sequi eaque dicta assumenda illum quaerat animi nobis at possimus maxime?
                Repellat, nobis deserunt? Distinctio ut, nihil aperiam similique nobis, corporis maiores quo, inventore
                error omnis ipsam!
                Tempore odit quisquam culpa nulla similique, maxime natus iure, numquam pariatur velit, sequi possimus.
                Mollitia soluta aliquid inventore porro earum amet voluptates nisi accusantium qui quos. Minima
                obcaecati similique hic.
                Deserunt, delectus maxime dignissimos quidem dicta incidunt sequi ipsa nihil accusantium distinctio
                mollitia repellendus placeat omnis itaque non, quod ad nisi beatae culpa, temporibus tempora! Maxime
                eaque repudiandae atque eveniet?
                Nam ab commodi cupiditate cum, perspiciatis voluptatem reprehenderit voluptatum cumque veritatis quia
                dolorum inventore tenetur accusamus. Aliquam tempora qui deserunt soluta perferendis fugiat eaque. Odio
                ullam expedita enim iusto molestias!
                <div class="titleFood">Pizza</div>
                <div class="calorieFood">504kcal</div>
            </div>
        </section>
    </main>
    <footer>
        <button>+</button>
    </footer>

</div>


<?php include_once('includes/footer.php'); ?>