<?php

namespace Planning\DAO;

use Planning\Domain\Eleve;

class EleveDAO extends DAO {

    /**
     * @var \Planning\DAO\ClasseDAO
     */
    private $classeDAO;

    public function setClasseDAO($classeDAO) {
        $this->classeDAO = $classeDAO;
    }

    // <editor-fold defaultstate="collapsed" desc="Trouver un eleve par identifiant : (find($id))"> 
    /**
     * Returns the eleve matching a given id.
     *
     * @param integer $id The eleve id.
     *
     * @return \Planning\Domain\Eleve|throws an exception if no eleve is found.
     */
    public function find($id) {
        $sql = "select * from eleve where ID_ELEVE=?";

        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No eleve found for id " . $id);
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Trouver tous les eleves par identifiant : findAll()"> 
    /**
     * Returns the list of all eleve, sorted by nom.
     *
     * @return array The list of all eleves.
     */
    public function findAll() {
        $sql = "select * from eleve order by ID_ELEVE";
        $result = $this->getDb()->fetchAll($sql);

        // Converts query result to an array of domain objects
        $eleves = array();
        foreach ($result as $row) {
            $eleveId = $row['ID_ELEVE'];
            $eleves[$eleveId] = $this->buildDomainObject($row);
        }
        return $eleves;
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Trouver les eleves par classe : findAllByClasse()"> 
    /*
     * Returns the list of all eleves for a given nom, sorted by trade name.
     *
     * @param integer $nomDd The nom id.
     *
     * @return array The list of eleves.
     */
    public function findAllByClasse($classeId) {
        $sql = "select * from eleve where ID_CLASSE=? order by NOM_ELEVE";
        $result = $this->getDb()->fetchAll($sql, array($classeId));

        // Convert query result to an array of domain objects
        $eleves = array();
        foreach ($result as $row) {
            $eleveId = $row['ID_ELEVE'];
            $eleves[$eleveId] = $this->buildDomainObject($row);
        }
        return $eleves;
    }

// </editor-fold>
    // // <editor-fold defaultstate="collapsed" desc="Trouver les eleve par nom : findAllByNom()"> 
    /*
     * Returns the list of all drugs for a given family, sorted by trade name.
     *
     * @param integer $familyDd The family id.
     *
     * @return array The list of drugs.
     */
    public function findAllByNom($nomId) {
        $sql = "select * from eleve where NOM_ELEVE=? order by ID_ELEVE";
        $result = $this->getDb()->fetchAll($sql, array($nomId));

        // Convert query result to an array of domain objects
        $eleves = array();
        foreach ($result as $row) {
            $eleveId = $row['ID_ELEVE'];
            $eleves[$eleveId] = $this->buildDomainObject($row);
        }
        return $eleves;
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Cree un eleve : buildDomainObject($row) ">
    /**
     * Creates a Eleve instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \Planning\Domain\Eleve
     */
    protected function buildDomainObject($row) {
        $classeId = $row['ID_CLASSE'];
        $classe = $this->classeDAO->find($classeId);


        $eleve = new Eleve();
        $eleve->setId($row['ID_ELEVE']);
        $eleve->setNom($row['NOM_ELEVE']);
        $eleve->setPrenom($row['PRENOM_ELEVE']);
        $eleve->setTierstemps($row['TIERS_TEMPS']);
        $eleve->setClasse($classe);

        return $eleve;
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Sauvegarder un eleve : save($eleve)">
    public function save(Eleve $eleve) {
        $eleveData = array(
            'NOM_ELEVE' => $eleve->getNom(),
            'PRENOM_ELEVE' => $eleve->getPrenom(),
            'ID_CLASSE' => $eleve->getClasse()->getId()
        );

        if ($eleve->getId()) {
            // The visit report has already been saved : update it
            $this->getDb()->update('eleve', $eleveData, array('ID_ELEVE' => $eleve->getId()));
        } else {
            // The visit report has never been saved : insert it
            $this->getDb()->insert('eleve', $eleveData);
            // Get the id of the newly created visit report and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $eleve->setId($id);
        }
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Supprimer un eleve : delete($id)">
    /**
     * Removes a eleve from the database.
     *
     * @param \Planning\Domain\Eleve $eleve The eleve to remove
     */
    public function delete($id) {
        // Delete the eleve
        $this->getDb()->delete('eleves', array('ID_ELEVE' => $id));
    }

// </editor-fold>
}
