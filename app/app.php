<?php

// Register global error and exception handlers
use Symfony\Component\Debug\ErrorHandler;

ErrorHandler::register();

use Symfony\Component\Debug\ExceptionHandler;

ExceptionHandler::register();
// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
));
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());


// Register services.
$app['dao.eleve'] = $app->share(function ($app) {
    $eleveDAO = new Planning\DAO\EleveDAO($app['db']);
    $eleveDAO->setClasseDAO($app['dao.classe']);
    return $eleveDAO;
});
$app['dao.classe'] = $app->share(function ($app) {
    return new Planning\DAO\ClasseDAO($app['db']);
});


$app['dao.professeur'] = $app->share(function ($app) {
    $professeurDAO = new Planning\DAO\ProfesseurDAO($app['db']);
    $professeurDAO->setRoleDAO($app['dao.role']);
    return $professeurDAO;
});
$app['dao.role'] = $app->share(function ($app) {
    return new Planning\DAO\RoleDAO($app['db']);
});



$app['dao.langue'] = $app->share(function ($app) {
    $langueDAO = new Planning\DAO\LangueDAO($app['db']);
    $langueDAO->setTypeDAO($app['dao.type']);
    return $langueDAO;
});
$app['dao.type'] = $app->share(function ($app) {
    return new Planning\DAO\TypeDAO($app['db']);
});

$app['dao.salle'] = $app->share(function ($app) {
    return new Planning\DAO\SalleDAO($app['db']);
});


$app['dao.heurepassage'] = $app->share(function ($app) {
    return new Planning\DAO\HeurepassageDAO($app['db']);
});

$app['dao.epreuve'] = $app->share(function ($app) {
    $epreuveDAO = new Planning\DAO\EpreuveDAO($app['db']);
    $epreuveDAO->setEleveDAO($app['dao.eleve']);
    $epreuveDAO->setHeurepassageDAO($app['dao.heurepassage']);
    $epreuveDAO->setLangueDAO($app['dao.langue']);
    $epreuveDAO->setProfesseurDAO($app['dao.professeur']);
    $epreuveDAO->setSalleDAO($app['dao.salle']);
    return $epreuveDAO;
});

$app['dao.enseigne'] = $app->share(function ($app) {
    $enseigneDAO = new Planning\DAO\EnseigneDAO($app['db']);
    $enseigneDAO->setEleveDAO($app['dao.eleve']);
    $enseigneDAO->setLangueDAO($app['dao.langue']);
    $enseigneDAO->setProfesseurDAO($app['dao.professeur']);
    return $enseigneDAO;
});