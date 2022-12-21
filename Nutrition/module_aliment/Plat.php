<?php
include "Manager.php";
include 'functions.php';

class Plat
{
    private String $id;
    private String $nom;
    private String $description;
    private String $list_aliments;
    private int $apport_nutritif;
    private array $type;
    private static int $MAX_RECENT = 2; // les dernier plats recent d'un user
    private static array $CONFIG_DIABETIQUE = [
                                                'interdit' => ['sucre', 'riz', 'pomme de terre'], 
                                                'conseille' => ['eau', 'tomate']
                                            ];
    private static array $CONFIG_HYPERTENDU = [
                                                'interdit' => ['sel'],
                                                'conseille' => []
                                            ];
    private static array $CONFIG_HEPATIQUE = [
                                                'interdit' => ['huile', 'arachide'],
                                                'conseille' => []
                                            ];
                                            

    public function __construct(String $nom, String $description, int $apport_nutritif, array $type, String $list_aliments,)
    {
        $this->nom = $nom;
        $this->list_aliments = $list_aliments;
        $this->apport_nutritif = $apport_nutritif;
        $this->description = $description;
        $this->type = $type;
    }

    // Getters

    /**
     * getId : methode that return the name's id
     * return : String 
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * getNom : methode that return the name's plat
     * return : String 
     */
    public function getNom() : String
    {
        return $this->nom;
    }
    /**
     * getAliments : methode that return the list_aliments of a plat
     * return : String 
     */
    public function getAliments() : String
    {
        return $this->list_aliments;
    }

    public function getDescription() : String
    {
        return $this->description;
    }
    /**
     * getApport_nutritif : methode that return the nutrition apport of a plat
     * return : String 
     */
    public function getApport_nutritif() : int
    {
        return $this->apport_nutritif;
    }
    /**
     * getType : methode that return the type of a plat
     * return : array 
     */
    public function getType() : array
    {
        return $this->type;
    }


    // Setters

    /**
     * setNom : setter of nom of plat
     * param: String nom -> the new nom of the plat
     * return: void
     */
    public function setNom(String $nom)
    {
        $this->nom = $nom;
    }

    /**
     * setList_aliments : setter of list_aliments of plat
     * param: String list_aliments -> the new list_aliments of the plat
     * return: void
     */
    public function setList_aliments(String $list_aliments)
    {
        $this->list_aliments = $list_aliments;
    }

    public function setDescription(String $description)
    {
        $this->description = $description;
    }

    /**
     * setApport_nutritif : setter of apport_nutritif of plat
     * param: String apport_nutritif -> the new apport_nutritif of the plat
     * return: void
     */
    public function setApport_nutritif(int $apport_nutritif)
    {
        $this->apport_nutritif = $apport_nutritif;
    }
    /**
     * setType : setter of type of plat
     * param: array $type -> the new type of the plat
     * return: void
     */
    public function setType(array $type)
    {
        $this->type = $type;
    }


    /**
     * printplat: method use to print plat's properties
     */
    public function printPlat()
    {
        //echo '<pre>';
        print_r($this);
        //echo '</pre>';
    }

    public static function listPlats(): array
    {
        $list_plat = Manager::getPlats();       // get the list of all plat from the database
        
        return $list_plat ? $list_plat : [];
    }

