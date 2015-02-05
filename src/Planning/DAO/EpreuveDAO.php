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

    // <editor-fold defaultstate="collapsed" desc="find($id)"> 
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
    // <editor-fold defaultstate="collapsed" desc="findAll()"> 
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
            $epreuveId = $row['DATE_PASSAGE']; //comment afficher tout 
            $epreuves[$epreuveId] = $this->buildDomainObject($row);
        }
        return $epreuves;
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="findAllByIdEleve()"> 
    /*
     * Returns the list of all drugs for a given family, sorted by trade name.
     *
     * @param integer $familyDd The family id.
     *
     * @return array The list of drugs.
     */
    public function findAllByIdEleve($eleveId) {
        $sql = "select * from epreuve ep join eleve el on ep.ID_ELEVE = el.ID_ELEVE where el.ID_ELEVE=? ";
        $result = $this->getDb()->fetchAll($sql, array($eleveId));

        // Convert query result to an array of domain objects
        $epreuves = array();
        foreach ($result as $row) {
            $epreuveId = $row['ID_ELEVE'];
            $epreuves[$epreuveId] = $this->buildDomainObject($row);
        }
        return $epreuves;
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="findAllByIdProfesseur()"> 
    /*
     * Returns the list of all drugs for a given family, sorted by trade name.
     *
     * @param integer $familyDd The family id.
     *
     * @return array The list of drugs.
     */
    public function findAllByIdProfesseur($professeurId) {
        $sql = "select * from epreuve ep join professeur pr on ep.ID_PROFESSEUR = pr.ID_PROFESSEUR where pr.ID_PROFESSEUR=? ";
        $result = $this->getDb()->fetchAll($sql, array($professeurId));

        // Convert query result to an array of domain objects
        $epreuves = array();
        foreach ($result as $row) {
            $profId = $row['ID_PROFESSEUR'];
            $epreuves[$profId] = $this->buildDomainObject($row);
        }
        return $epreuves;
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="findAllByClasseEpreuve()"> 
    /*
     * Returns the list of all eleves for a given nom, sorted by trade name.
     *
     * @param integer $nomDd The nom id.
     *
     * @return array The list of eleves.
     */
    public function findAllByClasseEpreuve($classeId) {
        $sql = "select * from epreuve join eleve "
                . "on epreuve.ID_ELEVE = eleve.ID_ELEVE join classe "
                . "on eleve.ID_CLASSE = classe.ID_CLASSE"
                . "where ID_CLASSE=?";

        $result = $this->getDb()->fetchAll($sql, array($classeId));

        // Convert query result to an array of domain objects
        $epreuves = array();
        foreach ($result as $row) {
            $classId = $row['ID_CLASSE'];
            $epreuves[$classId] = $this->buildDomainObject($row);
        }
        return $epreuves;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="findAllBySalle()"> 
    /*
     * Returns the list of all eleves for a given nom, sorted by trade name.
     *
     * @param integer $nomDd The nom id.
     *
     * @return array The list of eleves.
     */
    public function findAllBySalle($salleId) {
        $sql = "select * from epreuve ep join salle sl "
                . "on ep.ID_SALLE = sl.ID_SALLE"
                . "where sl.ID_SALLE=?";

        $result = $this->getDb()->fetchAll($sql, array($salleId));

        // Convert query result to an array of domain objects
        $salles = array();
        foreach ($result as $row) {
            $sallId = $row['ID_SALLE'];
            $salles[$sallId] = $this->buildDomainObject($row);
        }
        return $salles;
    }

    // </editor-fold>   
    // <editor-fold defaultstate="collapsed" desc="findAllByDate()"> 
    /*
     * Returns the list of all eleves for a given nom, sorted by trade name.
     *
     * @param integer $nomDd The nom id.
     *
     * @return array The list of eleves.
     */
    public function findAllByDate($date) {
        $sql = "select * from epreuve where DATE_PASSAGE=?";

        $result = $this->getDb()->fetchAll($sql, array($date));

        // Convert query result to an array of domain objects
        $dates = array();
        foreach ($result as $row) {
            $date = $row['DATE_PASSAGE'];
            $dates[$date] = $this->buildDomainObject($row);
        }
        return $dates;
    }

    public function findByDateHeurePassage($datePassage, $idHeurePassage) {
        $sql = "select * from epreuve where DATE_PASSAGE=? and ID_HEURE_PASSAGE=?";
        $row = $this->getDb()->fetchAssoc($sql, array($datePassage, $idHeurePassage));
        $epreuve = $this->buildDomainObject($row);
        return $epreuve;
    }

    public function findByEleveDateHeurePassage($datePassage, $idHeurePassage, $idEleve) {
        $sql = "select * from epreuve where DATE_PASSAGE=? and ID_HEURE_PASSAGE=? and ID_ELEVE=?";
        $row = $this->getDb()->fetchAssoc($sql, array($datePassage, $idHeurePassage, $idEleve));
        $epreuve = $this->buildDomainObject($row);
        return $epreuve;
    }

// </editor-fold>   
    // <editor-fold defaultstate="collapsed" desc="findPlanningByDate()"> 
    public function findPlanningByDate($date) {
        $sql = "SELECT e.* , h.ID_HEURE_PASSAGE, ? as DATE_PASSAGE "
                . "FROM heurepassage h LEFT JOIN epreuve e "
                . "ON e.id_heure_passage = h.id_heure_passage "
                . "AND e.DATE_PASSAGE=? ";

        $result = $this->getDb()->fetchAll($sql, array($date, $date));

        // Convert query result to an array of domain objects
        $dates = array();
        foreach ($result as $row) {
            $date = $row['ID_HEURE_PASSAGE'];
            $dates[$date] = $this->buildDomainObject($row);
        }
        return $dates;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="findAllByHeure()"> 
    /*
     * Returns the list of all eleves for a given nom, sorted by trade name.
     *
     * @param integer $nomDd The nom id.
     *
     * @return array The list of eleves.
     */
    public function findAllByHeure($heureId) {
        $sql = "select * from epreuve ep join heurepassage hp "
                . "on ep.ID_HEURE_PASSAGE = hp.ID_HEURE_PASSAGE"
                . "where hp.ID_HEURE_PASSAGE=?";

        $result = $this->getDb()->fetchAll($sql, array($heureId));

        // Convert query result to an array of domain objects
        $heures = array();
        foreach ($result as $row) {
            $heurId = $row['ID_HEURE_PASSAGE'];
            $heures[$heurId] = $this->buildDomainObject($row);
        }
        return $heures;
    }

    // </editor-fold>  
    // <editor-fold defaultstate="collapsed" desc="buildDomainObject($row) ">
    /**
     * Creates a Eleve instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \Planning\Domain\Eleve
     */
    protected function buildDomainObject($row) {
        $eleve = null;
        $heurepassage = null;
        $langue = null;
        $professeur = null;
        $salle = null;
        $eleveId = $row['ID_ELEVE'];
        if ($eleveId != NULL)
            $eleve = $this->eleveDAO->find($eleveId);
        else {
            $eleve = new \Planning\Domain\Eleve();
        }

        $heurepassageId = $row['ID_HEURE_PASSAGE'];
        if ($heurepassageId != NULL)
            $heurepassage = $this->heurepassageDAO->find($heurepassageId);
        else {
            $heurepassage = new \Planning\Domain\Heurepassage();
        }

        $langueId = $row['ID_LANGUE'];
        if ($langueId != NULL)
            $langue = $this->langueDAO->find($langueId);
        else {
            $langue = new \Planning\Domain\Langue();
        }

        $professeurId = $row['ID_PROFESSEUR'];
        if ($professeurId != NULL)
            $professeur = $this->professeurDAO->find($professeurId);
        else {
            $professeur = new \Planning\Domain\Professeur();
        }
        $salleId = $row['ID_SALLE'];
        if ($salleId != NULL)
            $salle = $this->salleDAO->find($salleId);
        else {
            $salle = new \Planning\Domain\Salle();
        }

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
    //  // <editor-fold defaultstate="collapsed" desc="insert($epreuve)">
    public function insert(Epreuve $epreuve) {
        $epreuveData = array(
            'ID_ELEVE' => $epreuve->getEleve()->getId(),
            'ID_PROFESSEUR' => $epreuve->getProfesseur()->getId(),
            'DATE_PASSAGE' => $epreuve->getDatepassage(),
            'ID_HEURE_PASSAGE' => $epreuve->getHeurepassage()->getId(),
            'ID_LANGUE' => $epreuve->getLangue()->getId(),
            'ID_SALLE' => $epreuve->getSalle()->getId()
        );

        if ($epreuve->getEleve()->getId()) {
            // The epreuve has never been saved : insert it
            $this->getDb()->insert('epreuve', $epreuveData);
        }
    }

// </editor-fold>
    //  // <editor-fold defaultstate="collapsed" desc="update($epreuve)">
    public function update(Epreuve $epreuve) {
        $epreuveData = array(
            'ID_ELEVE' => $epreuve->getEleve()->getId(),
            'ID_PROFESSEUR' => $epreuve->getProfesseur()->getId(),
            'DATE_PASSAGE' => $epreuve->getDatepassage(),
            'ID_HEURE_PASSAGE' => $epreuve->getHeurepassage()->getId(),
            'ID_LANGUE' => $epreuve->getLangue()->getId(),
            'ID_SALLE' => $epreuve->getSalle()->getId()
        );

        if ($epreuve->getEleve()->getId()) {
            // The visit report has already been saved : update it
            $elevId = $epreuve->getEleve()->getId();
            $datePassage = $epreuve->getDatepassage();
            $heurePassageId = $epreuve->getHeurepassage()->getId();
            $this->getDb()->update('epreuve', $epreuveData, array('ID_ELEVE' => $elevId, 'DATE_PASSAGE' => $datePassage, 'ID_HEURE_PASSAGE' => $heurePassageId));
        }
    }

// </editor-fold>
    //<editor-fold defaultstate="collapsed" desc="delete($id)">
    /**
     * Removes a eleve from the database.
     *
     * @param \Planning\Domain\Eleve $eleve The eleve to remove
     */
    public function delete($datePassage, $heurePassageId, $eleveId) {
        $this->getDb()->delete('epreuve', array('ID_ELEVE' => $eleveId, 'DATE_PASSAGE' => $datePassage, 'ID_HEURE_PASSAGE' => $heurePassageId));
    }

// </editor-fold>
}
