<?php

namespace Planning\DAO;

use Planning\Domain\Epreuve;

class EpreuveDAO extends DAO {

    /**
     * @var \Planning\DAO\EleveDAO
     */
    private $eleveDAO;

    public function setEleveDAO($eleveDAO) {
        $this->eleveDAO = $eleveDAO;
    }

    /**
     * @var \Planning\DAO\HeurepassageDAO
     */
    private $heurepassageDAO;

    public function setHeurepassageDAO($heurepassageDAO) {
        $this->heurepassageDAO = $heurepassageDAO;
    }

    /**
     * @var \Planning\DAO\Langue
     */
    private $langueDAO;

    public function setLangueDAO($langueDAO) {
        $this->langueDAO = $langueDAO;
    }

    /**
     * @var \Planning\DAO\Professeur
     */
    private $professeurDAO;

    public function setProfesseurDAO($professeurDAO) {
        $this->professeurDAO = $professeurDAO;
    }

    /**
     * @var \Planning\DAO\Professeur
     */
    private $salleDAO;

    public function setSalleDAO($salleDAO) {
        $this->salleDAO = $salleDAO;
    }

    // <editor-fold defaultstate="collapsed" desc="Trouver un epreuve par identifiant : (find($id))"> 
    /**
     * Returns the eleve matching a given id.
     *
     * @param integer $id The eleve id.
     *
     * @return \Planning\Domain\Eleve|throws an exception if no eleve is found.
     */
    public function find($id) {
        $sql = "select * from epreuve where ID_ELEVE=?";

        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No epreuve found for id " . $id);
    }

// </editor-fold>

    
    // <editor-fold defaultstate="collapsed" desc="Trouver tous les epreuves par identifiant : findAll()"> 
    /**
     * Returns the list of all eleve, sorted by nom.
     *
     * @return array The list of all eleves.
     */
    public function findAll() {
        $sql = "select * from epreuve ";
        $result = $this->getDb()->fetchAll($sql);

        // Converts query result to an array of domain objects
        $epreuves = array();
        foreach ($result as $row) {
            $epreuveId = $row['ID_ELEVE'];
            $epreuves[$epreuveId] = $this->buildDomainObject($row);
        }
        return $epreuves;
    }

// </editor-fold>
// 
// // // <editor-fold defaultstate="collapsed" desc="Trouver les eleves par epreuve : findAllByNom()"> 
    /*
     * Returns the list of all drugs for a given family, sorted by trade name.
     *
     * @param integer $familyDd The family id.
     *
     * @return array The list of drugs.
     */
    public function findAllByNom($nomId) {
        $sql = "select * from epreuve ep join eleve el on ep.ID_ELEVE = el.ID_ELEVE where el.NOM_ELEVE=? ";
        $result = $this->getDb()->fetchAll($sql, array($nomId));

        // Convert query result to an array of domain objects
        $epreuves = array();
        foreach ($result as $row) {
            $epreuveId = $row['ID_ELEVE'];
            $eleves[$epreuveId] = $this->buildDomainObject($row);
        }
        return $epreuves;
    }

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Trouver les professeurs par epreuve : findAllByProfesseur()"> 
    /*
     * Returns the list of all drugs for a given family, sorted by trade name.
     *
     * @param integer $familyDd The family id.
     *
     * @return array The list of drugs.
     */
    public function findAllByProfesseur($profId) {
        $sql = "select * from epreuve ep join professeur pr on ep.ID_PROFESSEUR = pr.ID_PROFESSEUR where pr.NOM_PROFESSEUR=? ";
        $result = $this->getDb()->fetchAll($sql, array($profId));

        // Convert query result to an array of domain objects
        $epreuves = array();
        foreach ($result as $row) {
            $epreuveId = $row['ID_PROFESSEUR'];
            $eleves[$epreuveId] = $this->buildDomainObject($row);
        }
        return $epreuves;
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Cree un epreuve : buildDomainObject($row) ">
    /**
     * Creates a Eleve instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \Planning\Domain\Eleve
     */
    protected function buildDomainObject($row) {
        $eleveId = $row['ID_ELEVE'];
        $eleve = $this->eleveDAO->find($eleveId);

        $heurepassageId = $row['ID_HEURE_PASSAGE'];
        $heurepassage = $this->heurepassageDAO->find($heurepassageId);

        $langueId = $row['ID_LANGUE'];
        $langue = $this->langueDAO->find($langueId);

        $professeurId = $row['ID_PROFESSEUR'];
        $professeur = $this->professeurDAO->find($professeurId);

        $salleId = $row['ID_SALLE'];
        $salle = $this->salleDAO->find($salleId);

        $epreuve = new Epreuve();
        $epreuve->setDatepassage($row['DATE_PASSAGE']);

        $epreuve->setEleve($eleve);
        $epreuve->setHeurepassage($heurepassage);
        $epreuve->setLangue($langue);
        $epreuve->setProfesseur($professeur);
        $epreuve->setSalle($salle);
        
        return $epreuve;
    }

// </editor-fold>
}
