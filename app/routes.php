<?php

use Symfony\Component\HttpFoundation\Request;

// Home page
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
});


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

//----------------------------------------------------------------------//
//------------------------- Routes for eleves---------------------------//
//----------------------------------------------------------------------//
// Details for a eleve
$app->get('/eleves/{id}', function($id) use ($app) {
    $eleve = $app['dao.eleve']->find($id);
    return $app['twig']->render('eleve.html.twig', array('eleve' => $eleve));
});

// List of all eleves
$app->get('/eleves/', function() use ($app) {
    $eleves = $app['dao.eleve']->findAll();
    return $app['twig']->render('eleves.html.twig', array('eleves' => $eleves));
});

// Search form for eleves
$app->get('/elevessearch/', function() use ($app) {
    $classes = $app['dao.classe']->findAll();
    return $app['twig']->render('eleves_search.html.twig', array('classes' => $classes));
});

// Results page for eleve
$app->post('/eleves/results/', function(Request $request) use ($app) {
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
});

//----------------------------------------------------------------------//
//------------------------- Routes for professeurs----------------------//
//----------------------------------------------------------------------//
// Details for a professeur
$app->get('/professeurs/{id}', function($id) use ($app) {
    $professeur = $app['dao.professeur']->find($id);
    return $app['twig']->render('professeur.html.twig', array('professeur' => $professeur));
});

// List of all professeur
$app->get('/professeurs/', function() use ($app) {
    $professeurs = $app['dao.professeur']->findAll();
    return $app['twig']->render('professeurs.html.twig', array('professeurs' => $professeurs));
});


// Search form for professeurs
$app->get('/professeurssearch/', function() use ($app) {
    $professeurs = $app['dao.professeur']->findAll();
    return $app['twig']->render('professeurs_search.html.twig', array('professeurs' => $professeurs));
});


// Results page for professeurss
$app->post('/professeurs/results/', function(Request $request) use ($app) {
    if ($request->request->has('ddlProfs')) {
// Advanced search by nom
        $ddlProfs = $request->request->get('ddlProfs');
        $professeurs = $app['dao.professeur']->findAllByNom($ddlProfs);
    } else {
        if ($request->request->has('ddlRoles')) {
// Simple search by classe
            $ddlRoles = $request->request->get('ddlRoles');
            $professeurs = $app['dao.professeur']->findAllByRole($ddlRoles);
        }
    }
    return $app['twig']->render('professeurs_results.html.twig', array('professeurs' => $professeurs));
});

//----------------------------------------------------------------------//
//------------------------- Routes for Epreuves-------------------------//
//----------------------------------------------------------------------//
// Details for a epreuve
$app->get('/epreuves/{id}', function($id) use ($app) {
    $epreuve = $app['dao.epreuve']->find($id);
    return $app['twig']->render('epreuve.html.twig', array('epreuve' => $epreuve));
});

// List of all epreuves
$app->get('/epreuves/', function() use ($app) {
    $epreuves = $app['dao.epreuve']->findAll();
    return $app['twig']->render('epreuves.html.twig', array('epreuves' => $epreuves));
});

// Search form for epreuves
$app->get('/epreuvessearch/', function() use ($app) {
    $eleves = $app['dao.eleve']->findAll();
    $professeurs = $app['dao.professeur']->findAll();
    return $app['twig']->render('epreuves_search.html.twig', array('eleves' => $eleves, 'professeurs' => $professeurs));
});


// Results page for epreuves
$app->post('/epreuves/results/', function(Request $request) use ($app) {
    if ($request->request->has('nom')) {
// Advanced search by nom
        $nom = $request->request->get('nom');
        $epreuves = $app['dao.epreuve']->findAllByNom($nom);
    } else {
// Simple search by classe
        $professeurId = $request->request->get('professeur');
        $epreuves = $app['dao.epreuve']->findAllByProfesseur($professeurId);
    }
    return $app['twig']->render('epreuves_results.html.twig', array('epreuves' => $epreuves));
});
