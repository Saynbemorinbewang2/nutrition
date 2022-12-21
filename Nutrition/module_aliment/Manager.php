<?php
 require_once '../DBConnection.class.php';
 require_once 'Aliment.php';
 require_once 'Utilisateur.php';
 require_once 'Plat.php';
class Manager
{
    private static $_pdo;

    public function __construct()
    {
        
    }

    public static function getUser($email): Utilisateur
    {
        $_pdo = DBConnection::getInstance();
        $result = $_pdo->query("SELECT * FROM `utilisateur` WHERE `email` = '$email'")->fetch(PDO::FETCH_ASSOC);
       
        $date = new DateTime($result['date']);
        $annee = (int)$date->format('Y');

        $user = new Utilisateur($result['id_utilisateur'], $result['nom'], $annee, $result['poids'], explode(', ', $result['pathologie']));

        return $user;
    }

    /**
     * getListAliment: method who return the list of all aliments
     * param : void
     * return : array of object aliment 
     */
    public static function getAliments($id_plat = ''): array
    {
        $_pdo = DBConnection::getInstance();
        if(empty($id_plat)){
            $aliments = $_pdo->query("SELECT * FROM `aliment`")->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
            $id_aliments = $_pdo->query("SELECT `id_aliment` FROM `contenir` WHERE `id_plat`='$id_plat'")->fetchAll(PDO::FETCH_COLUMN);
            $aliment = [];
            foreach($id_aliments as $id){
                $aliments[] = $_pdo->query("SELECT * FROM `aliment` WHERE `id_aliment`")->fetch(PDO::FETCH_COLUMN);
            }
        }

        $list = [];
        foreach($aliments as $aliment){
            $list[] = new Aliment($aliment['nom'], $aliment['description'], $aliment['type'], $aliment['apport_nutritif']);
        }

        return $list;
    }

    public static function getPlats()
    {
        $_pdo = DBConnection::getInstance();
        $plats = $_pdo->query("SELECT * FROM `plat`")->fetchAll(PDO::FETCH_ASSOC);
        $list = [];

        foreach($plats as $plat){
            $id_plat = $plat['id_plat'];
            $id_aliments = $_pdo->query("SELECT `id_aliment` FROM `contenir` WHERE `id_plat` = '$id_plat'")->fetchAll(PDO::FETCH_COLUMN);
            $aliments = [];
            foreach($id_aliments as $id_aliment){
                $aliments[] = $_pdo->query("SELECT `nom` FROM `aliment` WHERE `id_aliment` = '$id_aliment'")->fetch(PDO::FETCH_COLUMN);
            }
            $aliments = implode(', ', $aliments);
            $list[] = new Plat($plat['nom'], $plat['description'], $plat['apport_nutritif'], explode(', ', $plat['type']), $aliments);
        }

        return $list;
    }

    public static function getHistory($user): array
    {
        $_pdo = DBConnection::getInstance();
        $id_user = $user->getId();
        $id_plats = $_pdo->query("SELECT `id_plat` FROM `historique` WHERE `id_utilisateur` = '$id_user'")->fetchAll(PDO::FETCH_COLUMN);
        
        $list = [];
        foreach($id_plats as $id){
            $plat = $_pdo->query("SELECT * FROM `plat` WHERE `id_plat` = '$id'")->fetch(PDO::FETCH_ASSOC);
            $aliments = self::getAliments($id);
            $temp = [];
            foreach($aliments as $aliment){
                $temp[] = $aliment->getNom();
            }

            $list[] = new Plat($plat['nom'], $plat['description'], $plat['apport_nutritif'], explode(', ', $plat['type']), implode(', ', $aliment));
        }
        return $list;
    }

}

?>