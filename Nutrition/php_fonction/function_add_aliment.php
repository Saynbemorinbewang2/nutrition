<?php
//connection à la BD
require_once '../DBConnection.class.php';
//include (connection.php);
//$connection = connection();
$pdo=DBConnection::getInstance();

//recupération des informations du formulaire
$nom=$_POST['nom'];
$description=$_POST['description'];
$type=$_POST['type'];
$apport_nutritif=$_POST['apport_nutritif'];


//requete d'insertion dans la table utilisateur
$req=("INSERT INTO `aliment`(`nom`, `description`, `type`, `apport_nutritif`) VALUES (?,?,?,?)");
$res=$pdo->prepare($req);
$tab=[
$nom,
$description,
$type,
$apport_nutritif,

];
if($res->execute($tab))
{
    header('Location: ../add_aliment.php?erreur=4');
}else{
    exit();
};

?>