<?php

namespace Planning\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EpreuveType extends AbstractType {

    private $eleves;
    private $eleveId;
    private $professeurs;
    private $professeurId;
    private $langues;
    private $langueId;
    private $salles;
    private $salleId;

    /**
     * Constructor.
     * 
     * @param arrays $professeurs, $eleves, $professeurId, $eleveId
     */
    public function __construct($eleves, $eleveId ,$professeurs, $professeurId, $langues, $langueId, $salles, $salleId) {

        $this->eleves = $eleves;
        $this->eleveId = $eleveId;
        $this->professeurs = $professeurs;
        $this->professeurId = $professeurId;
        $this->langues = $langues;
        $this->langueId = $langueId;
        $this->salles = $salles;
        $this->salleId = $salleId;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder              
                ->add('eleve', 'choice', array(
                    'label' => "Eleve :",
                    'choices' => $this->eleves,
                    'expanded' => false,
                    'multiple' => false,
                    'mapped' => false, // this field is not mapped to an object property
                    'preferred_choices' => array($this->eleveId),
                ))
                ->add('professeur', 'choice', array(
                    'label' => "Professeur :",
                    'choices' => $this->professeurs,
                    'expanded' => false,
                    'multiple' => false,
                    'mapped' => false, // this field is not mapped to an object property
                    'preferred_choices' => array($this->professeurId),
                ))
                ->add('langue', 'choice', array(
                    'label' => "Langue :",
                    'choices' => $this->langues,
                    'expanded' => false,
                    'multiple' => false,
                    'mapped' => false, // this field is not mapped to an object property
                    'preferred_choices' => array($this->langueId),
                ))
                ->add('salle', 'choice', array(
                    'label' => "Salle :",
                    'choices' => $this->salles,
                    'expanded' => false,
                    'multiple' => false,
                    'mapped' => false, // this field is not mapped to an object property
                    'preferred_choices' => array($this->salleId),
                ))
                ->add('save', 'submit', array(
                    'label' => 'Valider',
        ));
    }

    public function getName() {
        return 'epreuve';
    }

}
