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
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'login' => array(
            'pattern' => '^/login$',
            'anonymous' => true
        ),
        'secured' => array(
            'pattern' => '^/',
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => $app->share(function () use ($app) {
                return new Planning\DAO\ProfesseurDAO($app['db']);
            }),
        ),
    ),
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_USER'),
    ),
    'security.access_rules' => array(
        array('^/admin', 'ROLE_ADMIN'),
    ),
));


// Register error handler
use Symfony\Component\HttpFoundation\Response;

$app->error(function (\Exception $e, $code) use ($app) {
    switch ($code) {
        case 403:
            $message = 'Access denied.';
            break;
        case 404:
            $message = 'The requested resource could not be found.';
            break;
        default:
            $message = $e->getMessage();
    }
    return $app['twig']->render('error.html.twig', array('message' => $message));
});

// Register JSON data decoder for JSON requests
use Symfony\Component\HttpFoundation\Request;

$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());


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
    return new Planning\DAO\ProfesseurDAO($app['db']);
});

$app['dao.langue'] = $app->share(function ($app) {
    return new Planning\DAO\LangueDAO($app['db']);
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

