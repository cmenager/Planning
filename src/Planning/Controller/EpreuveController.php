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
        return $app['twig']->render('epreuve.html.twig', array('title' => 'Détails sur un épreuve', 'epreuve' => $epreuve));
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
        return $app['twig']->render('epreuves.html.twig', array('title' => 'Liste des épreuves', 'epreuves' => $epreuves));
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
        $eleves = $app['dao.eleve']->findElevesInscrits();
        $professeurs = $app['dao.professeur']->findProfsInscrits();
        return $app['twig']->render('epreuves_search.html.twig', array('title' => 'Recherche un épreuve',
                    'eleves' => $eleves, 'professeurs' => $professeurs));
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
        // On stocke dans la session le moyen utilisé pour obtenir la liste
        $app['session']->set('acces', array('datePassage' => "null", 'professeurId' => "null", 'eleveId' => "null"));
        if ($request->request->has('ddlNomEleveEp')) {
            $eleveId = $request->request->get('ddlNomEleveEp');
            $epreuves = $app['dao.epreuve']->findAllByIdEleve($eleveId);
            $app['session']->set('acces', array('datePassage' => "null", 'professeurId' => "null", 'eleveId' => $eleveId));
        } else {
            if ($request->request->has('ddlNomProfesseurEp')) {
                $professeurId = $request->request->get('ddlNomProfesseurEp');
                $epreuves = $app['dao.epreuve']->findAllByIdProfesseur($professeurId);
                $app['session']->set('acces', array('professeurId' => $professeurId, 'datePassage' => "null", 'eleveId' => "null"));
            } else {
                if ($request->request->has('date_passage')) {
                    $datePassage = $request->request->get('date_passage');
                    $epreuves = $app['dao.epreuve']->findPlanningByDate($datePassage);
                    $app['session']->set('acces', array('datePassage' => $datePassage, 'professeurId' => "null", 'eleveId' => "null"));
                }
            }
        }
        return $app['twig']->render('epreuves_results.html.twig', array('title' => 'Resultat de la recherche',
                    'epreuves' => $epreuves));
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc=" public function listeEpreuves(Application $app, $id)"> 
    public function listeEpreuves(Application $app) {
        $epreuves = null;
        // On récupère le moyen qui avait été utilisé pour fournir la liste
        // cela permettra de relancer la génération de cette liste
        $acces = $app['session']->get('acces');
        if ($acces['eleveId'] != "null") {
            $epreuves = $app['dao.epreuve']->findAllByIdEleve($acces['eleveId']);
        } else {
            if ($acces['professeurId'] != "null") {
                $epreuves = $app['dao.epreuve']->findAllByIdProfesseur($acces['professeurId']);
            } else {
                if ($acces['datePassage'] != "null") {
                    $epreuves = $app['dao.epreuve']->findPlanningByDate($acces['datePassage']);
                }
            }
        }
        $app['session']->remove('acces');
        return $app['twig']->render('epreuves_results.html.twig', array('title' => 'Resultat de la recherche',
                    'epreuves' => $epreuves));
    }

// </editor-fold> 
    // <editor-fold defaultstate="collapsed" desc=" public function searchEpreuveClasseAction(Application $app, $id)"> 
    public function searchEpreuveClasseAction(Request $request, Application $app, $datePassage, $heurePassageId) {
        $eleves = null;
        $classes = null;
        $epreuve = $app['dao.epreuve']->findByDateHeurePassage($datePassage, $heurePassageId);
        $heurepassage = $app['dao.heurepassage']->find($heurePassageId);


        if ($request->request->has('dllClasseEpreuve')) {
            $classeId = $request->request->get('dllClasseEpreuve');
            $eleves = $app['dao.eleve']->findAllByClasse($classeId);
            $epreuve->setDatepassage($datePassage);
            $epreuve->setHeurepassage($heurepassage);
        } else {
            $classes = $app['dao.classe']->findAll();
            $epreuve->setDatepassage($datePassage);
            $epreuve->setHeurepassage($heurepassage);
        }
        return $app['twig']->render('epreuve_chxclasse_search.html.twig', array('epreuve' => $epreuve,
                    'classes' => $classes, 'eleves' => $eleves, 'heurepassage' => $heurepassage));
    }

