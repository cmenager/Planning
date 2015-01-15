<?php

namespace Planning\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Planning\Domain\Eleve;
use Planning\DAO\EleveDAO;

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
        return $app['twig']->render('eleves_search.html.twig', array('classes' => $classes));
    }

    /**
     * Adds a Report
     * @param Request $request
     * @param Application $app
     * @return type
     */
    public function addAction(Request $request, Application $app) {
        $eleve = new Eleve();
        $eleveForm = $app['form.factory']->create(new EleveType(), $eleve);
        $eleveForm->handleRequest($request);
        if ($eleveForm->isValid()) {
            $app['dao.eleve']->save($eleve);
            $app['session']->getFlashBag()->add('success', 'Un eleve a été créée avec succés');
        }
        $classes = $app['dao.classe']->findAll();
        return $app['twig']->render('eleve_form.html.twig', array(
                    'title' => 'Nouveau eleve',
                    'eleveForm' => $eleveForm->createView(), 'classes' => $classes,));
    }

    /**
     * Updates a Report
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
            // Manually affect classe to the new visit report
            $classeId = $eleveForm->get('classe')->getData();
            $classe = $app['dao.classe']->find($classeId);
            $eleve->setClasse($classe);
            $app['dao.eleve']->save($eleve);
            $app['session']->getFlashBag()->add('success', 'Un eleve a été modifié.');
        }
        $eleveFormView = $eleveForm->createView();
        return $app['twig']->render('eleve_form.html.twig', array('eleveForm' => $eleveFormView));
    }

    /**
     * Delete a Eleve
     * @param Request $request
     * @param Application $app
     * @param type $id
     * @return type
     */
    public function deleteAction(Request $request, Application $app, $id) {
        $app['dao.eleve']->delete($id);
        $app['session']->getFlashBag()->add('success', 'Un eleve a été supprimé avec succès !');
        return $app->redirect('/admin');
    }

    /**
     * Gets the parameters of search and displays the results of search
     * @param Request $request
     * @param Application $app
     * @return type
     */
    public function resultsAction(Request $request, Application $app) {
        if ($request->request->has('dllEleve')) {
// Advanced search by nom
            $eleveId = $request->request->get('dllEleve');
            $eleves = $app['dao.eleve']->findAllByNom($eleveId);
        } else {
            if ($request->request->has('dllClasse')) {
// Simple search by classe
                $classeId = $request->request->get('dllClasse');
                $eleves = $app['dao.eleve']->findAllByClasse($classeId);
            }
        }
        return $app['twig']->render('eleves_results.html.twig', array('eleves' => $eleves));
    }

}
