<?php

namespace Planning\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Planning\Domain\Professeur;
use Planning\DAO\ProfesseurDAO;
use Planning\Form\Type\ProfesseurType;

class ProfesseurController {

    /**
     * Afficher le détail sur une professeur par l'identifiant
     * 
     * @param Application $app
     * @param type $id
     * @return type
     */
    public function detailAction(Application $app, $id) {
        $professeur = $app['dao.professeur']->find($id);
        return $app['twig']->render('professeur.html.twig', array('title' => 'Détail sur un professeur', 'professeur' => $professeur));
    }

    /**
     * Lister tous les professseurs
     * 
     * @param Application $app
     * @return type
     */
    public function listAction(Application $app) {
        $professeurs = $app['dao.professeur']->findAll();
        return $app['twig']->render('professeurs.html.twig', array('title' => 'Liste des professeurs', 'professeurs' => $professeurs));
    }

    /**
     * Afficher le formulaire pour saisir les paramètres de la recherche
     * Rechercher l'un des rôle de professurs ou l'un des professeurs
     * 
     * @param Application $app
     * @return type
     */
    public function searchAction(Application $app) {
        $roles = array('ROLE_USER' => 'ROLE_USER', 'ROLE_ADMIN' => 'ROLE_ADMIN');
        $professeurs = $app['dao.professeur']->findAll();
        return $app['twig']->render('professeurs_search.html.twig', array('title' => 'Recherche un professeur', 'roles' => $roles, 'professeurs' => $professeurs));
    }

    
    /**
     * Obtenir le resultat de la recherche effectué par le nom d'un professeur ou l'un des rôles
     * 
     * @param Request $request
     * @param Application $app
     * @return type
     */
    public function resultsAction(Request $request, Application $app) {
        if ($request->request->has('ddlProfs')) {
            $ddlProfs = $request->request->get('ddlProfs');
            $professeurs = $app['dao.professeur']->findAllByNom($ddlProfs);
        } else {
            if ($request->request->has('ddlRoles')) {
                $ddlRoles = $request->request->get('ddlRoles');
                $professeurs = $app['dao.professeur']->findAllByRole($ddlRoles);
            }
        }
        return $app['twig']->render('professeurs_results.html.twig', array('title' => 'Resultat de la recherche', 'professeurs' => $professeurs));
    }
    
    /**
     * Ajouter un professeur
     * 
     * @param Request $request
     * @param Application $app
     * @return type
     */
    public function addAction(Request $request, Application $app) {
        $professeurFormView = NULL;
        $professeur = new Professeur();
        $professeurForm = $app['form.factory']->create(new ProfesseurType(), $professeur);
        $professeurForm->handleRequest($request);
        if ($professeurForm->isValid()) {
            // Manually affect classe to the new visit report
            $app['dao.professeur']->save($professeur);
            $app['session']->getFlashBag()->add('success', 'Un professeur a été ajouté.');
        }
        $professeurFormView = $professeurForm->createView();
        return $app['twig']->render('professeur_form.html.twig', array('title' => 'Ajouter un professeur', 'professeurForm' => $professeurFormView));
    }

    /**
     * Éditer un professeur par 'identifiant
     * 
     * @param Request $request
     * @param Application $app
     * @param type $id
     * @return type
     */
    public function editAction(Request $request, Application $app, $id) {
        $professeurFormView = NULL;
        $professeur = $app['dao.professeur']->find($id);
        // When editing we need to assign the good classe in the dropdown list
        $professeurForm = $app['form.factory']->create(new ProfesseurType, $professeur);
        $professeurForm->handleRequest($request);
        if ($professeurForm->isValid()) {
            // Manually affect classe to the new visit report
            $app['dao.professeur']->save($professeur);
            $app['session']->getFlashBag()->add('success', 'Un professeur a été modifié avec succès .');
        }
        $professeurFormView = $professeurForm->createView();
        return $app['twig']->render('professeur_form.html.twig', array('title' => 'Modifier un professeur', 'professeurForm' => $professeurFormView));
    }

    /**
     * Supprimer un professeur par l'identifiant
     *
     * @param integer $id Article id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function deleteProfesseurAction($id, Request $request, Application $app) {
        // Delete the article
        $app['dao.professeur']->delete($id);
        $app['session']->getFlashBag()->add('success', 'Le professeur a été supprimé.');
        return $app->redirect('/admin');
    }

    

    /**
     * Éditer le profil d'un professeur par l'identifiant
     * 
     * @param Request $request
     * @param Application $app
     * @return type
     */
    public function profilAction(Request $request, Application $app) {
        $professeur = $app['security']->getToken()->getUser();
        $professeurFormView = NULL;
        $professeurForm = $app['form.factory']->create(new ProfesseurType(), $professeur);
        $professeurForm->handleRequest($request);
        if ($professeurForm->isValid()) {
            $plainPassword = $professeur->getPassword();
            // find the encoder for a UserInterface instance
            $encoder = $app['security.encoder_factory']->getEncoder($professeur);
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $professeur->getSalt());
            $professeur->setPassword($password);
            $app['dao.professeur']->save($professeur);
            $app['session']->getFlashBag()->add('success', 'Vos informations personnelles ont été mises à jour.');
        }
        $professeurFormView = $professeurForm->createView();
        return $app['twig']->render('professeur_form.html.twig', array('title'=>'Profil','professeurForm' => $professeurFormView,));
    }

}
