<?php

namespace Planning\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Planning\Domain\Eleve;
use Planning\DAO\EleveDAO;
use Planning\Form\Type\EleveType;

class EleveController {

    /**
     * Displays the detail of the eleve with the given id
     * @param Application $app
     * @param type $id
     * @return type
     */
    public function detailAction(Application $app, $id) {
        $eleve = $app['dao.eleve']->find($id);
        return $app['twig']->render('eleve.html.twig', array('eleve' => $eleve));
    }

    /**
     * Lists all the eleves
     * @param Application $app
     * @return type
     */
    public function listAction(Application $app) {
        $eleves = $app['dao.eleve']->findAll();
        return $app['twig']->render('eleves.html.twig', array('eleves' => $eleves));
    }

    /**
     * Displays the form for typeing parameters of searching
     * @param Application $app
     * @return type
     */
    public function searchAction(Application $app) {
        $classes = $app['dao.classe']->findAll();
        $eleves = $app['dao.eleve']->findAll();
        return $app['twig']->render('eleves_search.html.twig', array('classes' => $classes,'eleves' => $eleves ));
    }

    /**
     * Adds a eleve
     * @param Request $request
     * @param Application $app
     * @return type
     */
    public function addAction(Request $request, Application $app) {       
        $eleveFormView = NULL;
        $eleve = new Eleve();        
        $classes = $app['dao.classe']->findAll();
        $classe = current($classes);
        $classeId = $classe->getId();
        $eleveForm = $app['form.factory']->create(new EleveType($classes, $classeId), $eleveF);
        $eleveForm->handleRequest($request);
        if ($eleveForm->isValid()) {
            // Manually affect classe to the new eleve
            $classeId = $eleveForm->get('classe')->getData();
            $classe = $app['dao.classe']->find($classeId);
            $eleve->setClasse($classe);
            $app['dao.eleve']->save($eleve);
            $app['session']->getFlashBag()->add('success', 'Un eleve a été ajouté.');
        }
        $eleveFormView = $eleveForm->createView();
        return $app['twig']->render('eleve_form.html.twig', array('eleveForm' => $eleveFormView));
    }

    /**
     * Updates a eleve
     * @param Request $request
     * @param Application $app
     * @param type $id
     * @return type
     */
    public function editAction(Request $request, Application $app, $id) {
        $eleveFormView = NULL;
        $eleve = $app['dao.eleve']->find($id);
        $classes = $app['dao.classe']->findAll();
        // When editing we need to assign the good classe in the dropdown list
        $eleveForm = $app['form.factory']->create(new EleveType($classes, $eleve->getClasse()->getId()), $eleve);
        $eleveForm->handleRequest($request);
        if ($eleveForm->isValid()) {
            // Manually affect classe to the new eleve 
            $classeId = $eleveForm->get('classe')->getData();
            $classe = $app['dao.classe']->find($classeId);
            $eleve->setClasse($classe);
            $app['dao.eleve']->save($eleve);
            $app['session']->getFlashBag()->add('success', 'Un eleve a été modifié avec succès .');
        }
        $eleveFormView = $eleveForm->createView();
        return $app['twig']->render('eleve.html.twig', array('eleveForm' => $eleveFormView));
    }
/////////////////////////////////////////////////////////////A TESTER///////////////////////////////////////////////
    /**
     * Delete article controller.
     *
     * @param integer $id Article id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function deleteEleveAction($id, Request $request, Application $app) {
        // Delete all associated comments
        $app['dao.classe']->deleteAllByEleve($id);
        // Delete the article
        $app['dao.eleve']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The article was succesfully removed.');
        return $app->redirect('/admin');
    }
    
    
    /**
     * Gets the parameters of search and displays the results of search
     * @param Request $request
     * @param Application $app
     * @return type
     */
    public function resultsAction(Request $request, Application $app) {
        if ($request->request->has('dllNomEleve')) {
// Advanced search by nom
            $eleveId = $request->request->get('dllNomEleve');
            $eleves = $app['dao.eleve']->findAllByNom($eleveId);
        } else {
            if ($request->request->has('dllClasseEleve')) {
// Simple search by classe
                $classeId = $request->request->get('dllClasseEleve');
                $eleves = $app['dao.eleve']->findAllByClasse($classeId);
            }
        }
        return $app['twig']->render('eleves_results.html.twig', array('eleves' => $eleves));
    }

}
