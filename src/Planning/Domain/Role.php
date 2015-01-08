<?php

namespace Planning\Domain;

class Role {

    /**
     * id. role
     *
     * @var string
     */
    private $id;

    /**
     * libelle role.
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
