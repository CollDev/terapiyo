<?php

use Silex\Provider\TwigServiceProvider as Twig;
use Silex\Provider\UrlGeneratorServiceProvider as Url;
use Silex\Provider\HttpCacheServiceProvider as Cache;
use Silex\Provider\DoctrineServiceProvider as Doctrine;
use Silex\Provider\SwiftmailerServiceProvider as Swiftmailer;
use Symfony\Component\Yaml\Parser as Parser;
use Symfony\Component\HttpFoundation\Request;

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

//Routing
$app->register(new Url());
//end Routing

// _method hidden input enabled
Request::enableHttpMethodParameterOverride();