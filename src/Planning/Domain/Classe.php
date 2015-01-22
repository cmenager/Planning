<?php

namespace Planning\Domain;

class Classe 
{
    /**
     * classe id.
     *
     * @var integer
     */
    private $id;
    
    /**
     * classe name.
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

    
    public function __toString(){
        return $this->getLibelle();
    }

}