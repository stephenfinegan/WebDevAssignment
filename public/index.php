<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 13/04/2016
 * Time: 16:56
 */
session_start();
use StephenFinegan\Controllers\MainController;

require_once __DIR__ . '/../app/setup.php';

//routes for all links
$app->get('/', controller('StephenFinegan\Controllers', 'main/index'));

$app->get('/register', controller('StephenFinegan\Controllers', 'main/register'));
$app->get('/login', controller('StephenFinegan\Controllers', 'main/login'));
$app->get('/logout', controller('StephenFinegan\Controllers', 'main/logout'));
$app->get('/account', controller('StephenFinegan\Controllers', 'main/account'));
$app->get('/jobs', controller('StephenFinegan\Controllers', 'main/jobs'));
$app->get('/students', controller('StephenFinegan\Controllers', 'main/student'));

$app->post('/loginForm', controller('StephenFinegan\Controllers', 'main/processLogin'));
$app->post('/registerForm', controller('StephenFinegan\Controllers', 'main/registerUser'));
$app->post('/jobForm', controller('StephenFinegan\Controllers', 'job/makeJob'));
$app->post('/deleteJob', controller('StephenFinegan\Controllers', 'job/deleteJob'));
$app->post('/acceptJob', controller('StephenFinegan\Controllers', 'job/acceptJob'));
$app->post('/apply', controller('StephenFinegan\Controllers', 'job/apply'));
$app->post('/processCVForm', controller('StephenFinegan\Controllers', 'cv/processCV'));



$app->error(function (\Exception $e, $code) use ($app) {
    switch ($code) {
        case 404:
            $heading = 'ERROR';
            $message = 'Requested page could not be found.';
            return \StephenFinegan\Controllers\MainController::error($app, $message, $heading);
        default:
            $heading = 'ERROR';
            $message = 'Something went wrong.';
            return \StephenFinegan\Controllers\MainController::error($app, $message, $heading);
    }
});

//run silex controller
//------------------------------
$app->run();
