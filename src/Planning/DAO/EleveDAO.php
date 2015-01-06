<?php

namespace Planning\DAO;

use Planning\Domain\Eleve;

class EleveDAO extends DAO 
{
    
    // <editor-fold defaultstate="collapsed" desc="Trouver un eleve par identifiant : (find($id))"> 
    /**
     * Returns the eleve matching a given id.
     *
     * @param integer $id The eleve id.
     *
     * @return \Planning\Domain\Eleve|throws an exception if no eleve is found.
     */
    public function find($id) {
        $sql = "select * from eleve where id_eleve=?";
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
        $sql = "select * from eleve order by id_eleve";
        $result = $this->getDb()->fetchAll($sql);

        // Converts query result to an array of domain objects
        $eleves = array();
        foreach ($result as $row) {
            $eleveId = $row['id_eleve'];
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
        $eleve = new Eleve();
        $eleve->setId($row['id_eleve']);
        $eleve->setNom($row['nom']);
        $eleve->setPrenom($row['prenom']);
        $eleve->setTierstemps($row['tiers_temps']);
      
        return $eleve;
    }
// </editor-fold>
}
