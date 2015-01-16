<?php

namespace Planning\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Planning\Domain\Professeur;
use Planning\DAO\ProfesseurDAO;

class ProfesseurController {

    /**
     * Displays the detail of the professeur with the given id
     * @param Application $app
     * @param type $id
     * @return type
     */
    public function detailAction(Application $app, $id) {
        $professeur = $app['dao.professeur']->find($id);
        return $app['twig']->render('professeur.html.twig', array('professeur' => $professeur));
    }

    /**
     * Lists all the professeurs
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
        $roles = array('ROLE_USER'=> 'ROLE_USER','ROLE_ADMIN'=>'ROLE_ADMIN');
        $professeurs = $app['dao.professeur']->findAll();
        return $app['twig']->render('professeurs_search.html.twig', array('roles' => $roles, 'professeurs' => $professeurs));
    }
  
    /**
     * Adds a professeur
     * @param Request $request
     * @param Application $app
     * @return type
     */
    public function addAction(Request $request, Application $app) {       
        $professeurFormView = NULL;
        $professeur = new Professeur();        
        $professeurForm = $app['form.factory']->create(new ProfesseurType, $professeur);
        $professeurForm->handleRequest($request);
        if ($professeurForm->isValid()) {
            // Manually affect classe to the new visit report
            $app['dao.professeur']->save($professeur);
            $app['session']->getFlashBag()->add('success', 'Un professeur a été ajouté.');
        }
        $professeurFormView = $professeurForm->createView();
        return $app['twig']->render('professeur_form.html.twig', array('professeurForm' => $professeurFormView));
    }

    /**
     * Updates a professeur
     * @param Request $request
     * @param Application $app
     * @param type $id
     * @return type
     */
    public function editAction(Request $request, Application $app, $id) {
        $professeurFormView = NULL;
        $professeur = $app['dao.professeur']->find($id);;
        // When editing we need to assign the good classe in the dropdown list
        $professeurForm = $app['form.factory']->create(new ProfesseurType, $professeur );
        $professeurForm->handleRequest($request);
        if ($professeurForm->isValid()) {
            // Manually affect classe to the new visit report
            $app['dao.professeur']->save($professeur);
            $app['session']->getFlashBag()->add('success', 'Un professeur a été modifié avec succès .');
        }
        $professeurFormView = $professeurForm->createView();
        return $app['twig']->render('professeurs.html.twig', array('professeurForm' => $professeurFormView));
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
