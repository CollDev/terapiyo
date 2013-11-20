<?php

use Silex\Provider\TwigServiceProvider as Twig;
use Silex\Provider\UrlGeneratorServiceProvider as Url;
use Silex\Provider\HttpCacheServiceProvider as Cache;
use Silex\Provider\DoctrineServiceProvider as Doctrine;
use Symfony\Component\Yaml\Parser as Parser;
use Symfony\Component\HttpFoundation\Request;

$app['debug'] = false;
$app['locale'] = 'es';

//Parameters
$yaml = new Parser();
$app['doctrine.parameters'] = $yaml->parse(file_get_contents(__DIR__ . '/config/parameters.yml'));
//end Parameters

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

//Twig
$app->register(new Twig(), array(
    'twig.path'       => __DIR__ . '/../src/Main/Resources/views/',
    'twig.class_path' => __DIR__ . '/../vendor/twig/twig/lib/'
));
//end Twig

//Routing
$app->register(new Url());
//end Routing

Request::enableHttpMethodParameterOverride();