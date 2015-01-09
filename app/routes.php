<?php

use Symfony\Component\HttpFoundation\Request;
use Planning\Domain\Eleve;
use Planning\Domain\Classe;

// Home page
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
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
    if ($request->request->has('nom')) {
// Advanced search by nom
        $nom = $request->request->get('nom');
        $eleves = $app['dao.eleve']->findAllByNom($nom);
    } else {
// Simple search by classe
        $classeId = $request->request->get('classe');
        $eleves = $app['dao.eleve']->findAllByClasse($classeId);
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
    $roles = $app['dao.role']->findAll();
    return $app['twig']->render('professeurs_search.html.twig', array('roles' => $roles));
});


// Results page for professeurss
$app->post('/professeurs/results/', function(Request $request) use ($app) {
    if ($request->request->has('nom')) {
// Advanced search by nom
        $nom = $request->request->get('nom');
        $professeurs = $app['dao.professeur']->findAllByNom($nom);
    } else {
// Simple search by classe
        $roleId = $request->request->get('role');
        $professeurs = $app['dao.professeur']->findAllByRole($roleId);
    }
    return $app['twig']->render('professeurs_results.html.twig', array('professeurs' => $professeurs));
});

//----------------------------------------------------------------------//
//------------------------- Routes for Epreuves-------------------------//
//----------------------------------------------------------------------//
// Details for a epreuve
$app->get('/epreuves/{id}', function($id) use ($app) {
    $epreuve= $app['dao.epreuve']->find($id);
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