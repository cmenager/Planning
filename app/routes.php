<?php

use Symfony\Component\HttpFoundation\Request;
use Planning\Form\Type\EleveType;
use Planning\Domain\Eleve;
use PLanning\Domain\professeur;

// Home page
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
});

//ELEVE///////////////////////////////////////////////////////////////////////////////////////////////////
// Details for a eleve
$app->get('/eleves/{id}', 'Planning\Controller\EleveController::detailAction');

// List of all eleves
$app->get('/eleves/', 'Planning\Controller\EleveController::listAction');

// Search form for eleves
$app->get('/eleves/search/', 'Planning\Controller\EleveController::searchAction');

// Results page for eleves
$app->post('/eleves/results/', 'Planning\Controller\EleveController::resultsAction');

// New eleve
$app->match('/admin/eleves/add', 'Planning\Controller\EleveController::addAction');

// Editing a eleve
$app->match('/admin/eleves/edit/{id}', 'Planning\Controller\EleveController::editAction');

// Remove an eleve
$app->get('/admin/eleves/delete/{id}', "Planning\Controller\EleveController::deleteEleveAction");

//PROFESSEUR///////////////////////////////////////////////////////////////////////////////////////////////////////
// Details for a professeur
$app->get('/professeurs/{id}', 'Planning\Controller\ProfesseurController::detailAction');

// List of all professeurs
$app->get('/professeurs/', 'Planning\Controller\ProfesseurController::listAction');

// Search form for professeurs
$app->get('/professeurs/search/', 'Planning\Controller\ProfesseurController::searchAction');

// Results page for professeurs
$app->post('/professeurs/results/', 'Planning\Controller\ProfesseurController::resultsAction');

// New professeurs
$app->match('/admin/professeurs/add', 'Planning\Controller\ProfesseurController::addAction');

// Editing a professeurs
$app->match('/admin/professeurs/edit/{id}', 'Planning\Controller\ProfesseurController::editAction');

// Remove an professeurs
$app->get('/admin/professeurs/delete/{id}', "Planning\Controller\ProfesseurController::deleteProfesseurAction");

//EPREUVE////////////////////////////////////////////////////////////////////////////////////////////////////
// Details for a epreuve
$app->get('/epreuves/{id}', 'Planning\Controller\EpreuveController::detailAction');

// List of all epreuves
$app->get('/epreuves/', 'Planning\Controller\EpreuveController::listAction');

// Search form for epreuves
$app->get('/epreuves/search/', 'Planning\Controller\EpreuveController::searchAction');

// Results page for epreuves
$app->post('/epreuves/results/', 'Planning\Controller\EpreuveController::resultsAction');

// New epreuves
$app->match('/admin/epreuves/add', 'Planning\Controller\EpreuveController::addAction');

// Editing a epreuves
$app->match('/admin/epreuves/edit/{id}', 'Planning\Controller\EpreuveController::editAction');

// Remove an epreuves
$app->get('/admin/epreuves/delete/{id}', "Planning\Controller\EpreuveController::deleteEpreuveAction");


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
    $epreuves = $app['dao.epreuve']->findAll();
    return $app['twig']->render('admin.html.twig', array(
                'eleves' => $eleves,
                'professeurs' => $professeurs,
                'epreuves' => $epreuves));
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
    return $app['twig']->render('professeur.html.twig', array('professeurForm' => $professeurFormView,));
});


