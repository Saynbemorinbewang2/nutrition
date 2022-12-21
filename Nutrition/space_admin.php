<?php
session_start();
require_once 'DBConnection.class.php';
?>
<html>
 <head>
 <meta charset="utf-8">
 <!-- importer le fichier de style -->
 <link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />
 </head>
 <body>
 <header class="header sticky sticky--top js-header">
<?php
if(!empty($_SESSION['mail']))
{
$pdo=DBConnection::getInstance();
$mon_mail = $_SESSION['mail'];
$requete = "SELECT * FROM administrateur where email = '".$mon_mail."' ";
$exec_requete = $pdo->query($requete);
$row =  $exec_requete ->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="grid">

  <nav class="navigation">
      <h1><a>Administrator Area :Session <?php print_r ($row[0]['nom']); ?><g style='color:green'> Start</g></h1> 
    <!--  <li class="navigation__item"><a href="#" class="navigation__link">About Us</a></li>
      <li class="navigation__item"><a href="#" class="navigation__link">Work</a></li>
      <li class="navigation__item"><a href="#" class="navigation__link">Clients</a></li>
      <li class="navigation__item"><a href="#" class="navigation__link">Contact</a></li>-->

</div>

</header>
<!--<div class="img1">
<img src="image/koki.png" >
</div>-->
 <div id="container">
 <!-- zone de connexion -->
 
 <form method="POST">
 
 <CENTER><a id='menu' href="add_aliment.php">Ajouter un aliment</a></CENTER>

<HR>

 <CENTER><a id='menu' href="#">Modifier un aliment</a></CENTER>
 
<HR>

 <CENTER><a id='menu' href="#">Supprimer un aliment</a></CENTER>

<HR>
 <CENTER><a id='menu' href="#">Deconnection</a></CENTER>
 <?php
 if(isset($_GET['erreur'])){
 $err = $_GET['erreur'];
 if($err==1 || $err==2)
 echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
 }
 ?>
 </form>
 </div>
 <?php
}else{
 header('Location: login.php?erreur=1');
}
 ?>
 </body>
 <footer class="footer">
  <div class="footer__addr">
    <h1 class="footer__logo"></h1>
        
    <h2>Contact</h2>
    
    <address>
      Ngaoundere BP 45. Projet Université M1sled<br>
          
      <a class="footer__btn" href="mailto:delicesdumboa@gmail.com">Email Us</a>
    </address>
  </div>
  
  <ul class="footer__nav">
    <li class="nav__item">
      <h2 class="nav__title">Media</h2>

      <ul class="nav__ul">
        <li>
          <a href="#">Twitter</a>
        </li>

        <li>
          <a href="#">Intagram</a>
        </li>
            
        <li>
          <a href="#">Facebook</a>
        </li>
      </ul>
    </li>
    
    <li class="nav__item nav__item--extra">
      <h2 class="nav__title">Produits</h2>
      
      <ul class="nav__ul nav__ul--extra">
        <li>
          <a href="#">Legume du Pays</a>
        </li>
        
        <li>
          <a href="#">Fruit</a>
        </li>
        
        <li>
          <a href="#">Tubercule</a>
        </li>
        
        <li>
          <a href="#">Fourre</a>
        </li>
        
        <li>
          <a href="#">Cereale</a>
        </li>
        
        <li>
          <a href="#"></a>
        </li>
      </ul>
    </li>
    
    <li class="nav__item">
      <h2 class="nav__title">Legal</h2>
      
      <ul class="nav__ul">
        <li>
          <a href="#">Projet Universitaire</a>
        </li>
        
        <li>
          <a href="#">Team les jongleur</a>
        </li>
        
        <li>
          <a href="#">@lekwatte</a>
        </li>
      </ul>
    </li>
  </ul>
  
  <div class="legal">
    <p>&copy; 2022 Something. All rights reserved.</p>
    
    <div class="legal__links">
      <span>Made with <span class="heart">♥</span> remotely from Anywhere</span>
    </div>
  </div>
</footer>
<script src= "js/query.js"></script>
</html>