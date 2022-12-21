<?php
session_start();
$_SESSION['mail'];
//connection à la BD
require_once '../DBConnection.class.php';
//include (connection.php);
//$connection = connection();
$pdo=DBConnection::getInstance();

//recupération des informations du formulaire
$nom=$_POST['nom'];
$prenom=$_POST['prenom'];
$email=$_POST['email'];
$poids=$_POST['poids'];
$pathologie=$_POST['pathologie'];
$date=$_POST['date'];
$tel=$_POST['tel'];
$mdp=$_POST['mdp'];

//requete d'insertion dans la table utilisateur
$req=("INSERT INTO `utilisateur`(`email`,`mdp`,`nom`,`prenom`,`date`,`tel`,`pathologie`,`poids`) VALUES (?,?,?,?,?,?,?,?)");
$res=$pdo->prepare($req);
$tab=[
$email,
$mdp,
$nom,
$prenom,
$date,
$tel,
$pathologie,
$poids,
];
if($res->execute($tab))
{
    header('Location: ../add_user.php?erreur=5');
}else{
    exit();
};

?>