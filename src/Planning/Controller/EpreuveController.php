<?php

namespace Planning\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Planning\Domain\Epreuve;
use Planning\DAO\EpreuveDAO;
use Planning\Form\Type\EpreuveType;

class EpreuveController {

    // <editor-fold defaultstate="collapsed" desc="public function detailAction(Application $app, $id)"> 
    /**
     * Afficher le détail sur une épreuve par l'identifiant
     * 
     * @param Application $app
     * @param type $id
     * @return type
     */
    public function detailAction(Application $app, $id) {
        $epreuve = $app['dao.epreuve']->find($id);
        return $app['twig']->render('epreuve.html.twig', array('title' => 'Détails sur une épreuve', 'epreuve' => $epreuve));
    }
    // </editor-fold>    
    // <editor-fold defaultstate="collapsed" desc="public function listAction(Application $app, $id)"> 
    /**
     * Lister tous les epreuves
     * 
     * @param Application $app
     * @return type
     */
    public function listAction(Application $app) {
        $epreuves = $app['dao.epreuve']->findAll();
        return $app['twig']->render('epreuves.html.twig', array('title' => 'Liste des épreuves', 'epreuves' => $epreuves));
    }

    // </editor-fold>       
    // <editor-fold defaultstate="collapsed" desc="public function searchAction(Application $app, $id)"> 
    /**
     * Afficher le formulaire pour saisir les paramètres de la recherche
     * Rechercher l'un des élèves inscrits ou l'un des professeurs inscrits
     * 
     * @param Application $app
     * @return type
     */
    public function searchAction(Application $app) {
        $eleves = $app['dao.eleve']->findElevesInscrits();
        $professeurs = $app['dao.professeur']->findProfsInscrits();
        return $app['twig']->render('epreuves_search.html.twig', array('title' => 'Recherche une épreuve',
                    'eleves' => $eleves, 'professeurs' => $professeurs));
    }
    // </editor-fold>      
    // <editor-fold defaultstate="collapsed" desc="public function resultsAction(Application $app, $id)"> 
    /**
     * Obtenir le resultat de la recherche effectué par le nom d'un élève ou  
     * le nom d'un professeur ou la date de passage
     * 
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
    // <editor-fold defaultstate="collapsed" desc="public function listeEpreuves(Application $app, $id)"> 
    /**
     * Afficher une liste générée de tous les épreuves avec la session
     * 
     * @param Application $app
     * @return type
     */
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
    // <editor-fold defaultstate="collapsed" desc="public function searchEpreuveClasseAddAction(Application $app, $id)"> 
    /**
     * Afficher le formulaire pour saisir les paramètres de la recherche pour pouvoir ajouter une épreuve 
     * Rechercher l'un des élèves par classe
     * 
     * @param Request $request
     * @param Application $app
     * @param type $datePassage
     * @param type $heurePassageId
     * @return type
     */
    public function searchEpreuveClasseAddAction(Request $request, Application $app, $datePassage, $heurePassageId) {
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
        return $app['twig']->render('epreuve_chxclasse_add.html.twig', array('epreuve' => $epreuve,
                    'classes' => $classes, 'eleves' => $eleves, 'heurepassage' => $heurepassage));
    }

