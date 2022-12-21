<?php

class Utilisateur
{
    private int $id;
    private String $email;
    //private String $mpd;
    private String $nom;
    //private String $prenom;
    private int $date_naiss;
    //private int $tel;
    private array $pathologie;
    private int $poids;


    public function __construct(int $id, String $nom, int $date_naiss, int $poids, array $pathologie)
    {

        $this->id = $id;
        $this->nom = $nom;
        $this->date_naiss = $date_naiss;
        $this->poids = $poids;
        $this->pathologie = $pathologie;
    }

    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getPathologie() { return $this->pathologie; }
    public function getDate_naiss() { return $this->date_naiss; }
    public function getAge() { return (2022 - $this->date_naiss); }
    public function getPoids() { return $this->poids; }

}

?>