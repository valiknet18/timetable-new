<?php

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.options' => array(
        'cache' => isset($app['twig.options.cache']) ? $app['twig.options.cache'] : false,
        'strict_variables' => true,
        'globals' => array('loginCheckRoute' => 'wXMgt4EB3pG9Jki35t6bpGLJMrkQces6ETTE9fkQ4JM'),
    ),
    'twig.path' => array(__DIR__ . '/views')
));

$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {

    function dummy_trans($str) {
        return $str;
    }

    $twig->addFilter('trans*', new Twig_Filter_Function('dummy_trans'));

    return $twig;
}));
