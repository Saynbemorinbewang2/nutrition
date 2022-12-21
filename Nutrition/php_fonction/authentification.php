<?php
require_once '../DBConnection.class.php';
session_start();
if(isset($_POST['username']) && isset($_POST['password']))
{
$pdo=DBConnection::getInstance();
 // connexion à la base de données
 
        /* $DSN = "mysql:host=localhost;dbname=nutrition";
         $USERNAME = 'root';
         $PASSWD = '';
         
         $options = [
             PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
             PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
         ];
         try{
             $pdo = new PDO($DSN, $USERNAME, $PASSWD, $options);
            }catch(PDOException $pe)
                {
                echo "ERREUR DANS LORS DE LA CREATION DE LA DB";
                echo $pe->getMessage();
                exit;
                }**/
             #
 

 // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
 // pour éliminer toute attaque de type injection SQL et XSS
 $username = $_POST['username']; 
 $password = $_POST['password'];
 
    if($username !== "" && $password !== "")
    {
        $requete = "SELECT * FROM utilisateur where email = '".$username."' and mdp = '".$password."' ";
        $exec_requete = $pdo->query($requete);
        $row =  $exec_requete ->fetchAll(PDO::FETCH_ASSOC);
      
            if(!empty($row)) // nom d'utilisateur et mot de passe correctes
            {
            echo "User";
            $_SESSION['mail'] = $username;
            header('Location: ../module_aliment/user_space.php');//page d'acceuil utilisateur

             exit();
            }
            else
            {
                $requete = "SELECT * FROM administrateur where email = '".$username."' and mdp = '".$password."' ";
                $exec_requete = $pdo->query($requete);
                $row =  $exec_requete ->fetchAll(PDO::FETCH_ASSOC);
           
                if(!empty($row))
                {
                    $_SESSION['mail'] = $username;
                    header('Location: ../space_admin.php'); //page d'acceuil administrateur
                }else{
                    
                    header('Location: ../index.php?erreur=1'); // utilisateur ou mot de passe incorrect
                }
            }
    }
    else
    {
    echo "2";
    #header('Location: ../index.php?erreur=2'); // utilisateur ou mot de passe vide
    }
    }

else
{
    echo "3";
 //header('Location: ../index.php');
}


//mysqli_close($db); // fermer la connexion
?>