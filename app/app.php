<?php
use Symfony\Component\HttpFoundation\Request;
// Register global error and exception handlers
use Symfony\Component\Debug\ErrorHandler;

ErrorHandler::register();

use Symfony\Component\Debug\ExceptionHandler;

$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());

ExceptionHandler::register();
// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
));

// Register services.
$app['dao.eleve'] = $app->share(function ($app) {
    return new Planning\DAO\EleveDAO($app['db']);
});
