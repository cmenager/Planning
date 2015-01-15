<?php

namespace Planning\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Planning\Domain\Professeur;
//use Planning\Form\Type\VisitorType;
use Planning\DAO\ProfesseurDAO;

class ProfesseurController {

    /**
     * Displays the detail of the eleve with the given id
     * @param Application $app
     * @param type $id
     * @return type
     */
    public function detailAction(Application $app, $id) {
        $professeur = $app['dao.professeur']->find($id);
        return $app['twig']->render('professeur.html.twig', array('professeur' => $professeur));
    }

    /**
     * Lists all the eleves
     * @param Application $app
     * @return type
     */
    public function listAction(Application $app) {
        $professeurs = $app['dao.professeur']->findAll();
        return $app['twig']->render('professeurs.html.twig', array('professeurs' => $professeurs));
    }

    /**
     * Displays the form for typeing parameters of searching
     * @param Application $app
     * @return type
     */
    public function searchAction(Application $app) {
        $professeurs = $app['dao.professeur']->findAll();
        return $app['twig']->render('professeurs_search.html.twig', array('professeurs' => $professeurs));
    }

    
    /**
     * Gets the parameters of search and displays the results of search
     * @param Request $request
     * @param Application $app
     * @return type
     */
    public function resultsAction(Request $request, Application $app) {
        if ($request->request->has('ddlProfs')) {
// Advanced search by nom
            $ddlProfs = $request->request->get('ddlProfs');
            $professeurs = $app['dao.professeur']->findAllByNom($ddlProfs);
        } else {
            if ($request->request->has('ddlRoles')) {
// Simple search by classe
                $ddlRoles = $request->request->get('ddlRoles');
                $professeurs = $app['dao.professeur']->findAllByRole($ddlRoles);
            }
        }
        return $app['twig']->render('professeurs_results.html.twig', array('professeurs' => $professeurs));
    }

}