    /**
     * filtrerParPathologie : methode qui filtre les plats en fonction de la pathologie de l'utilisateur
     * param : Array la liste des pathologies
     * return : Array la liste des aliments mangeables
     */
    public static function filtrerParPathologie($list_plat, array $pathologies) : array
    {
        $denied = [];
        $allow = [];
        foreach($pathologies as $pathologie){
            switch($pathologie){
                case 'diabetique':
                    $denied = array_merge($denied, self::$CONFIG_DIABETIQUE['interdit']);
                    $allow = array_merge($allow, self::$CONFIG_DIABETIQUE['conseille']);
                    break;
                case 'hypertendu':
                    $denied = array_merge($denied, self::$CONFIG_HYPERTENDU['interdit']);
                    $allow = array_merge($allow, self::$CONFIG_HYPERTENDU['conseille']);
                    break;
                case 'hepatique' :
                    $denied = array_merge($denied, self::$CONFIG_HEPATIQUE['interdit']);
                    $allow = array_merge($allow, self::$CONFIG_HEPATIQUE['conseille']);
                    default:
                    break;
            }           
        }
        $selected_plat = [];
        $exist = false;
        
        foreach($list_plat as $plat){
            $exist = false;
            // si un element de deniedt est contenu dans la list_aliments du plat, on enleve le plat
            foreach($denied as $e){
                
                if(in_array($e, explode(', ',$plat->getAliments()))){
                    $exist = true;
                }
            }
            if($exist == false)
                $selected_plat[] = $plat;
        }

        $plats_conseille = [];
        $plats_neutre = [];

        foreach($selected_plat as $plat){
            $exist = false;
            foreach($allow as $e){

                if(in_array($e, explode(', ',$plat->getAliments()))){
                    $exist = true;
                }
            }
            if($exist == true)
                $plats_conseille[] = $plat;
            else{
                $plats_neutre[] = $plat;
            }
        }

        $plats_retenus = ['conseille' => $plats_conseille, 'neutre' => $plats_neutre];

        $text1 = $pathologies ? implode(', ', $pathologies) : 'Aucun';
        $text2 = $denied ? implode(', ', $denied) : 'Aucun';
        $text3 = $allow ? implode(', ', $allow) : 'Aucun';
        dump("Pathologie de l'utilisateur : <b> " . $text1. " :</b> Aliments interdits : <b> " . $text2 . " </b> Aliments conseilles : <b> " . $text3 . " </b>");
        return $plats_retenus;
    }

    /**
     * filtrerParPoids : methode qui filtre les plats en fonction du poids de l'utilisateur
     * param : int  le poids de l'utilisateur
     * return : Array la liste des aliments qu'il peut manger
     */
    public static function filtrerParPoids($list_plat, int $poids, int $age) : array
    {
        $selected_plat = [];

        if($age < 5){
            if($poids < 2){
                $temp = 'tres_faible';
            }elseif($poids >=2 && $poids < 5){
                $temp = 'faible';
            }elseif($poids >=5 && $poids < 10){
                $temp = 'normal';
            }else{
                $temp = 'tres_eleve';
            }
        }
        if($age >= 5 && $age < 10){
            if($poids < 5){
                $temp = 'tres_faible';
            }elseif($poids >= 5 && $poids < 10){
                $temp = 'faible';
            }elseif($poids >=10 && $poids < 20){
                $temp = 'normal';
            }elseif($poids >=20 && $poids < 30){
                $temp = 'eleve';
            }else{
                $temp = 'tres_eleve';
            }
        }
        else if($age >= 10 && $age <= 18){
            if($poids < 20){
                $temp = 'tres_faible';
            }elseif($poids >=20 && $poids < 30){
                $temp = 'faible';
            }elseif($poids >= 30 && $poids < 60){
                $temp = 'normal';
            }elseif($poids >=60 && $poids < 70){
                $temp = 'eleve';
            }else{
                $temp = 'tres_eleve';
            }
        }
        else{
            if($poids < 40){
                $temp = 'tres_faible';
            }elseif($poids >=40 && $poids < 60){
                $temp = 'faible';
            }elseif($poids >=60 && $poids < 90){
                $temp = 'normal';
            }elseif($poids >=90 && $poids < 110){
                $temp = 'eleve';
            }else{
                $temp = 'tres_eleve';
            }
        }

        $min = 0;
        $max = 0;
        switch($temp){
            case 'tres_faible':
                $min = 150;
                $max = 300;
                break;
            case 'faible':
                $min = 120;
                $max = 200;
                break;
            case 'normal':
                $min = 50;
                $max = 200;
                break;
            case 'eleve':
                $min = 30;
                $max = 100;
                break;
            case 'tres_eleve':
                $min = 0;
                $max = 70;
                break;
            default:
                break;
        }

        dump("poids ". $temp . ' ('.$poids.' kg) pour ('.$age.' ans) apport nutritif compris entre : ' . $min . ' et ' . $max) ;

        $near = $list_plat ? $list_plat[0] : [];
        foreach($list_plat as $plat){
            $apport = $plat->getApport_nutritif();
            if($apport >= $min && $apport <= $max)
                $selected_plat[] = $plat;
            if($apport > $near->getApport_nutritif() && $near->getApport_nutritif() < $max)
                $near = $plat;
        }
        
        if(empty($selected_plat))
            $selected_plat[] = $near;
        
        return $selected_plat;
    }

