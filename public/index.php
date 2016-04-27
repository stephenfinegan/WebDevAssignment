<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 13/04/2016
 * Time: 16:56
 */
session_start();
use StephenFinegan\MainController;

require_once __DIR__ . '/../app/setup.php';

$app->get('/', controller('StephenFinegan', 'main/index'));

$app->get('/register', controller('StephenFinegan', 'main/register'));
$app->get('/login', controller('StephenFinegan', 'main/login'));
$app->post('/loginForm', controller('StephenFinegan', 'main/processLogin'));
$app->post('/registerForm', controller('StephenFinegan', 'main/registerUser'));


$app->error(function (\Exception $e, $code) use ($app) {
    switch($code) {
        case 404:
            $heading = 'ERROR';
            $message = 'Requested page could not be found.';
            return \StephenFinegan\MainController::error($app, $message, $heading);
        default:
            $heading = 'ERROR';
            $message = 'Something went wrong.';
            return \StephenFinegan\MainController::error($app, $message, $heading);
    }
});

//run silex controller
//------------------------------
$app->run();
