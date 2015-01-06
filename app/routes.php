<?php

use Symfony\Component\HttpFoundation\Request;

// Home page
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
});

// Details for a eleve
$app->get('/eleves/{id}', function($id) use ($app) {
    $eleve = $app['dao.eleve']->find($id);
    return $app['twig']->render('eleve.html.twig', array('eleve' => $eleve));
});