    /**
     * filtrerPlat : methode qui prend en parametre un Utilisateur et retourne une liste de plats mangeable par l'user
     * param : $user de type Utilisateur
     * return : Array $plats de type Plat
     */
    public static function filtrerPlat($list_plat , Utilisateur $user): Array
    {
        $pathologie = $user->getPathologie();
        $poids = $user->getPoids();
        $age = $user->getAge();
        //$pers_restrictions = []; // User->getRestrictions() from user -> designate some aliment that user does not eat
        
        $selected_plat = self::filtrerParPoids($list_plat, $poids, $age);
        $selected_plat = self::filtrerParPathologie($selected_plat, $pathologie);
        
        return $selected_plat;
    }



    /**
     * listePlatPetitDejeuner : methode qui determine la liste des plats au petit dejeuner
     * param : une liste de plats $plats
     * return: Array -> la liste des plats pour le petit dej
     */
    public static function listePlatPetitDejeuner(array $plats) : array
    {
        $selected = [];

        foreach($plats as $plat){
            if(in_array('petit_dejeuner', $plat->getType())){
                $selected[] = $plat;
            }
        }

        return $selected;
    }

    /**
     * listePlatDejeuner : methode qui determine la liste des plats au dejeuner
     * param : une liste de plats $plats
     * return: Array -> la liste des plats pour le dej
     */
    public static function listePlatDejeuner(array $plats) : array
    {
        $selected = [];

        foreach($plats as $plat){
            if(in_array('dejeuner', $plat->getType())){
                $selected[] = $plat;
            }
        }
        return $selected;
    }

    /**
     * listePlatDiner : methode qui determine la liste des plats au diner
     * param : une liste de plats $plats
     * return: Array -> la liste des plats pour le diner
     */
    public static function listePlatDiner(array $plats) : array
    {
        $selected = [];

        foreach($plats as $plat){
            if(in_array('diner', $plat->getType())){
                $selected[] = $plat;
            }
        }
        return $selected;
    }



    /**
     * petitDejeuner : methode qui retourne un plat pour le petit dejeuner d'un utilisateur
     * param : $user de type Utilisateur
     * return : $plat de type Plat ou NULL si il n'y a pas de plat correspondant
     */
    public static function petitDejeuner(Utilisateur $user): ?Plat
    {
        $plats = self::listPlats();
        $plats = self::listePlatPetitDejeuner($plats);
        $plats = self::filtrerPlat($plats ,$user);
        
        $plats_conseille = $plats['conseille'];
        $plats_neutre = $plats['neutre'];

        $plats_non_recent = [];

        foreach($plats_conseille as $plat){
            if(self::isRecent($plat, $user))
                continue;
        
            $plats_non_recent[] = $plat;
        }
        if(!empty($plats_non_recent)){
            return $plats_non_recent[random_int(0, array_key_last($plats_non_recent))];
        }

        // dans le cas ou on a pas de plats conseilles
        
        foreach($plats_neutre as $plat){
            if(self::isRecent($plat, $user) || empty($plat))
                continue;
        
            $plats_non_recent[] = $plat;
        }
        if(!empty($plats_non_recent)){
            $k = $plats_non_recent[random_int(0, array_key_last($plats_non_recent))];
            if(!empty($k))
                return $k;
        }
        
        $grouped = array_merge($plats_conseille, $plats_neutre);
        if(!empty($plats_conseille)){
            $k = $plats_conseille[random_int(0, array_key_last($plats_conseille))];
            if(!empty($k))
                return $k;
        }
        
        if(!empty($plats_neutre)){
            $k = $plats_neutre[random_int(0, array_key_last($plats_neutre))];
            if(!empty($k))
                return $k;
        }
        return null;
    }

