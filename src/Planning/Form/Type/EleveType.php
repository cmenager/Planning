<?php

namespace Planning\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EleveType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('nom', 'text', array(
                    'label' => 'Nom',
                ))
                ->add('Prenom', 'text', array(
                    'label' => 'Prenom',
                ))
                ->add('Classe', 'text', array(
                    'label' => 'Classe',
        ));
    }

    public function getName() {
        return 'eleve';
    }

}
