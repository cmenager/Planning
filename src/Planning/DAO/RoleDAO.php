<?php

namespace Planning\DAO;

use Planning\Domain\Professeur;

class RoleDAO extends DAO {
    
    
    // <editor-fold defaultstate="collapsed" desc="Trouver un role par identifiant : (find($id))"> 
    /**
     * Returns the role matching a given id.
     *
     * @param integer $id The role id.
     *
     * @return \Planning\Domain\Role|throws an exception if no role is found.
     */
    public function find($id) {
        $sql = "select * from role where ID_ROLE=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No role found for id " . $id);
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Trouver tous les role par identifiant : findAll()"> 
    /**
     * Returns the list of all eleve, sorted by nom.
     *
     * @return array The list of all eleves.
     */
    public function findAll() {
        $sql = "select * from role order by ID_ROLE";
        $result = $this->getDb()->fetchAll($sql);

        // Converts query result to an array of domain objects
        $roles = array();
        foreach ($result as $row) {
            $roleId = $row['ID_ROLE'];
            $roles[$roleId] = $this->buildDomainObject($row);
        }
        return $roles;
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Cree un classe : buildDomainObject($row) ">
    /**
     * Creates a role instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \Planning\Domain\Role
     */
    protected function buildDomainObject($row) {
        $role = new Classe();
        $role->setId($row['ID_ROLE']);
        $role->setLibelle($row['LIBELLE_ROLE']);
        

        return $role;
    }

// </editor-fold>
}