    /**
     * dejeuner : methode qui retourne un plat pour le dejeuner d'un utilisateur
     * param : $user de type Utilisateur
     * return : $plat de type Plat ou NULL si il n'y a pas de plat correspondant
     */
    public static function dejeuner(Utilisateur $user, array $selected = []): ?Plat
    {
        $plats = self::listPlats();
        $plats = self::listePlatdejeuner($plats);
        $plats = self::filtrerPlat($plats ,$user);
    
        $plats_conseille = $plats['conseille'];
        $plats_neutre = $plats['neutre'];

        $plats_non_recent = [];

        foreach($plats_conseille as $plat){
            if(self::isRecent($plat, $user) || in_array($plat, $selected))
                continue;
        
            $plats_non_recent[] = $plat;
        }
        if(!empty($plats_non_recent)){
            return $plats_non_recent[random_int(0, array_key_last($plats_non_recent))];
        }

        // dans le cas ou on a pas de plats conseilles
        foreach($plats_neutre as $plat){
            if(self::isRecent($plat, $user) || in_array($plat, $selected))
                continue;
        
            $plats_non_recent[] = $plat;
        }
        if(!empty($plats_non_recent)){
            $k = $plats_non_recent[random_int(0, array_key_last($plats_non_recent))];
            if(!empty($k))
                return $k;
        }
        
        $grouped = array_merge($plats_conseille, $plats_neutre);
        if(!empty($plats_conseille)){
            $k = $plats_conseille[random_int(0, array_key_last($plats_conseille))];
            if(!empty($k))
                return $k;
        }
        
        if(!empty($plats_neutre)){
            $k = $plats_neutre[random_int(0, array_key_last($plats_neutre))];
            if(!empty($k))
                return $k;
        }
        return null;
    }

    /**
     * diner : methode qui retourne un plat pour le diner d'un utilisateur
     * param : $user de type Utilisateur
     * return : $plat de type Plat ou NULL si il n'y a pas de plat correspondant
     */
    public static function diner(Utilisateur $user, array $selected = []): ?Plat
    {
        $plats = self::listPlats();
        $plats = self::listePlatDiner($plats);
        $plats = self::filtrerPlat($plats ,$user);

        $plats_conseille = $plats['conseille'];
        $plats_neutre = $plats['neutre'];

        $plats_non_recent = [];

        foreach($plats_conseille as $plat){
            if(self::isRecent($plat, $user) || in_array($plat, $selected))
                continue;
        
            $plats_non_recent[] = $plat;
        }
        if(!empty($plats_non_recent)){
            return $plats_non_recent[random_int(0, array_key_last($plats_non_recent))];
        }

        // dans le cas ou on a pas de plats conseilles
        foreach($plats_neutre as $plat){
            if(self::isRecent($plat, $user) || in_array($plat, $selected))
                continue;
        
            $plats_non_recent[] = $plat;
        }
        if(!empty($plats_non_recent)){
            $k = $plats_non_recent[random_int(0, array_key_last($plats_non_recent))];
            if(!empty($k))
                return $k;
        }
        
        $grouped = array_merge($plats_conseille, $plats_neutre);
        if(!empty($plats_conseille)){
            $k = $plats_conseille[random_int(0, array_key_last($plats_conseille))];
            if(!empty($k))
                return $k;
        }
        
        if(!empty($plats_neutre)){
            $k = $plats_neutre[random_int(0, array_key_last($plats_neutre))];
            if(!empty($k))
                return $k;
        }
        return null;
    }


    /**
     * platsJournee : methode qui propose un plat pour le petit dej, un pour le dej, un pour le diner
     * param : Utilisateur $user : l'utilisateur
     * return : Array : la liste des 3 plats
     */
    public static function platsJournee(Utilisateur $user): array
    {
        $selected = [];
        $plats = [];
        $plats['petit_dejeuner'] = self::petitDejeuner($user);
        $selected[] = $plats['petit_dejeuner'];
        $plats['dejeuner'] = self::dejeuner($user, $selected);
        $selected[] = $plats['dejeuner'];
        $plats['diner'] = self::diner($user, $selected);

        return $plats;
    }

    /**
     * platsSemaine : methode qui propose sur une semaine un plat pour le petit dej, un pour le dej, un pour le diner
     * param : Utilisateur $user : l'utilisateur
     * return : Array : la liste des 3 plats par jours sur une semaine
     */
    public static function platsSemaine(Utilisateur $user): array
    {
        $plats = [];

        for($i = 1; $i <= 7; $i++){
            $plats['jour '. $i] = self::platsJournee($user);
        }

        return $plats;
    }



    /**
     * isRecent : method qui voit si un plat est recent pour un utilisateur passe en parametre
     * param : un plat de type Plat et un utilisateur de type User
     * return : un booleen
     */
    public static function isRecent($plat, Utilisateur $user) : bool
    {
        // $historique = Manager::getHistory($user); // retourne un Array de la liste des plat recents de l'user
        // $historique = array_reverse($historique);

        // $i = 1;
        // foreach($historique as $h){
        //     if($i > self::$MAX_RECENT)
        //         break;
        //     if($plat == $h)
        //         return true;
        //     $i++;
        // }

        return false;
    }
}


?>