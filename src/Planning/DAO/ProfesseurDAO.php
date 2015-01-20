<?php

namespace Planning\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Planning\Domain\Professeur;

class ProfesseurDAO extends DAO implements UserProviderInterface {

    // <editor-fold defaultstate="collapsed" desc="Trouver un professeur par identifiant : (find($id))"> 
    /**
     * Returns a Prof matching the supplied id.
     *
     * @param integer $id
     *
     * @return \Planning\Domain\Professeur|throws an exception if no matching Prof is found
     */
    public function find($id) {
        $sql = "select * from professeur where ID_PROFESSEUR=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No professeur matching id " . $id);
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Trouver tous les professeurs par identifiant : findAll()"> 
    /**
     * Returns the list of all professeur, sorted by nom.
     *
     * @return array The list of all professeurs.
     */
    public function findAll() {
        $sql = "select * from professeur";
        $result = $this->getDb()->fetchAll($sql);

        // Converts query result to an array of domain objects
        $professeurs = array();
        foreach ($result as $row) {
            $professeurId = $row['ID_PROFESSEUR'];
            $professeurs[$professeurId] = $this->buildDomainObject($row);
        }
        return $professeurs;
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Trouver les professeurs par role : findAllByRole()"> 
    /*
     * Returns the list of all professeur for a given role, sorted by trade name.
     *
     * @param integer $role The role id.
     *
     * @return array The list of drugs.
     */
    public function findAllByRole($roleId) {
        $sql = "select * from professeur where ROLE=? order by ID_PROFESSEUR ";
        $result = $this->getDb()->fetchAll($sql, array($roleId));

        // Convert query result to an array of domain objects
        $professeurs = array();
        foreach ($result as $row) {
            $professeurId = $row['ID_PROFESSEUR'];
            $professeurs[$professeurId] = $this->buildDomainObject($row);
        }
        return $professeurs;
    }

    // </editor-fold>
    //  // // <editor-fold defaultstate="collapsed" desc="Trouver les professeurs par nom : findAllByNom()"> 
    /*
     * Returns the list of all drugs for a given family, sorted by trade name.
     *
     * @param integer $familyDd The family id.
     *
     * @return array The list of drugs.
     */
    public function findAllByNom($nomId) {
        $sql = "select * from professeur where ID_PROFESSEUR=? order by ID_PROFESSEUR";
        $result = $this->getDb()->fetchAll($sql, array($nomId));

        // Convert query result to an array of domain objects
        $professeurs = array();
        foreach ($result as $row) {
            $professeurId = $row['ID_PROFESSEUR'];
            $professeurs[$professeurId] = $this->buildDomainObject($row);
        }
        return $professeurs;
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="loadUserByUsername($username)"> 
    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username) {
        $sql = "select * from professeur where LOGIN_PROFESSEUR=?";
        $row = $this->getDb()->fetchAssoc($sql, array($username));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new UsernameNotFoundException(sprintf('professeur "%s" not found.', $username));
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="refreshUser(UserInterface $user)"> 
    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user) {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="supportsClass($class)"> 
    /**
     * {@inheritDoc}
     */
    public function supportsClass($class) {
        return 'Planning\Domain\Professeur' === $class;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="buildDomainObject($row)"> 
    /**
     * Creates a User object based on a DB row.
     *
     * @param array $row The DB row containing User data.
     * @return \MicroCMS\Domain\User
     */
    protected function buildDomainObject($row) {

        $professeur = new Professeur();
        $professeur->setId($row['ID_PROFESSEUR']);
        $professeur->setRole($row['ROLE']);
        $professeur->setNom($row['NOM_PROFESSEUR']);
        $professeur->setPrenom($row['PRENOM_PROFESSEUR']);
        $professeur->setUsername($row['LOGIN_PROFESSEUR']);
        $professeur->setPassword($row['PWD_PROFESSEUR']);
        $professeur->setSalt($row['SALT_PROFESSEUR']);


        return $professeur;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Sauvegarder un professeur : save($professeur)">
    public function save(Professeur $professeur) {
        $professeurData = array(
            'NOM_PROFESSEUR' => $professeur->getNom(),
            'PRENOM_PROFESSEUR' => $professeur->getPrenom(),
            'LOGIN_PROFESSEUR' => $professeur->getUsername(),
            'ROLE'=> $professeur->getRole()
        );

        if ($professeur->getId()) {
            // The visit report has already been saved : update it
            $this->getDb()->update('professeur', $professeurData, array('ID_PROFESSEUR' => $professeur->getId()));
        } else {
            // The visit report has never been saved : insert it
            $this->getDb()->insert('professeur', $professeurData);
            // Get the id of the newly created visit report and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $professeur->setId($id);
        }
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Supprimer un professeur : delete($id)">
    /**
     * Removes a professeur from the database.
     *
     * @param \Planning\Domain\Professeur $professeur The professeur to remove
     */
    public function delete($id) {
        // Delete the professeur
        $this->getDb()->delete('professeur', array('ID_PROFESSEUR' => $id));
    }

// </editor-fold>
}
