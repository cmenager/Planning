<?php

namespace Planning\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfesseurType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('nom', 'text', array(
                    'label' => "Nom",
                ))
                ->add('prenom', 'text', array(
                    'label' => "Prenom",
                ))
                ->add('login', 'text', array(
                    'label' => "Login",
                ))
                ->add('role', 'text', array(
                    'label' => "Role",
                ))
                ->add('save', 'submit', array(
                    'label' => 'Valider',
        ));
    }

    public function getName() {
        return 'professeur';
    }

}