// 
// // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="public function addAction(Request $request, Application $app, $id)"> 
    /**
     * Adds a Report
     * @param Request $request
     * @param Application $app
     * @return type
     */
    public function addAction(Request $request, Application $app, $datePassage, $heurePassageId, $eleveId) {
        $epreuveFormView = NULL;
        $epreuve = new Epreuve();

        $epreuve->setDatepassage($datePassage);
        $heurepassage = $app['dao.heurepassage']->find($heurePassageId);

        $eleve = $app['dao.eleve']->find($eleveId);

        $professeurs = $app['dao.professeur']->findProfsNonInscrits($datePassage, $heurePassageId, null);
        $professeur = current($professeurs);
        $professeurId = $professeur->getId();

        $salles = $app['dao.salle']->findSalleNonUtilisees($datePassage, $heurePassageId);
        $salle = current($salles);
        $salleId = $salle->getId();

        $langues = $app['dao.langue']->findAll();
        $langue = current($langues);
        $langueId = $langue->getId();

        $epreuveForm = $app['form.factory']->create(new EpreuveType($heurepassage, $eleve, $professeurs, $professeurId, $langues, $langueId, $salles, $salleId), $epreuve);
        $epreuveForm->handleRequest($request);
        if ($epreuveForm->isValid()) {

            $epreuve->setDatepassage($datePassage);

            $heure = $app['dao.heurepassage']->find($heurePassageId);
            $epreuve->setHeurepassage($heure);

            $eleve = $app['dao.eleve']->find($eleveId);
            $epreuve->setEleve($eleve);

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
            // Retour à la recherche des épreuves
            return $this->listeEpreuves($app);
        }
        $epreuveFormView = $epreuveForm->createView();
        return $app['twig']->render('epreuve_form.html.twig', array('title' => 'Ajouter un épreuve', 'epreuveForm' => $epreuveFormView,
                    'epreuve' => $epreuve, 'heurepassage' => $heurepassage, 'eleve'=>$eleve));
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="public function editAction(Request $request, Application $app, $id)"> 
    /**
     * Updates a Report
     * @param Request $request
     * @param Application $app
     * @param type $eleveId
     * @return type
     */
    public function editAction(Request $request, Application $app, $datePassage, $heurePassageId, $eleveId) {
        $epreuveFormView = NULL;

        $epreuve = $app['dao.epreuve']->findByEleveDateHeurePassage($datePassage, $heurePassageId, $eleveId);
        $heurepassage = $app['dao.heurepassage']->find($heurePassageId);

        $eleve = $app['dao.eleve']->find($eleveId);
        
        $professeurs = $app['dao.professeur']->findProfsNonInscrits($datePassage, $heurePassageId, $epreuve->getProfesseur()->getId());
        $salles = $app['dao.salle']->findAll();
        $langues = $app['dao.langue']->findAll();

        $epreuveForm = $app['form.factory']->create(new EpreuveType($heurepassage, $eleve, $professeurs, $epreuve->getProfesseur()->getId(), $langues, $epreuve->getLangue()->getId(), $salles, $epreuve->getSalle()->getId()), $epreuve);

        $epreuveForm->handleRequest($request);
        if ($epreuveForm->isValid()) {

            $epreuve->setDatepassage($datePassage);

            $heure = $app['dao.heurepassage']->find($heurePassageId);
            $epreuve->setHeurepassage($heure);

           
            $eleve = $app['dao.eleve']->find($eleveId);
            $epreuve->setEleve($eleve);

            $professeurId = $epreuveForm->get('professeur')->getData();
            $professeur = $app['dao.professeur']->find($professeurId);
            $epreuve->setProfesseur($professeur);

            $langueId = $epreuveForm->get('langue')->getData();
            $langue = $app['dao.langue']->find($langueId);
            $epreuve->setLangue($langue);

            $salleId = $epreuveForm->get('salle')->getData();
            $salle = $app['dao.salle']->find($salleId);
            $epreuve->setSalle($salle);

            $app['dao.epreuve']->update($epreuve);

            // Retour à la recherche des épreuves
            return $this->listeEpreuves($app);
        }
        $epreuveFormView = $epreuveForm->createView();
        return $app['twig']->render('epreuve_form.html.twig', array('title' => 'Modifier un épreuve', 'epreuveForm' => $epreuveFormView,
                    'epreuve' => $epreuve, 'heurepassage' => $heurepassage,'eleve' => $eleve ));
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="public function deleteAction(Request $request, Application $app, $id)">
    /**
     * Delete article controller.
     *
     * @param integer $id Article id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function deleteAction(Application $app, $datePassage, $heurePassageId, $eleveId) {
        $app['dao.epreuve']->delete($datePassage, $heurePassageId, $eleveId);
        // Retour à la recherche des épreuves
        return $this->listeEpreuves($app);
//        return $this->searchAction($app);
    }

// </editor-fold>
}
