<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 13/04/2016
 * Time: 16:31
 */

// autoload classes being used
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . '/config_db.php';
require_once __DIR__ . "/../src/utility/Utility.php";

//twig set up
$myTemplatesPath = __DIR__ . "/../templates";

//silex setup
$app = new Silex\Application();

// register twig with silex
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => $myTemplatesPath
));
