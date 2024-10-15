<?php
//init utilisation fichier twig
//ajout de l’autoload de composer
require_once 'vendor/autoload.php';

//ajout de la classe IntlExtension et creation de l’alias IntlExtension
use Twig\Extra\Intl\IntlExtension;
//initialisation twig : chargement du dossier contenant les templates, partie affichage
$loader = new Twig\Loader\FilesystemLoader('templates');

//Paramétrage de l'environnement twig on creer un objet twig et on lui passe' un tableau avec parametre
$twig = new Twig\Environment($loader, [
/*passe en mode debug à enlever en environnement de prod : permet d'utiliser dans un
templates {{dump
(variable)}} pour afficher le contenu d'une variable. Nécessite l'utilisation de
l'extension debug*/
'debug' => true,
// Il est possible de définir d'autre variable d'environnement
//...
]);

//Définition de la timezone pour que les filtres date tiennent compte du fuseau horaire français.
$twig->getExtension(\Twig\Extension\CoreExtension::class)->setTimezone('Europe/Paris');

//Ajouter l'extension debug
$twig->addExtension(new \Twig\Extension\DebugExtension());

//Ajout de l'extension d'internationalisation qui permet d'utiliser les filtres de date dans twig
$twig->addExtension(new IntlExtension());


        
//Connexion à la base de données en pdo
        $pdo = new PDO('mysql:host=localhost;dbname=yabontiap_bd', 'root', '');

        $sql = "SELECT * FROM yabontiap_categorie";
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute();
        $categories = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

//Chargement du template, choisir le templates que je veux utiliser
$template = $twig->load('index.html.twig.twig');
        

echo $template->render(array(

));

            ?>