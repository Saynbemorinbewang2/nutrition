<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    <title>Document</title>
</head>
<body>
<?php
  //connexion à la bd
try{
    $con = new PDO('mysql:host=localhost;dbname=nutrition;charset=utf8','root','',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
}
catch (Exception $e){
    die('Erreur : ' . $e->getMessage());
}

//on selectionne les aliments et on les affiches par ordre croissant
$req="SELECT * FROM aliment 
        ORDER BY type ASC";
$res=$con->query($req);
if($res === false){
    die("Erreur");
}

?>
    <h1 align="center"> LISTE DES ALIMENTS </h1>
    <?php
 if(isset($_GET['erreur'])){
 $err = $_GET['erreur'];
 if($err==8)
 echo "<p style='color:blue'>Plat ajouter avec succes</p>";
 }
 ?>
<form action="tselection.php" method="POST">
    <table align="center">
        <thead>
            <tr>
                <th> NOM </th>
                <th> Apport nutritif (en Kcal)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while($row = $res-> fetch(PDO::FETCH_ASSOC)) :
            ?>
            <tr>
                <td>
                <input type="checkbox" name="id[]" value="<?php
                    echo htmlspecialchars($row['id_aliment']);
                    ?> ">
                <?php
                    echo htmlspecialchars($row['nom']);
                    ?>
                    <br>
                </td>
                <td>
                    <?php
                    echo htmlspecialchars($row['apport_nutritif']);
                    ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    entrez le nom du plat<input type="text" name="nom_plat" placeholder="donner un nom a ce plat" required><br><br>
    DESCRIPTION :<input type="text" name="description" placeholder="breve description"><br><br>
        TYPE : <select name="type" required>
            <option value="petit_dejeuner">petit d&eacute;jeuner</option>
            <option value="dejeuner">d&eacute;jeuner</option>
            <option value="diner">d&icirc;ner</option>
        </select><br><br>
        <input type="submit" value="envoyer"> <input type="reset" value="annuler">
</form>
</body>
</html>
