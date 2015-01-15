<?php

namespace Planning\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EleveType extends AbstractType {

    private $classes;
    private $classeId;

    /**
     * Constructor.
     *
     * @param array $classes, $classeID
     */
    public function __construct($classes, $classeId) {
        $this->classes = $classes;
        $this->classeId = $classeId;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('nom', 'text', array(
                    'label' => "Nom",
                ))
                ->add('prenom', 'text', array(
                    'label' => "Prenom",
                ))
                ->add('classe', 'choice', array(
                    'label' => "Classe",
                    'choices' => $this->classes,
                    'expanded' => false,
                    'multiple' => false,
                    'mapped' => false, // this field is not mapped to an object property
                    'preferred_choices' => array($this->classeId), // To indicate the classe witch was selected the previous time             
                ))
                ->add('save', 'submit', array(
                    'label' => 'Valider',
        ));
    }

    public function getName() {
        return 'eleve';
    }

}
