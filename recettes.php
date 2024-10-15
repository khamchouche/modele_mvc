<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel='stylesheet' type='text/css' href='style.css'>
        <title>Yabon ! - Les catégories de recettes</title>
    </head>
    <body>

        <header>
            <nav>
                <h1><a href="index.php">Yabon v0!</a></h1>
                <ul>
                    <li>
                        <a href="index.php">Catégories</a>
                    </li>
                    <li>
                        <a class="menu-active" href="recettes.php">Recettes</a>
                    </li>
                    <li>
                        <a href="recettes_tableau.php">Recettes tableau</a>
                    </li>
                </ul>
            </nav>
        </header>


        <main>
            <h1>Yabon !</h1>
            <?php
            //Récupération de la catégorie de recette dans le Get
            //ATTENTION Cette méthode de travail n'est pas sécurisée. LA bonne méthode sera abordée ultérieurement

            $idCategorie = isset($_GET['id_categorie']) ? $_GET['id_categorie'] : null;


            //Connexion à la base de données en pdo
            $pdo = new PDO('mysql:host=localhost;dbname=yabontiap_bd', 'root', '');

            //Construction de la requête
            $sql = "SELECT * FROM yabontiap_recette R";
            if (isset($idCategorie)) {
                $sql .= " WHERE R.id_categorie=:id_categorie";
            }


            $pdoStatement = $pdo->prepare($sql);

            if (isset($idCategorie)) {
                $pdoStatement->execute(array(':id_categorie' => $idCategorie));
            }else{
                $pdoStatement->execute();
            }

            $recettes = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <div id="zone_cartes">
                <?php
                foreach ($recettes as $recette) {
                    ?>

                    <!--Les cartes-->
                    <div class="cartes">
                        <a href="recette.php?id_recette=<?= $recette['id'] ?>">


                            <img src='<?= "image/" . $recette['image'] ?>' width="100" height="auto" alt="">

                            <div>
                                <h5><?= $recette['nom'] ?></h5>
                            </div>

                        </a>

                    </div>


                <?php } ?>
            </div>
        </main>

        <footer>
            <p>Ce site est un contre exemple. Il montre ce qu'il ne faut pas faire </p>
            <p><a href="licence.php">Les licences des images</a></p>
        </footer>


    </body>
</html>



