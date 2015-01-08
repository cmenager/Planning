<?php

namespace Planning\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

use Planning\Domain\Professeur;

class ProfesseurDAO extends DAO implements UserProviderInterface {

    /**
     * @var \Planning\DAO\RoleDAO
     */
    private $roleDAO;

    public function setRoleDAO($roleDAO) {
        $this->roleDAO = $roleDAO;
    }

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
     * Returns the list of all eleve, sorted by nom.
     *
     * @return array The list of all eleves.
     */
    public function findAll() {
        $sql = "select * from professeur order by ID_PROFESSEUR";
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
     * Returns the list of all drugs for a given family, sorted by trade name.
     *
     * @param integer $familyDd The family id.
     *
     * @return array The list of drugs.
     */
    public function findAllByRole($roleId) {
        $sql = "select * from professeur where ID_ROLE=? order by ID_PROFESSEUR";
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
        $roleId = $row['ID_ROLE'];
        $role = $this->roleDAO->find($roleId);

        $professeur = new Professeur();
        $professeur->setId($row['ID_PROFESSEUR']);
        $professeur->setNom($row['NOM_PROFESSEUR']);
        $professeur->setPrenom($row['PRENOM_PROFESSEUR']);
        $professeur->setUsername($row['LOGIN_PROFESSEUR']);
        $professeur->setPassword($row['PWD_PROFESSEUR']);
        $professeur->setSalt($row['SALT_PROFESSEUR']);
        $professeur->setRole($role);

        return $professeur;
    }
    // </editor-fold>
}
