<?php
class Aliment
{
    private String $id;
    private String $nom;
    private String $description;
    private String $type;
    private int $apport_nutritif;

    public function __construct(String $nom, String $description, String $type, int $apport_nutritif)
    {
        $this->nom = $nom;
        $this->description = $description;
        $this->type = $type;
        $this->apport_nutritif = $apport_nutritif;
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
     * getNom : methode that return the name's aliment
     * return : String 
     */
    public function getNom() : String
    {
        return $this->nom;
    }
    /**
     * getDescription : methode that return the description of an aliment
     * return : String 
     */
    public function getDescription() : String
    {
        return $this->description;
    }
    /**
     * getType : methode that return the type of an aliment
     * return : String 
     */
    public function getType() : String
    {
        return $this->type;
    }
    /**
     * getApport_nutritif : methode that return the nutrition apport of an aliment
     * return : String 
     */
    public function getApport_nutritif() : int
    {
        return $this->apport_nutritif;
    }


    // Setters

    /**
     * setNom : setter of nom of aliment
     * param: String nom -> the new nom of the aliment
     * return: void
     */
    public function setNom(String $nom)
    {
        $this->nom = $nom;
    }


    /**
     * setDescription : setter of description of aliment
     * param: String description -> the new description of the aliment
     * return: void
     */
    public function setDescription(String $description)
    {
        $this->description = $description;
    }

    /**
     * setType : setter of type of aliment
     * param: String type -> the new type of the aliment
     * return: void
     */
    public function setType(String $type)
    {
        $this->type = $type;
    }

    /**
     * setApport_nutritif : setter of apport_nutritif of aliment
     * param: String apport_nutritif -> the new apport_nutritif of the aliment
     * return: void
     */
    public function setApport_nutritif(int $apport_nutritif)
    {
        $this->apport_nutritif = $apport_nutritif;
    }


    /**
     * printAliment: method use to print aliment's properties
     */
    public function printAliment()
    {
        //echo '<pre>';
        print_r($this);
        //echo '</pre>';
    }

}


?>