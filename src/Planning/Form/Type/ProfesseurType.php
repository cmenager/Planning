<?php

namespace Planning\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfesseurType extends AbstractType {

    public function __construct() {
    }
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('nom', 'text', array(
                    'label' => 'Nom',
                ))
                ->add('prenom', 'text', array(
                    'label' => 'Prenom',
                ))
                ->add('role', 'text', array(
                    'label' => 'Role',
                ))               
                ->add('username', 'text', array(
                    'label' => "Login",
                ))
                ->add('password', 'password', array(
                    'label' => 'Mot de passe',
                ))
                ->add('save', 'submit', array(
                    'label' => 'Valider',
        ));
    }

    public function getName() {
        return 'professeur';
    }

}
