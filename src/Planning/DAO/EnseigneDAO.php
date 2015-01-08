<?php

namespace Planning\DAO;

use Planning\Domain\Enseigne;

class EnseigneDAO extends DAO {

    /**
     * @var \Planning\DAO\EleveDAO
     */
    private $eleveDAO;

    public function setEleveDAO($eleveDAO) {
        $this->eleveDAO = $eleveDAO;
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

    // <editor-fold defaultstate="collapsed" desc="Trouver un enseigne par identifiant : (find($id))"> 
    /**
     * Returns the eleve matching a given id.
     *
     * @param integer $id The eleve id.
     *
     * @return \Planning\Domain\Eleve|throws an exception if no eleve is found.
     */
    public function find($id) {
        $sql = "select * from enseigne where ID_ELEVE=? AND ID_PROFESSEUR=? AND ID_LANGUE=?";

        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No enseigne found for id " . $id);
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Trouver tous les epreuves par identifiant : findAll()"> 
    /**
     * Returns the list of all eleve, sorted by nom.
     *
     * @return array The list of all eleves.
     */
    public function findAll() {
        $sql = "select * from epreuve where ID_ELEVE=? AND ID_PROFESSEUR=? AND ID_LANGUE=?";
        $result = $this->getDb()->fetchAll($sql);

        // Converts query result to an array of domain objects
        $enseignes = array();
        foreach ($result as $row) {
            $enseigneId = $row['ID_ELEVE'];
            ///DEMANDE POUR LES AUTRES id_prof, id_langue
            $enseignes[$enseigneId] = $this->buildDomainObject($row);
        }
        return $enseignes;
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Cree un enseigne : buildDomainObject($row) ">
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

        $langueId = $row['ID_LANGUE'];
        $langue = $this->langueDAO->find($langueId);

        $professeurId = $row['ID_PROFESSEUR'];
        $professeur = $this->professeurDAO->find($professeurId);

        $enseigne = new Enseigne();
        $enseigne->setEleve($eleve);
        $enseigne->setLangue($langue);
        $enseigne->setProfesseur($professeur);

        return $enseigne;
    }

// </editor-fold>
}
