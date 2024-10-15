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

//Chargement du template, choisir le templates que je veux utiliser
$template = $twig->load('mapage.twig');

//Connexion à la base de données en pdo
$pdo = new PDO('mysql:host=localhost;dbname=yabontiap_bd', 'root', '');
$montableau=array("Naruto","Sasuke","Gaara");
$montableauassociatif=array("prenom"=>"Naruto","nom"=>"Uzumai","element"=>"vent");

            //Construction de la requête
            $sql = "SELECT * FROM yabontiap_recette R";

            $pdoStatement = $pdo->prepare($sql);
            $pdoStatement->execute();
            $recettes=$pdoStatement->fetchALL(PDO::FETCH_ASSOC);//ON RECUP UN TABLEAU DE TABLEAU ASSOCIATIF

            //recuperaion ingredients
            foreach($recettes as $key=>$recette)
            {
             $sql2="SELECT * FROM yabontiap_recette_ingredient RI INNER JOIN yabontiap_ingredient I ON RI.id_ingredient=Iid WHERE RI.id_rcette=:id_recette";           
              //e recup tous les ingredients que je vaismettre dans une clef ingredient  
            $pdoStatement = $pdo->prepare($sq2);
            $pdoStatement->execute(['id_recette'=> $recette['id']]);
            $recettes[$key]['ingredients']=$pdoStatement->fetchALL(PDO::FETCH_ASSOC);//ON RECUP UN TABLEAU DE TABLEAU ASSOCIATIF
            var_dump($recettes);
            //var_dump($recettes[0]['ingredients']);
            
            }


            echo $template->render(array(
                "tableau" => "$montableau",
                'tableauassociatif'=>$montableauassociatif,
                'listerecettes'=>$recettes,
            ));