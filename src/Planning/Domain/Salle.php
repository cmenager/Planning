<?php

namespace Planning\Domain;

class Salle 
{
    /**
     * Salle id.
     *
     * @var integer
     */
    private $id;
    
    /**
     * Salle name.
     *
     * @var string
     */
    private $libelle;
    
    
    
    public function getId() {
        return $this->id;
    }

    public function getLibelle() {
        return $this->libelle;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setLibelle($libelle) {
        $this->libelle = $libelle;
    }


}