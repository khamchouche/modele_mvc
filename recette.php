<?php
//Récupération de la recette  grace à l'id transmis dans le GET
//ATTENTION Cette méthode de travail n'est pas sécurisée. LA bonne méthode sera abordée ultérieurement

$id_recette = isset($_GET['id_recette'])?$_GET['id_recette']:null;



//Connexion à la base de données en pdo
$pdo = new PDO('mysql:host=localhost;dbname=yabontiap_bd', 'root', '');

//Construction de la requête
$sql = "SELECT * FROM yabontiap_recette R WHERE R.id=:id_recette";

$pdoStatement = $pdo->prepare($sql);
$pdoStatement->execute(array(':id_recette' => $id_recette));
$recette = $pdoStatement->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel='stylesheet' type='text/css' href='style.css'>
    <title>Yabon ! - Recette <?= $recette['nom']?> </title>
</head>
<body>

    <header>
        <nav>
            <h1>Yabon v0 !</h1>
            <ul>
                <li>
                    <a  href="index.php">Catégories</a>
                </li>
                <li>
                    <a class="menu-active" href="recettes.php">Recettes</a>
                </li>
                <li>
                    <a  href="recettes_tableau.php">Recettes tableau</a>
                </li>
            </ul>
        </nav>
    </header>


    <main>
        <h1><?= $recette['nom'] ?></h1>
<!--                Affichage de la description de la recette et de l'image-->
        <div>
            <img src="image/<?= $recette['image'] ?>"  alt="">
            <p><?= $recette['description'] ?></p>


        </div>
        <div class="">
            <h6>Ingrédients</h6>

            <ul>
                <?php

                $sql = "SELECT * FROM yabontiap_recette_ingredient RI INNER JOIN yabontiap_ingredient I ON RI.id_ingredient=I.id WHERE RI.id_recette=:id_recette";
                $pdoStatement = $pdo->prepare($sql);
                $pdoStatement->execute(array(':id_recette' => $id_recette));
                $ingredients = $pdoStatement->fetchall(PDO::FETCH_ASSOC);

                foreach ($ingredients as $ingredient){
                    echo "<li>". $ingredient['nom'] ." - ". $ingredient['quantite']."</li>" ;
                }
                ?>

            </ul>
        </div>
    </main>

    <footer>
            <p>Ce site est un contre exemple. Il montre ce qu'il ne faut pas faire </p>
            <p><a href="licence.php">Les licences des images</a></p>
    </footer>


</body>
</html>



<?php
