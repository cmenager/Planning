<?php

namespace Planning\Domain;

class Heurepassage 
{
    /**
     * heurepassage id.
     *
     * @var integer
     */
    private $id;
    
    /**
     * heurepassage heuredeb.
     *
     * @var string
     */
    private $heuredeb;
    
    /**
     * heurepassage heurefin.
     *
     * @var string
     */
    private $heurefin;
    
    
    public function getId() {
        return $this->id;
    }

    public function getHeuredeb() {
        return $this->heuredeb;
    }

    public function getHeurefin() {
        return $this->heurefin;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setHeuredeb($heuredeb) {
        $this->heuredeb = $heuredeb;
    }

    public function setHeurefin($heurefin) {
        $this->heurefin = $heurefin;
    }


    
}