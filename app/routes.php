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
$app->match('/eleves/add/', 'Planning\Controller\EleveController::addAction');

// Editing a eleve
$app->match('/eleves/edit/{id}', 'Planning\Controller\EleveController::editAction');

// Delete a eleve
$app->match('/eleves/delete/{id}','Planning\Controller\EleveController::deleteAction');

//PROFESSEUR///////////////////////////////////////////////////////////////////////////////////////////////////////
// Details for a professeur
$app->get('/professeurs/{id}', 'Planning\Controller\ProfesseurController::detailAction');

// List of all professeurs
$app->get('/professeurs/', 'Planning\Controller\ProfesseurController::listAction');

// Search form for professeurs
$app->get('/professeurs/search/', 'Planning\Controller\ProfesseurController::searchAction');

// Results page for professeurs
$app->post('/professeurs/results/', 'Planning\Controller\ProfesseurController::resultsAction');

//EPREUVE////////////////////////////////////////////////////////////////////////////////////////////////////
// Details for a epreuve
$app->get('/epreuves/{id}', 'Planning\Controller\EpreuveController::detailAction');

// List of all epreuves
$app->get('/epreuves/', 'Planning\Controller\EpreuveController::listAction');

// Search form for epreuves
$app->get('/epreuves/search/', 'Planning\Controller\EpreuveController::searchAction');

// Results page for epreuves
$app->post('/epreuves/results/', 'Planning\Controller\EpreuveController::resultsAction');


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

