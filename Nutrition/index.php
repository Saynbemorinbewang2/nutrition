<html>
 <head>
 <meta charset="utf-8">
 <!-- importer le fichier de style -->
 <link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />
 </head>
 <body>
 <header class="header sticky sticky--top js-header">

<div class="grid">

  <nav class="navigation">
      <center><a href="#" class="#">S'identifier</a></center>
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
 
 <form action="php_fonction/authentification.php" method="POST">
 
 <label><b>Email</b></label>
 <input type="email" placeholder="Entrer le nom d'utilisateur" name="username" required>

 <label><b>Mot de passe</b></label>
 <input type="password" placeholder="Entrer le mot de passe" name="password" required>

 <input type="submit" id='submit' value='Se Connecter' >
<HR>
 <CENTER><a id='cree_compte' href="add_user.php">Creer nouveau compte</a></CENTER>
 <?php
 if(isset($_GET['erreur'])){
 $err = $_GET['erreur'];
 if($err==1 || $err==2)
 echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
 }
 ?>
 </form>
 </div>
 </body>
 <footer class="footer">
  <div class="footer__addr">
    <h1 class="footer__logo"></h1>
        
    <h2>Contact</h2>
    
    <address>
      Ngaoundere BP 45. Projet Universit√© M1sled<br>
          
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
      <span>Made with <span class="heart">‚ô•</span> remotely from Anywhere</span>
    </div>
  </div>
</footer>
<script src= "js/query.js"></script>
</html>