<?php

namespace Planning\Domain;

class Langue 
{
    /**
     * Eleve id.
     *
     * @var integer
     */
    private $id;
    
    /**
     * type id.
     *
     * @var \Planning\Domaine\Type
     */
    private $type;

    /**
     * nom.
     *
     * @var string
     */
    private $libelle;
    
    
    public function getId() {
        return $this->id;
    }

    public function getType() {
        return $this->type;
    }

    public function getLibelle() {
        return $this->libelle;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setLibelle($libelle) {
        $this->libelle = $libelle;
    }


}