<?php

namespace Planning\DAO;

use Planning\Domain\Langue;

class LangueDAO extends DAO {


    // <editor-fold defaultstate="collapsed" desc="Trouver un langue par identifiant : (find($id))"> 
    /**
     * Returns the langue matching a given id.
     *
     * @param integer $id The langue id.
     *
     * @return \Planning\Domain\Langue|throws an exception if no langue is found.
     */
    public function find($id) {
        $sql = "select * from langue where ID_LANGUE=?";
        
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No langue found for id " . $id);
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Trouver tous les langues par identifiant : findAll()"> 
    /**
     * Returns the list of all eleve, sorted by nom.
     *
     * @return array The list of all eleves.
     */
    public function findAll() {
        $sql = "select * from langue order by ID_LANGUE";
        $result = $this->getDb()->fetchAll($sql);

        // Converts query result to an array of domain objects
        $langues = array();
        foreach ($result as $row) {
            $langueId = $row['ID_LANGUE'];
            $langues[$langueId] = $this->buildDomainObject($row);
        }
        return $langues;
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
        $langue = new Langue();
        $langue->setId($row['ID_LANGUE']);
        $langue->setLibelle($row['LIBELLE_LANGUE']);

        return $langue;
    }

// </editor-fold>
}
