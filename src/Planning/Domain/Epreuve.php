<?php

namespace Planning\Domain;

class Epreuve {

    /**
     * Eleve id.
     *
     * @var \planning\Domaine\Eleve
     */
    private $eleve;

    /**
     * Epreuve date passage.
     *
     * @var date
     */
    private $datepassage;

    /**
     * Heurepasse id.
     *
     * @var \planning\Domaine\Heurepassage
     */
    private $heurepassage;

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


 /**
     * Salle id.
     *
     * @var \planning\Domaine\Salle
     */
    private $salle;
    
    
    
    
    public function getEleve() {
        return $this->eleve;
    }

    public function getDatepassage() {
        return $this->datepassage;
    }

    public function getHeurepassage() {
        return $this->heurepassage;
    }

    public function getLangue() {
        return $this->langue;
    }

    public function getProfesseur() {
        return $this->professeur;
    }

    public function getSalle() {
        return $this->salle;
    }

    public function setEleve(\planning\Domaine\Eleve $eleve) {
        $this->eleve = $eleve;
    }

    public function setDatepassage(date $datepassage) {
        $this->datepassage = $datepassage;
    }

    public function setHeurepassage(\planning\Domaine\Heurepassage $heurepassage) {
        $this->heurepassage = $heurepassage;
    }

    public function setLangue(\planning\Domaine\Langue $langue) {
        $this->langue = $langue;
    }

    public function setProfesseur(\planning\Domaine\Professeur $professeur) {
        $this->professeur = $professeur;
    }

    public function setSalle(\planning\Domaine\Salle $salle) {
        $this->salle = $salle;
    }


}