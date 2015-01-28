<?php

namespace Planning\DAO;

use Planning\Domain\Heurepassage;

class HeurepassageDAO extends DAO {

    // <editor-fold defaultstate="collapsed" desc="Trouver un heure de passage par identifiant : (find($id))"> 
    /**
     * Returns the heure de passage matching a given id.
     *
     * @param integer $id The heure de passage id.
     *
     * @return \Planning\Domain\Heurepassage|throws an exception if no heurepassage is found.
     */
    public function find($id) {
        $sql = "select * from heurepassage where ID_HEURE_PASSAGE=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("Aucune identifiant trouvé de Heure de passage " . $id);
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Trouver tous les heure de passage par identifiant : findAll()"> 
    /**
     * Returns the list of all heure de passage, sorted by nom.
     *
     * @return array The list of all heure de passage.
     */
    public function findAll() {
        $sql = "select * from heurepassage order by ID_HEURE_PASSAGE";
        $result = $this->getDb()->fetchAll($sql);

        // Converts query result to an array of domain objects
        $heurepassages = array();
        foreach ($result as $row) {
            $heurepassageId = $row['ID_HEURE_PASSAGE'];
            $heurepassages[$heurepassageId] = $this->buildDomainObject($row);
        }
        return $heurepassages;
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
        $heurepassage = new Heurepassage();
        $heurepassage->setId($row['ID_HEURE_PASSAGE']);
        $heurepassage->setHeuredeb($row['HEURE_DEBUT']);
        $heurepassage->setHeurefin($row['HEURE_FIN']);

        return $heurepassage;
    }

// </editor-fold>
}
