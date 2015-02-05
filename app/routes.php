<?php

use Symfony\Component\HttpFoundation\Request;
use Planning\Form\Type\ProfesseurType;
use Planning\Domain\Eleve;
use Planning\Domain\Professeur;

// Home page
$app->match('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
});

//ELEVE///////////////////////////////////////////////////////////////////////////////////////////////////
// Details for a eleve
$app->match('/eleves/{id}', 'Planning\Controller\EleveController::detailAction');

// List of all eleves
$app->match('/eleves/', 'Planning\Controller\EleveController::listAction');

// Search form for eleves
$app->match('/eleves/search/', 'Planning\Controller\EleveController::searchAction');

// Results page for eleves
$app->match('/eleves/results/', 'Planning\Controller\EleveController::resultsAction');

// New eleve
$app->match('/admin/eleves/add', 'Planning\Controller\EleveController::addAction');

// Editing a eleve
$app->match('/admin/eleves/edit/{id}', 'Planning\Controller\EleveController::editAction');

// Remove an eleve
$app->match('/admin/eleves/delete/{id}', "Planning\Controller\EleveController::deleteEleveAction");








//PROFESSEUR///////////////////////////////////////////////////////////////////////////////////////////////////////
// Details for a professeur
$app->match('/professeurs/{id}', 'Planning\Controller\ProfesseurController::detailAction');

// List of all professeurs
$app->match('/professeurs/', 'Planning\Controller\ProfesseurController::listAction');

// Search form for professeurs
$app->match('/professeurs/search/', 'Planning\Controller\ProfesseurController::searchAction');

// Results page for professeurs
$app->match('/professeurs/results/', 'Planning\Controller\ProfesseurController::resultsAction');

// New professeurs
$app->match('/admin/professeurs/add', 'Planning\Controller\ProfesseurController::addAction');

// Editing a professeurs
$app->match('/admin/professeurs/edit/{id}', 'Planning\Controller\ProfesseurController::editAction');

// Remove an professeurs
$app->match('/admin/professeurs/delete/{id}', "Planning\Controller\ProfesseurController::deleteProfesseurAction");






//EPREUVE////////////////////////////////////////////////////////////////////////////////////////////////////
// Details for a epreuve
$app->match('/epreuves/{id}', 'Planning\Controller\EpreuveController::detailAction');

// List of all epreuves
$app->match('/epreuves/', 'Planning\Controller\EpreuveController::listAction');

// Search form for epreuves
$app->match('/epreuves/search/', 'Planning\Controller\EpreuveController::searchAction');

// Results page for epreuves
$app->match('/epreuves/results/', 'Planning\Controller\EpreuveController::resultsAction');

// New epreuves 
$app->match('/epreuves/results/add_chxclasse/{datePassage}/{heurePassageId}', 'Planning\Controller\EpreuveController::searchEpreuveClasseAction');
$app->match('/epreuves/results/add_chxclasse/add/{datePassage}/{heurePassageId}/{eleveId}', 'Planning\Controller\EpreuveController::addAction');

// Editing a épreuve
$app->match('/epreuves/edit/{datePassage}/{heurePassageId}/{eleveId}', 'Planning\Controller\EpreuveController::editAction');

//Remove a épreuve
$app->match('/epreuves/delete/{datePassage}/{heurePassageId}/{eleveId}', "Planning\Controller\EpreuveController::deleteAction");


// Login form
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
                'error' => $app['security.last_error']($request),
                'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');  // named route so that path('login') works in Twig templates 
// Admin zone
$app->get('/admin', function() use ($app) {
    $eleves = $app['dao.eleve']->findAll();
    $professeurs = $app['dao.professeur']->findAll();
    return $app['twig']->render('admin.html.twig', array(
                'eleves' => $eleves,
                'professeurs' => $professeurs));
});

// Personal info
$app->match('/profil', function(Request $request) use ($app) {
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
    return $app['twig']->render('professeur_form.html.twig', array('professeurForm' => $professeurFormView,));
});


