<?php
//connection à la BD
//include (connection.php);
//$connection = connection();
try{
    $con = new PDO('mysql:host=localhost;dbname=nutrition;charset=utf8',
    'root','',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
}
catch (Exception $e){
    die('Erreur : ' . $e->getMessage());
}

//recupération des informations du formulaire
$id=$_POST['id'];
$nom=$_POST['nom_plat'];
$description=$_POST['description'];
$type=$_POST['type'];
$apport=0;

//calcul de l'apport nutritif
if (isset($id)){
    foreach($id as $valeur){
    $req1="SELECT apport_nutritif from aliment
    WHERE  id_aliment = '$valeur' ";
    $res1=$con->query($req1)->fetch(PDO::FETCH_COLUMN);
    $apport+=$res1;
    }
    
}

//requete d'insertion dans la table plat
$req=("INSERT INTO `plat`(`nom`,`description`,`apport_nutritif`,`type`) VALUES (?,?,?,?)");
$res=$con->prepare($req);
$tab3=[
$nom,
$description,
$apport,
$type,
];
$res->execute($tab3);

//requete d'insertion dans la table historique
$req2="SELECT id_plat from plat
    ORDER BY id_plat DESC LIMIT 1; ";
    $res2=$con->query($req2)->fetch(PDO::FETCH_COLUMN);
    $id2=$res2;
$id_utilisateur=1;

//$datec= date("Y/m/d");
//$req5=("INSERT INTO `plat`(`date`,`id_plat`,`id_utilisateur`) VALUES (?,?,?)");
//$res5=$con->prepare($req5);
//$tab=[
//$datec,
//$id2,
//$id_utilisateur,
//];
//$res5->execute($tab);

//requete d'insertion dans la table contenir
    foreach($id as $valeur){
        $req3="SELECT id_aliment from aliment
        WHERE  id_aliment = '$valeur' ";
        $res3=$con->query($req3)->fetch(PDO::FETCH_COLUMN); 
        $val=$res3;
$req4=("INSERT INTO `contenir`(`id_aliment`,`id_plat`) VALUES (?,?)");
$res4=$con->prepare($req4);
$tab=[
$val,
$id2,
];
$res4->execute($tab);}
?>
<script type="text/javascript">
    alert(votre plat a bien été enregistré);
    </script>
<?php    
header("location: selection.php?erreur=2'");
?>