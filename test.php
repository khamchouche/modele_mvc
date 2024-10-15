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
$template = $twig->load('montemplate.html.twig');


// <h2>Variables simple</h2>
$machaine="Hello world!";

// <h2>Tableau</h2>
$tab=['naruto','sakura','gaara','sasuke'];
// <h2>Tableau associatif</h2>

$tab_asso=[
    'prenom'=>'Naruto',
    'nom'=>'Uzumaki'
];
// <h2>Objet</h2>
class Personnage
{
    public $nom;
    private $prenom;
    public $age;
    
    public function __construct($nom,$prenom,$age)
    {
        $this->nom=$nom;
        $this->prenom=$prenom;
        $this->age=$age;
    }
    public function getPrenom()
    {
        return $this->prenom;
    }
    public function setPrenom($prenom)
    {
        $this->prenom=$prenom;
        return $this;
    }
}//si je met pas de constructeur je ne pourai pas creer d'objet avec les attributs en private, 
//pour qu'il s'affiche quand meme on met des getter et setter

// <h3>Objet attribut public</h3>

// <h3>Objet methode</h3>

// <h2> Tableaux imbriqués</h2>
            //Connexion à la base de données en pdo
            $pdo = new PDO('mysql:host=localhost;dbname=yabontiap_bd', 'root', '');

            //Construction de la requête
            $sql = "SELECT * FROM yabontiap_recette R";

            $pdoStatement = $pdo->prepare($sql);
            $pdoStatement->execute();
            $recettes=$pdoStatement->fetchALL(PDO::FETCH_ASSOC);//ON RECUP UN TABLEAU DE TABLEAU ASSOCIATIF

echo $template->render(array(
    "unechaine" => "$machaine",
    'perso_naruto'=>$tab,
    'tab_asso'=>$tab_asso,
    'perso_naruto'=>$perso1,
    'recettes'=>$recettes,
));
$perso1 =new Personnage('Uzumaki','Naruto',17);
// echo $template->render(array(
//     'titre' => "Vive l'objectivité",
//     'groupe' => 'Java',
//     'style' => 'Rap musette',
// ));