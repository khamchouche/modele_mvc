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
                <a  href="index.php">Catégories</a>
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
        <h1>Les recettes</h1>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Catégorie</th>

                </tr>
            </thead>
            <tbody>



        <?php
        //Récupération de la catégorie de recette dans le Get
        //ATTENTION Cette méthode de travail n'est pas sécurisée. LA bonne méthode sera abordée ultérieurement

        $categorieId = isset($_GET['categorie_id'])?$_GET['categorie_id']:null;



        //Connexion à la base de données en pdo
        $pdo = new PDO('mysql:host=localhost;dbname=yabontiap_bd', 'root', '');

        //Construction de la requête

        $sql = "SELECT R.id as 'recette_id', R.nom as 'recette_nom', C.nom as 'categorie_nom', R.image  as 'recette_image' FROM yabontiap_recette R INNER JOIN yabontiap_categorie C ON R.id_categorie = C.id";

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute();
        $recettes = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

                foreach ($recettes as $recette) {
                    ?>

                    <!--Les cartes-->
                    <tr>
                        <td><img src='<?= "image/" . $recette['recette_image'] ?>' alt=""></td>
                        <td><a href="recette.php?id_recette=<?=$recette['recette_id']?>"><?= $recette['recette_nom'] ?></a></td>
                        <td><?= $recette['categorie_nom'] ?></td>

                    </tr>



                <?php } ?>
            </tbody>
        </table>
    </main>

    <footer >
        <p>Ce site est un contre exemple. Il montre ce qu'il ne faut pas faire </p>
        <p><a href="licence.php">Les licences des images</a></p>
    </footer>


</body>
</html>



