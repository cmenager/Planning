<?php

namespace Planning\Domain;

class Enseigne {

    /**
     * Eleve id.
     *
     * @var \planning\Domaine\Eleve
     */
    private $eleve;
    
    /**
     * Langue id.
     *
     * @var \planning\Domaine\Langue
     */
    private $langue;
    
    /**
     * Professeur id.
     *
     * @var \planning\Domaine\Professeur
     */
    private $professeur;

    public function getEleve() {
        return $this->eleve;
    }

    public function getLangue() {
        return $this->langue;
    }

    public function getProfesseur() {
        return $this->professeur;
    }

    public function setEleve(\planning\Domaine\Eleve $eleve) {
        $this->eleve = $eleve;
    }

    public function setLangue(\planning\Domaine\Langue $langue) {
        $this->langue = $langue;
    }

    public function setProfesseur(\planning\Domaine\Professeur $professeur) {
        $this->professeur = $professeur;
    }


}