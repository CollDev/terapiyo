<?php

use Silex\Provider\TwigServiceProvider as Twig;
use Silex\Provider\UrlGeneratorServiceProvider as Url;
use Silex\Provider\HttpCacheServiceProvider as Cache;
use Silex\Provider\DoctrineServiceProvider as Doctrine;
use Silex\Provider\SwiftmailerServiceProvider as Swiftmailer;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\HttpFoundation\Request;
use Main\Services\Curso;
use Silex\Provider\SessionServiceProvider as Session;
use Silex\Provider\SecurityServiceProvider as Security;
use Silex\Provider\RememberMeServiceProvider as RememberMe;

$app['debug'] = true;
$app['locale'] = 'es';

$yaml = new Parser();

//Parameters
$parameters = $yaml->parse(file_get_contents(__DIR__ . '/config/parameters.yml'));
$app['doctrine.parameters'] = $parameters;
$app['swiftmailer.options'] = $parameters['mailer'];
//end Parameters

//Settings
$app['settings'] = $yaml->parse(file_get_contents(__DIR__ . '/config/settings.yml'));
//end Settings

//Cache
$app->register(new Cache(), array(
    'http_cache.cache_dir' => __DIR__ . '/cache/',
));
//end Cache

//Doctrine
$app->register(new Doctrine(), array(
    'db.options' => $app['doctrine.parameters']['database'],
));
//end Doctrine

//Swiftmailer
$app->register(new Swiftmailer(), array(
    'swiftmailer.options' => $app['swiftmailer.options'],
));
//end Swiftmailer

//Twig
$app->register(new Twig(), array(
    'twig.path'       => __DIR__ . '/../src/Main/Resources/views/',
    'twig.class_path' => __DIR__ . '/../vendor/twig/twig/lib/'
));
//end Twig

//Security
$app->register(new Session());

$app['security.firewalls'] = array(
    'admin' => array(
        'pattern' => '^/admin',
        'form' => array('login_path' => '/login', 'check_path' => '/admin/login_check'),
        'logout' => array('logout_path' => '/admin/logout'),
        'remember_me' => array(
            'key'                => 'iFyLoZ2Z8QkoCGsYQ8tn8ta8EW',
            'always_remember_me' => true,
        ),
        'users' => array(
            'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
        ),
    ),
);

$app->register(new Security(), $app['security.firewalls']);

$app->register(new RememberMe());

$app['security.role_hierarchy'] = array(
    'ROLE_ADMIN' => array('ROLE_USER', 'ROLE_ALLOWED_TO_SWITCH'),
);

$app['security.access_rules'] = array(
    array('^/admin', 'ROLE_ADMIN'),
    array('^.*$', 'ROLE_USER'),
);
//end Security

//Routing
$app->register(new Url());
//end Routing

//Curso
$app['curso'] = $app->protect(function($nombre) {
    return new Curso($nombre);
});

// _method hidden input enabled
Request::enableHttpMethodParameterOverride();