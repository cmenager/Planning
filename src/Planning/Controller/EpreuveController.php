<?php

namespace Planning\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Planning\Domain\Epreuve;
use Planning\DAO\EpreuveDAO;

class EpreuveController {

    /**
     * Displays the detail of the epreuve with the given id
     * @param Application $app
     * @param type $id
     * @return type
     */
    public function detailAction(Application $app, $id) {
        $epreuve = $app['dao.epreuve']->find($id);
        return $app['twig']->render('epreuve.html.twig', array('epreuve' => $epreuve));
    }

    /**
     * Lists all the epreuves
     * @param Application $app
     * @return type
     */
    public function listAction(Application $app) {
        $epreuves = $app['dao.epreuve']->findAll();
        return $app['twig']->render('epreuves.html.twig', array('epreuves' => $epreuves));
    }

    /**
     * Displays the form for typeing parameters of searching
     * @param Application $app
     * @return type
     */
    public function searchAction(Application $app) {
        $epreuves = $app['dao.epreuve']->findAll();
        $professeurs = $app['dao.professeur']->findAll();
        return $app['twig']->render('epreuves_search.html.twig', array('epreuves' => $epreuves, 'professeurs' => $professeurs));
    }

    /**
     * Gets the parameters of search and displays the results of search
     * @param Request $request
     * @param Application $app
     * @return type
     */
    public function resultsAction(Request $request, Application $app) {

        if ($request->request->has('nom')) {
// Advanced search by nom
            $nom = $request->request->get('nom');
            $epreuves = $app['dao.epreuve']->findAllByNom($nom);
        } else {
// Simple search by classe
            $professeurId = $request->request->get('professeur');
            $epreuves = $app['dao.epreuve']->findAllByProfesseur($professeurId);
        }
        return $app['twig']->render('epreuves_results.html.twig', array('epreuves' => $epreuves));
    }

}
