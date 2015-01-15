<?php

namespace Planning\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfesseurType extends AbstractType {

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
        
         
    }

    public function getName() {
        return 'professeur';
    }

}
