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
      <center><a>Nouveau Compte</a></center>
      <?php
 if(isset($_GET['erreur'])){
 $err = $_GET['erreur'];
 if($err==5 || $err==6)
 echo "<p style='color:blue'>votre compte a ete cree avec succes <span class='heart'>✔</span>  <a href='index.php'>cliquer ici pour le formulaire de connection</a></p>";
 }
 ?>
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
 
 <form action="php_fonction/function_add_user.php" method="POST">
 
 <label><b>Nom</b></label><br>
 <input type="text" name="nom" placeholder="nom" required><br>

 <label><b>Prenom</b></label><br>
 <input type="text" name="prenom" placeholder="nom" required><br>

 <label><b>Poids</b></label><br>
 <input id="poids" type="number" name="poids" placeholder="poids"><br>

 <label><b> PATHOLOGIE</b></label><br>
 <select name="pathologie" required><br>
            <option value="aucune">aucune</option>
            <option value="asthme">asthme</option>
            <option value="anemie">an&eacutemie</option>
            <option value="appendicite">appendicite</option>
            <option value="avc">avc</option>
            <option value="diabete">diab&egravete</option>
            <option value="goutte">goutte</option>
            <option value="hypertension">hypertension</option>
            <option value="autres">autres...</option>
        </select><br>
 <label><b>DATE DE NAISSANCE</b></label><br>
 <input type="date" name="date" placeholder="date de naissance" required><br>

 <label><b>Telephone</b></label><br>
 <input id="tel" type="number" name="tel" placeholder="telephone" required><br>

 <label><b>E MAIL:</b></label><br>
 <input type="email" name="email" placeholder="adresse mail" required><br>

 <label><b>Mot de passe</b></label><br>
 <input id="mdp" type="password" name="mdp" placeholder="mot de passe" required><br>

 <label><b>CONFIRMER MOT DE PASSE</b></label><br>
 <input id="cmdp" type="password" name="cmdp" placeholder="mot de passe" required><br>

 <input type="submit" id='submit' value='Valider' >
<HR>

 </form>
 </div>
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