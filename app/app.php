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



