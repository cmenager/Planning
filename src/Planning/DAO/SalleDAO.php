<?php

namespace Planning\DAO;

use Planning\Domain\Salle;

class SalleDAO extends DAO {
    
    
    // <editor-fold defaultstate="collapsed" desc="Trouver un Salle par identifiant : (find($id))"> 
    /**
     * Returns the Salle matching a given id.
     *
     * @param integer $id The Salle id.
     *
     * @return \Planning\Domain\Salle|throws an exception if no Salle is found.
     */
    public function find($id) {
        $sql = "select * from SALLE where ID_SALLE=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No salle found for id " . $id);
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Trouver tous les Salles par identifiant : findAll()"> 
    /**
     * Returns the list of all Salle, sorted by nom.
     *
     * @return array The list of all Salle.
     */
    public function findAll() {
        $sql = "select * from salle order by ID_SALLE";
        $result = $this->getDb()->fetchAll($sql);

        // Converts query result to an array of domain objects
        $salles = array();
        foreach ($result as $row) {
            $salleId = $row['ID_SALLE'];
            $salles[$salleId] = $this->buildDomainObject($row);
        }
        return $salles;
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Cree un salle : buildDomainObject($row) ">
    /**
     * Creates a salles instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \Planning\Domain\Salle
     */
    protected function buildDomainObject($row) {
        $salle = new Salle();
        $salle->setId($row['ID_SALLE']);
        $salle->setLibelle($row['LIBELLE_SALLE']);
       
        return $salle;
    }

// </editor-fold>
}
