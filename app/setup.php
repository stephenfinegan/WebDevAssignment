<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 13/04/2016
 * Time: 16:31
 */
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . '/config_db.php';
require_once __DIR__ . "/../src/Utility.php";

$myTemplatesPath = __DIR__ . "/../templates";

$loader = new Twig_Loader_Filesystem($myTemplatesPath);

$twig = new Twig_Environment($loader);

$app = new Silex\Application();
$app['debug']=true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => $myTemplatesPath
));