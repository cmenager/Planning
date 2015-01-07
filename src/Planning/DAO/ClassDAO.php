<?php

namespace Planning\DAO;

use Planning\Domain\Classe;

class ClasseDAO extends DAO {
    
    
    // <editor-fold defaultstate="collapsed" desc="Trouver un classe par identifiant : (find($id))"> 
    /**
     * Returns the classe matching a given id.
     *
     * @param integer $id The classe id.
     *
     * @return \Planning\Domain\Classe|throws an exception if no classe is found.
     */
    public function find($id) {
        $sql = "select * from CLASSE where ID_CLASSE=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No classe found for id " . $id);
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Trouver tous les classes par identifiant : findAll()"> 
    /**
     * Returns the list of all eleve, sorted by nom.
     *
     * @return array The list of all eleves.
     */
    public function findAll() {
        $sql = "select * from CLASSE order by ID_CLASSE";
        $result = $this->getDb()->fetchAll($sql);

        // Converts query result to an array of domain objects
        $classes = array();
        foreach ($result as $row) {
            $classeId = $row['ID_CLASSE'];
            $classes[$classeId] = $this->buildDomainObject($row);
        }
        return $classes;
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Cree un classe : buildDomainObject($row) ">
    /**
     * Creates a classe instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \Planning\Domain\Classe
     */
    protected function buildDomainObject($row) {
        $classe = new Classe();
        $classe->setId($row['ID_CLASSE']);
        $classe->setLibelle($row['LIBELLE_CLASSE']);
        

        return $classe;
    }

// </editor-fold>
}
