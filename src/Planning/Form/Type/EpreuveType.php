<?php

namespace Planning\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EpreuveType extends AbstractType {

    private $eleve;
    private $professeurs;
    private $professeurId;
    private $heures;
    private $heureId;
    private $langues;
    private $langueId;
    private $salles;
    private $salleId;

    /**
     * Constructor.
     * 
     * @param arrays $professeurs, $eleves, $professeurId, $eleveId
     */
    public function __construct($eleve ,$professeurs, $professeurId, $heures, $heureId, $langues, $langueId, $salles, $salleId) {

        $this->eleve = $eleve;
        $this->professeurs = $professeurs;
        $this->professeurId = $professeurId;
        $this->heures = $heures;
        $this->heureId = $heureId;
        $this->langues = $langues;
        $this->langueId = $langueId;
        $this->salles = $salles;
        $this->salleId = $salleId;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('datepassage', 'text', array(
                    'label' => "Date de passage :",
                ))
                ->add('heurepassage', 'choice', array(
                    'label' => "Heure de passage :",
                    'choices' => $this->heures,
                    'expanded' => false,
                    'multiple' => false,
                    'mapped' => false, // this field is not mapped to an object property
                    'preferred_choices' => array($this->heureId),
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
