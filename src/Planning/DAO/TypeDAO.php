<?php

namespace Planning\DAO;

use Planning\Domain\Type;

class TypeDAO extends DAO {
    
    
    // <editor-fold defaultstate="collapsed" desc="Trouver un type par identifiant : (find($id))"> 
    /**
     * Returns the type matching a given id.
     *
     * @param integer $id The type id.
     *
     * @return \Planning\Domain\type|throws an exception if no type is found.
     */
    public function find($id) {
        $sql = "select * from type where ID_TYPE=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No type found for id " . $id);
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Trouver tous les types par identifiant : findAll()"> 
    /**
     * Returns the list of all eleve, sorted by nom.
     *
     * @return array The list of all eleves.
     */
    public function findAll() {
        $sql = "select * from type order by ID_TYPE";
        $result = $this->getDb()->fetchAll($sql);

        // Converts query result to an array of domain objects
        $types = array();
        foreach ($result as $row) {
            $typeId = $row['ID_TYPE'];
            $types[$typeId] = $this->buildDomainObject($row);
        }
        return $types;
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Cree un classe : buildDomainObject($row) ">
    /**
     * Creates a type instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \Planning\Domain\type
     */
    protected function buildDomainObject($row) {
        $type = new Type();
        $type->setId($row['ID_TYPE']);
        $type->setLibelle($row['LIBELLE_TYPE']);
        

        return $type;
    }

// </editor-fold>
}