    // </editor-fold>  
    // <editor-fold defaultstate="collapsed" desc="public function searchEpreuveClasseEditAction(Request $request, Application $app, $datePassage, $heurePassageId)"> 
    /**
     * Afficher le formulaire pour saisir les paramètres de la recherche pour pouvoir éditer une épreuve 
     * Rechercher l'un des élèves par classe
     * 
     * @param Request $request
     * @param Application $app
     * @param type $datePassage
     * @param type $heurePassageId
     * @return type
     */
    public function searchEpreuveClasseEditAction(Request $request, Application $app, $datePassage, $heurePassageId) {
        $eleves = null;
        $classes = null;

        $epreuve = $app['dao.epreuve']->findByDateHeurePassage($datePassage, $heurePassageId);
        $heurepassage = $app['dao.heurepassage']->find($heurePassageId);

        $id = $app['session']->get('eleveId');

        $oldEleveId = $id['eleveId'];
        $eleve = $app['dao.eleve']->find($oldEleveId);
        $classeId = $request->request->get('dllClasseEpreuve');

        if ($classeId != $eleve->getClasse()->getId()) { // si eleve est differente de l'ancien classe
            $eleves = $app['dao.eleve']->findAllByClasse($classeId);
            $epreuve->setDatepassage($datePassage);
            $epreuve->setHeurepassage($heurepassage);
            return $app['twig']->render('epreuve_chxclasse_edit.html.twig', array('epreuve' => $epreuve,
                        'classes' => $classes, 'eleves' => $eleves, 'heurepassage' => $heurepassage));
        } else {
            return $app->redirect("/epreuves/results/edit_chxclasse/edit/$datePassage/$heurePassageId/$oldEleveId");
        }
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="public function resultEpreuveClasseEditAction(Application $app, $datePassage, $heurePassageId, $eleveId)"> 
    /**
     * Obtenir le resultat de la recherche effectué pour avoir le nom d'un élève par classe 
     * 
     * @param Request $request
     * @param Application $app
     * @param type $datePassage
     * @param type $heurePassageId
     * @param type $eleveId
     * @return type
     */
    public function resultEpreuveClasseEditAction(Request $request, Application $app, $datePassage, $heurePassageId, $eleveId) {
        $eleves = null;
        $classes = null;

        $epreuve = $app['dao.epreuve']->findByEleveDateHeurePassage($datePassage, $heurePassageId, $eleveId);
        $heurepassage = $app['dao.heurepassage']->find($heurePassageId);

        $app['session']->set('eleveId', array('eleveId' => $eleveId));
        $classes = $app['dao.classe']->findAll();

        return $app['twig']->render('epreuve_chxclasse_edit.html.twig', array('epreuve' => $epreuve,
                    'classes' => $classes, 'eleves' => $eleves, 'heurepassage' => $heurepassage));
    }

    // </editor-fold>  
    // <editor-fold defaultstate="collapsed" desc="public function addAction(Request $request, Application $app, $id)"> 
    /**
     * Ajouter une épreuve sauf la date de passage et horaire sont non modifiable
     * 
     * @param Request $request
     * @param Application $app
     * @param type $datePassage
     * @param type $heurePassageId
     * @param type $eleveId
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
        return $app['twig']->render('epreuve_form.html.twig', array('title' => 'Ajouter une épreuve', 'epreuveForm' => $epreuveFormView,
                    'epreuve' => $epreuve, 'heurepassage' => $heurepassage, 'eleve' => $eleve));
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="public function editAction(Request $request, Application $app, $datePassage, $heurePassageId, $eleveId)"> 
    /**
     * Éditer une épreuve. On peut modifier l'élève, le professeur la classe et la salle
     * mais pas la date et l'heure
     * 
     * @param Request $request
     * @param Application $app
     * @param type $datePassage
     * @param type $heurePassageId
     * @param type $eleveId
     * @return type
     */
    public function editAction(Request $request, Application $app, $datePassage, $heurePassageId, $eleveId) {
        $epreuveFormView = NULL;

        // Lire l'élève qui passe l'épreuve
        $eleve = $app['dao.eleve']->find($eleveId);
        // On vérifie que l'on a pas changé d'élève pour cette épreuve
        // Si l'élève n'est pas le même alors il faut lire l'épreuve en utilisant l'ancien élève
        // puis remettre le nouvel élève (celui dont l'id est passé en paramètre) dans l'épreuve
        // Si l'élève n'a pas changé on lit l'épreuve avec l'élève passé en paramètre
        $id = $app['session']->get('eleveId'); // Récupération de l'élève qui a été sauvegardé en Session
        $oldEleveId = $id['eleveId'];
        if ($eleveId != $oldEleveId) {
            $epreuve = $app['dao.epreuve']->findByEleveDateHeurePassage($datePassage, $heurePassageId, $oldEleveId);
            $epreuve->setEleve($eleve);
        } else {
            $epreuve = $app['dao.epreuve']->findByEleveDateHeurePassage($datePassage, $heurePassageId, $eleveId);
        }
        $professeurId = $epreuve->getProfesseur()->getId();
        $professeurs = $app['dao.professeur']->findProfsNonInscrits($datePassage, $heurePassageId, $professeurId);
        
        $heurepassage = $app['dao.heurepassage']->find($heurePassageId);

        $salles = $app['dao.salle']->findAll();
        $langues = $app['dao.langue']->findAll();

        $epreuveForm = $app['form.factory']->create(new EpreuveType($heurepassage, $eleve, $professeurs, $professeurId, $langues, $epreuve->getLangue()->getId(), $salles, $epreuve->getSalle()->getId()), $epreuve);

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

            // Si l'élève a été changé, il faut supprimer l'épreuve concernant cet élève
            // puis recréer l'épreuve avec le nouvel élève
            // Sinon, il suffit de faire une mise à jour
            if ($eleveId != $oldEleveId) {
                $app['dao.epreuve']->delete($datePassage, $heurePassageId, $oldEleveId);
                $eleve = $app['dao.eleve']->find($eleveId);
                $epreuve->setEleve($eleve);
                $app['dao.epreuve']->insert($epreuve);
            } else {
                $app['dao.epreuve']->update($epreuve);
            }


            // Retour à la recherche des épreuves pour visualiser la modification
            return $this->listeEpreuves($app);
        }
        $epreuveFormView = $epreuveForm->createView();
        return $app['twig']->render('epreuve_form.html.twig', array('title' => 'Modifier une épreuve', 'epreuveForm' => $epreuveFormView,
                    'epreuve' => $epreuve, 'heurepassage' => $heurepassage, 'eleve' => $eleve));
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="public function deleteAction(Request $request, Application $app, $id)">
    /**
     * Supprimer une épreuve par la date de passage et l'identifiant d'une heure de passage et d'un élève
     *
     * @param integer $id Article id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     * @param type $datePassage
     * @param type $heurePassageId
     * @param type $eleveId
     * @return type 
     */
    public function deleteAction(Application $app, $datePassage, $heurePassageId, $eleveId) {
        $app['dao.epreuve']->delete($datePassage, $heurePassageId, $eleveId);
        // Retour à la recherche des épreuves       
        return $this->listeEpreuves($app);
    }

// </editor-fold>
}
