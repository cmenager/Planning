<?php

namespace Planning\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Planning\Domain\Epreuve;
use Planning\DAO\EpreuveDAO;
use Planning\Form\Type\EpreuveType;

class EpreuveController {

    // <editor-fold defaultstate="collapsed" desc=" public function detailAction(Application $app, $id)"> 
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

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc=" public function listAction(Application $app, $id)"> 
    /**
     * Lists all the epreuves
     * @param Application $app
     * @return type
     */
    public function listAction(Application $app) {
        $epreuves = $app['dao.epreuve']->findAll();
        return $app['twig']->render('epreuves.html.twig', array('epreuves' => $epreuves));
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc=" public function searchAction(Application $app, $id)"> 
    /**
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

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc=" public function resultsAction(Application $app, $id)"> 
    /**
     * Gets the parameters of search and displays the results of search
     * @param Request $request
     * @param Application $app
     * @return type
     */
    public function resultsAction(Request $request, Application $app) {

        if ($request->request->has('ddlNomEleveEp')) {
// Advanced search by nom
            $nom = $request->request->get('ddlNomEleveEp');
            $epreuves = $app['dao.epreuve']->findAllByNomEleve($nom);
        } else {
            if ($request->request->has('ddlNomProfesseurEp')) {
// Simple search by classe
                $professeurId = $request->request->get('ddlNomProfesseurEp');
                $epreuves = $app['dao.epreuve']->findAllByNomProfesseur($professeurId);
            } else {
                if ($request->request->has('date_passage')) {
                    // Simple search by date
                    $date_passage = $request->request->get('date_passage');
                    $epreuves = $app['dao.epreuve']->findPlanningByDate($date_passage);
                }
            }
        }
        return $app['twig']->render('epreuves_results.html.twig', array('epreuves' => $epreuves));
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc=" public function searchEpreuveAddAction(Application $app, $id)"> 
    /**
     * Displays the form for typeing parameters of searching
     * @param Application $app
     * @return type
     */
    public function searchEpreuveAddAction(Request $request, Application $app) {
        $eleves = null;
        $classes = null;
        if ($request->request->has('dllClasseEpreuve')) {
            $classeId = $request->request->get('dllClasseEpreuve');
            $eleves = $app['dao.eleve']->findAllByClasse($classeId);
        } else {
            $classes = $app['dao.classe']->findAll();
        }
        return $app['twig']->render('epreuve_chxclasse_search.html.twig', array('classes' => $classes, 'eleves' => $eleves));
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc=" public function searchEpreuveSalleAction(Application $app, $id)"> 
    /**
     * Displays the form for typeing parameters of searching
     * @param Application $app
     * @return type
     */
    public function searchEpreuveSalleAction(Application $app, $id) {
        $eleve = $app['dao.eleve']->find($id);
        $salles = $app['dao.salle']->findAll();
        $professeurs = $app['dao.professeur']->findAll();
        $langues = $app['dao.langue']->findAll();
        $heures = $app['dao.heurepassage']->findAll();
        return $app['twig']->render('epreuve_chxsalle_search.html.twig', array('salles' => $salles,
                    'eleve' => $eleve, 'langues' => $langues, 'heures' => $heures, 'professeurs' => $professeurs));
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="public function addAction(Request $request, Application $app, $id)"> 
    /**
     * Adds a Report
     * @param Request $request
     * @param Application $app
     * @return type
     */
    public function addAction(Request $request, Application $app, $id) {
        $epreuveFormView = NULL;
        $epreuve = new Epreuve();

        $eleve = $app['dao.eleve']->find($id);

        $heures = $app['dao.heurepassage']->findAll();
        $heure = current($heures);
        $heureId = $heure->getId();

        $professeurs = $app['dao.professeur']->findAll();
        $professeur = current($professeurs);
        $professeurId = $professeur->getId();

        $salles = $app['dao.salle']->findAll();
        $salle = current($salles);
        $salleId = $salle->getId();

        $langues = $app['dao.langue']->findAll();
        $langue = current($langues);
        $langueId = $langue->getId();

        $epreuveForm = $app['form.factory']->create(new EpreuveType($eleve, $professeurs, $professeurId, 
                $heures, $heureId, $langues, $langueId, $salles, $salleId), $epreuve);
        $epreuveForm->handleRequest($request);
        if ($epreuveForm->isValid()) {

            $eleve = $app['dao.eleve']->find($id);
            $epreuve->setEleve($eleve);

            $heureId = $epreuveForm->get('heurepassage')->getData();
            $heure = $app['dao.heurepassage']->find($heureId);
            $epreuve->setHeurepassage($heure);

            $professeurId = $epreuveForm->get('professeur')->getData();
            $professeur = $app['dao.professeur']->find($professeurId);
            $epreuve->setProfesseur($professeur);

            $langueId = $epreuveForm->get('langue')->getData();
            $langue = $app['dao.langue']->find($langueId);
            $epreuve->setLangue($langue);

            $salleId = $epreuveForm->get('salle')->getData();
            $salle = $app['dao.salle']->find($salleId);
            $epreuve->setSalle($salle);
            $app['dao.epreuve']->insert($epreuve);
            $app['session']->getFlashBag()->add('success', 'Votre epreuve a été ajouté.');
        }
        $epreuveFormView = $epreuveForm->createView();
        return $app['twig']->render('epreuve_chxeleve_results.html.twig', array('epreuveForm' => $epreuveFormView, 'eleve' => $eleve));
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc=" public function searchEpreuveEditAction(Application $app, $id)"> 
    /**
     * Displays the form for typeing parameters of searching
     * @param Application $app
     * @return type
     */
    public function searchEpreuveEditAction(Request $request, Application $app) {
        $eleves = null;
        $classes = null;
        $professeurs = null;
        $epreuves = null;

        if ($request->request->has('dllClasseEpreuve')) {
            $classeId = $request->request->get('dllClasseEpreuve');
            $epreuves = $app['dao.eleve']->findAllByClasse($classeId);
        } else {
            $classes = $app['dao.classe']->findAll();
        }

        if ($request->request->has('dllProfesseurEpreuve')) {
            $professeurId = $request->request->get('dllProfesseurEpreuve');
            $epreuves = $app['dao.epreuve']->findAllByNomProfesseur($professeurId);
        } else {
            $professeurs = $app['dao.professeur']->findAll();
        }

        if ($request->request->has('ddlDateEpreuve')) {
            $date = $request->request->get('ddlDateEpreuve');
            $eleves = $app['dao.epreuve']->findAllByDate($date);
        }

        return $app['twig']->render('epreuve_ttchx_edit_search.html.twig', array('classes' => $classes,
                    'eleves' => $eleves, 'professeurs' => $professeurs, 'epreuves' => $epreuves));
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="public function editAction(Request $request, Application $app, $id)"> 
    /**
     * Updates a Report
     * @param Request $request
     * @param Application $app
     * @param type $id
     * @return type
     */
    public function editAction(Request $request, Application $app, $id) {
        $epreuveFormView = NULL;

        $eleve = $app['dao.eleve']->find($id);
        $epreuve = $app['dao.epreuve']->find($id);
        $heures = $app['dao.heurepassage']->findAll();
        $professeurs = $app['dao.professeur']->findAll();
        $salles = $app['dao.salle']->findAll();
        $langues = $app['dao.langue']->findAll();

        // When editing we need to assign the good practitioner in the dropdown list
        $epreuveForm = $app['form.factory']->create(new EpreuveType($eleve, $professeurs, $heures, $langues, $salles,
                $epreuve->getProfesseur()->getId(), $epreuve->getHeurepassage()->getId(), $epreuve->getSalle()->getId(),
                $epreuve->getLangue()->getId()), $epreuve);

        $epreuveForm->handleRequest($request);
        if ($epreuveForm->isValid()) {

            $eleve = $app['dao.eleve']->find($id);
            $epreuve->setEleve($eleve);

            $heureId = $epreuveForm->get('heurepassage')->getData();
            $heure = $app['dao.heurepassage']->find($heureId);
            $epreuve->setHeurepassage($heure);

            $professeurId = $epreuveForm->get('professeur')->getData();
            $professeur = $app['dao.professeur']->find($professeurId);
            $epreuve->setProfesseur($professeur);

            $langueId = $epreuveForm->get('langue')->getData();
            $langue = $app['dao.langue']->find($langueId);
            $epreuve->setLangue($langue);

            $salleId = $epreuveForm->get('salle')->getData();
            $salle = $app['dao.salle']->find($salleId);
            $epreuve->setSalle($salle);


            $app['dao.epreuve']->save($epreuve);
            $app['session']->getFlashBag()->add('success', 'Votre epreuve a été modifié.');
        }
        $epreuveFormView = $epreuveForm->createView();
        return $app['twig']->render('epreuve_ttchx_edit_results.html.twig', array('epreuveForm' => $epreuveFormView, 'eleve' => $eleve));
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc=" public function searchEpreuveDeleteAction(Application $app, $id)"> 
    /**
     * Displays the form for typeing parameters of searching
     * @param Application $app
     * @return type
     */
    public function searchEpreuveDeleteAction(Application $app) {

        $epreuves = $app['dao.epreuve']->findAll();
        return $app['twig']->render('epreuve_delete.html.twig', array('epreuves' => $epreuves));
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="public function deleteEpreuveAction(Request $request, Application $app, $id)">
    /**
     * Delete article controller.
     *
     * @param integer $id Article id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function deleteEpreuveAction($id, Request $request, Application $app) {
        // Delete the article
        $app['dao.epreuve']->delete($id);
        $app['session']->getFlashBag()->add('success', 'Votre epreuve a été supprimé.');
        return $app->redirect('/admin');
    }

// </editor-fold>
}
