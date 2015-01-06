<?php

namespace Planning\Domain;

class Eleve 
{
    /**
     * Eleve id.
     *
     * @var integer
     */
    private $id;

    /**
     * nom.
     *
     * @var string
     */
    private $nom;

    /**
     * prenom.
     *
     * @var string
     */
    private $prenom;

    /**
     * tiers temps.
     *
     * @var string
     */
    private $tierstemps;
    
    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getTierstemps() {
        return $this->tierstemps;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setTierstemps($tierstemps) {
        $this->tierstemps = $tierstemps;
    }



}
