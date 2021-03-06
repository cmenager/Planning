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
     * Afficher le détail sur une élève par l'identifiant
     * 
     * @param Application $app
     * @param type $id
     * @return type
     */
    public function detailAction(Application $app, $id) {
        $eleve = $app['dao.eleve']->find($id);
        return $app['twig']->render('eleve.html.twig', array('title' => 'Détails sur un élève','eleve' => $eleve));
    }

    /**
     * Lister tous les élèves
     * 
     * @param Application $app
     * @return type
     */
    public function listAction(Application $app) {
        $eleves = $app['dao.eleve']->findAll();
        return $app['twig']->render('eleves.html.twig', array('title' => 'Liste des élèves','eleves' => $eleves));
    }

    /**
     * Afficher le formulaire pour saisir les paramètres de la recherche
     * Rechercher l'un des élèves ou l'une des classes
     * 
     * @param Application $app
     * @return type
     */
    public function searchAction(Application $app) {
        $classes = $app['dao.classe']->findAll();
        $eleves = $app['dao.eleve']->findAll();
        return $app['twig']->render('eleves_search.html.twig', array('title' => 'Recherche un élève','classes' => $classes, 'eleves' => $eleves));
    }

    /**
     * Obtenir le resultat de la recherche effectué par le nom d'un élève ou la classe
     * 
     * @param Request $request
     * @param Application $app
     * @return type
     */
    public function resultsAction(Request $request, Application $app) {
        if ($request->request->has('dllNomEleve')) {
            $eleveId = $request->request->get('dllNomEleve');
            $eleves = $app['dao.eleve']->findAllByNom($eleveId);
        } else {
            if ($request->request->has('dllClasseEleve')) {
                $classeId = $request->request->get('dllClasseEleve');
                $eleves = $app['dao.eleve']->findAllByClasse($classeId);
            }
        }
        return $app['twig']->render('eleves_results.html.twig', array('title' => 'Resultat de la recherche',
            'eleves' => $eleves));
    }

    /**
     * Ajouter un élève
     * 
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
        
        $eleveForm = $app['form.factory']->create(new EleveType($classes, $classeId), $eleve);
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
        return $app['twig']->render('eleve_form.html.twig', array('title' => 'Ajouter un élève','eleveForm' => $eleveFormView));
    }

    /**
     * Éditer un élève par l'identifiant
     * 
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
        return $app['twig']->render('eleve_form.html.twig', array('title' => 'Modifier un élève','eleveForm' => $eleveFormView));
    }

    /**
     * Supprimer un élève par l'identifiant
     *
     * @param integer $id Eleve id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function deleteEleveAction($id, Request $request, Application $app) {
        // Delete the eleve
        $app['dao.eleve']->delete($id);
        $app['session']->getFlashBag()->add('success', 'Un eleve a été supprimé.');
        return $app->redirect('/admin');
    }

}
