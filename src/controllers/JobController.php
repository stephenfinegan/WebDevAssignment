<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 29/04/2016
 * Time: 10:53
 */

namespace StephenFinegan\Controllers;


use StephenFinegan\Models\Job;
use StephenFinegan\Models\User;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class JobController {

    public function makeJobAction(Request $request, Application $app)
    {

        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $position = $this->positionFromSession();
        $company = $request->get('company');
        $title = $request->get('position');
        $description = $request->get('description');
        $date = $request->get('date');
        $time = $request->get('time');
        date_default_timezone_set('Europe/Dublin');
        $deadline = strtotime("$date $time");

        $processJob = Job::insertJob($username, $company, $title, $description, $deadline);
        $objects = Job::getOneByUsername($username);
        $everyJob = Job::getAll();

        if ($processJob == null) {
            $worked = "Jod has been successfully added";
        }else{
            $failed = "Unable to add job";
        }
            $templateName = 'account';
            $argsArray = array(
                'title' => 'Account',
                'worked' => $worked,
                'isLoggedIn' =>$isLoggedIn,
                'username'=>$username,
                'position'=>$position,
                'objects'=>$objects,
                'everyJob'=>$everyJob

            );
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    public function deleteJobAction(Request $request, Application $app)
    {

        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $position = $this->positionFromSession();
        $id = $request->get('id');

        $jobs = Job::getOneByUsername($username);
        $everyJob = Job::getAll();
        $deleteJob = Job::removeOneById($id);

        if ($deleteJob == null) {
            $worked = "Jod has been successfully deleted";
        }else{
            $failed = "Unable to delete job";
        }
        $templateName = 'account';
        $argsArray = array(
            'title' => 'Account',
            'worked' => $worked,
            'isLoggedIn' =>$isLoggedIn,
            'username'=>$username,
            'position'=>$position,
            'jobs'=>$jobs,
            'everyJob'=>$everyJob

        );
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    public function isLoggedInFromSession()
    {
        $isLoggedIn = false;

        // user is logged in if there is a 'user' entry in the SESSION superglobal
        if(isset($_SESSION['user'])){
            $isLoggedIn = true;
        }

        return $isLoggedIn;
    }

    public function usernameFromSession()
    {
        $username = '';

        // extract username from SESSION superglobal
        if (isset($_SESSION['user'])) {
            $username = $_SESSION['user'];
        }

        return $username;
    }

    public function positionFromSession()
    {
        if (isset($_SESSION['user'])) {
            $username = $this->usernameFromSession();
            $user = User::getOneByUsername($username);
            $position = $user->getPosition();
        }
        return intval($position);
    }

    public static function error(Application $app, $message, $heading)
    {
        $argsArray = [
            'title' => 'ERROR',
            'errorMessage' => $message,
            'errorHeading' => $heading
        ];
        $templateName = 'error';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
}