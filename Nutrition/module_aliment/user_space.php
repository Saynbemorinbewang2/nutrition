<?php
session_start();

?>
<head>
    <link rel="stylesheet" href="style_plat.css">
</head>

<?php

    require_once 'Plat.php';
    require_once 'Utilisateur.php';

    $mail = $_SESSION['mail'];

    $manager = new Manager();
    $user = Manager::getUser($mail);
    $historique = Manager::getHistory($user);
    
    if(isset($_POST['interval'])){

        ob_start();

        switch($_POST['interval']){
            case 'petit_dejeuner':
                $plat_unique = Plat::petitDejeuner($user);
                if(!isset($plat_unique))
                    $plat_unique = [];
                break;
            case 'dejeuner':
                $plat_unique = Plat::dejeuner($user);
                break;
            case 'diner':
                $plat_unique = Plat::diner($user);
                break;
            case 'journee':
                $plat_jour = Plat::platsJournee($user);
                break;
            case 'semaine':
                $plat_semaine = Plat::platsSemaine($user);
                break;
            default:
                break;
        }
        
        $info = ob_get_contents();
        ob_end_clean();

?>

        <div class="recommandation">
            <h1 class="entete">Plats recommandés pour : <?=$_POST['interval']?></h1>
            <div class="info-user">
                Nom utilisateur : <?=$user->getNom()?>
                <?=$info?>
            </div>
            <div class="plats-recommandes">
                <?php
                    if(isset($plat_unique)){ ?>
                        <div class="plat-unique">
                            <?php if(!empty($plat_unique)){ ?>
                                <p class="name"><?=$plat_unique->getNom()?></p>
                                <p class="description"><?=$plat_unique->getAliments()?></p>
                                <p class="apport-nut"><?=$plat_unique->getApport_nutritif()?> Kcal</p></p>
                                <br><br><br>
                                <hr><hr>
                            <?php }else{ ?>
                                <p class="name">Aucun plat trouvé</p>
                                <p class="description">..</p>
                                <p class="apport-nut">0 Kcal</p></p>
                                <br><br><br>
                                <hr><hr>
                            <?php } ?>
                        </div>
                    <?php }elseif(isset($plat_jour)){ 
                                foreach($plat_jour as $key => $plat){ ?>
                                    <div class="plat-jour">
                                        <?php if(!empty($plat)){ ?>
                                            <p><h4 class="name"><?=$key?></h4></p>
                                            <p class="nom-plat"><?=$plat->getNom()?></p>
                                            <p class="description"><?=$plat->getAliments()?></p>
                                            <p class="apport-nut"><?=$plat->getApport_nutritif()?> Kcal</p>
                                            <br><br><br>
                                            <hr><hr>
                                        <?php }else{ ?>
                                            <p><h4 class="name"><?=$key?></h4></p>
                                            <p class="nom-plat">Aucun plat trouvé</p>
                                            <p class="description">..</p>
                                            <p class="apport-nut">0 Kcal</p>
                                            <br><br><br>
                                            <hr><hr>
                                        <?php } ?>
                                        
                                    </div>
                    <?php } }elseif(isset($plat_semaine)){
                                foreach($plat_semaine as $key => $value){ 
                                    if(!empty($value)){ ?>
                                <ul class="plat-semaine">
                                    <?=$key?> : <p class="nom-plat">Petit-dej: <?php if(!empty($value['petit_dejeuner'])) { echo $value['petit_dejeuner']->getNom(); } else { echo 'Aucun plat trouvé'; }?></p>
                                                <p class="nom-plat">Dejeuner: <?php if(!empty($value['dejeuner'])) { echo $value['dejeuner']->getNom(); } else { echo 'Aucun plat trouvé'; }?></p>
                                                <p class="nom-plat">Diner: <?php if(!empty($value['diner'])) { echo $value['diner']->getNom(); } else { echo 'Aucun plat trouvé'; }?></p>
                                </ul>
                    <?php } } }else{ ?>
                        
                        <h3>Nous n'avons pas pu traiter votre demande</h3>
                        
                    <?php }
                ?>
            </div>
            <h1 class="entete">Historique</h1>
            <div class="historique">
                <?php
                    foreach($historique as $plat){
                        echo '<p>'. $plat->getNom(). '</p>';
                    }
                ?>
            </div>
        </div>


<?php
    }else{
        ?>
        <div class="div-form">
            <h3>Formulaire selection d'un interval de temp</h3>
            <form action="" method = "POST">
                <table>
                    <tr>
                        <td><b><p><label>Repas unique:</label></p></b></td>
                        <td>
                            <p><td><label> Petit déjeuner:</label></td><td><input type="radio" name="interval" value="petit_dejeuner" id="one"></td></p>
                            <p><td><label>; Déjeuner:</label></td><td><input type="radio" name="interval" value="dejeuner" id="one"></td></p>
                            <p><td><label>; Diner:</label></td><td><input type="radio" name="interval" value="diner" id="one"></td></p>
                        </td>
                    </tr>
                    <tr>
                        <td><b><p><label>Journée:</p></b></b></td>
                        <td><input type="radio" name="interval" value="journee" id="day"></td>
                    </tr>
                    <tr>
                        <td><b><p><label>Semaine:</p></b></b></td>
                        <td><input type="radio" name="interval" value="semaine" id="week"></td>
                    </tr>
                </table>
                <div class="submit-button right">

                    <button type="submit">Valider</button>
                    <button type="submit"><a href="../module_personne/selection.php">Creer son plat</a></button>
                </div>
            </form>
        </div>
        <?php
    }
?>