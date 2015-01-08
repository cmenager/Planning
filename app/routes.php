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
$app->get('/eleves/search/', function() use ($app) {
    $classes = $app['dao.classe']->findAll();
    return $app['twig']->render('eleves_search.html.twig', array('classes' => $classes));
});

// Results page for eleve
$app->post('/eleves/results/', function(Request $request) use ($app) {
    $classeId = $request->request->get('classe');
    $eleves = $app['dao.eleve']->findAllByClasse($classeId);
    return $app['twig']->render('eleves_results.html.twig', array('eleves' => $eleves));
});

//----------------------------------------------------------------------//
//------------------------- Routes for professeurs---------------------------//
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

