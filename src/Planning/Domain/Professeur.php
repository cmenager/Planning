<?php

namespace Planning\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

class Professeur implements UserInterface {

    /**
     * Professeur id.
     *
     * @var integer
     */
    private $id;

    /**
     * role id.
     *
     * @var String
     */
    private $role;

    /**
     * nom.Professeur
     *
     * @var string
     */
    private $nom;

    /**
     * prenom.Professeur
     *
     * @var string
     */
    private $prenom;

    /**
     * utilisateur .
     *
     * @var string
     */
    private $username;

    /**
     * mdp.
     *
     * @var string
     */
    private $password;

    /**
     * salt.
     *
     * @var string
     */
    private $salt;

    public function getId() {
        return $this->id;
    }

    public function getRole() {
        return $this->role;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    /**
     * @inheritDoc
     */
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @inheritDoc
     */
    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getSalt() {
        return $this->salt;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
    }

    /**
     * @inheritDoc
     */
    public function getRoles() {
        return array($this->getRole());
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials() {
        // Nothing to do here
    }

}
