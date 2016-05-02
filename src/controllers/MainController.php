<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 13/04/2016
 * Time: 17:10
 */

/**
 * namespace for main controller
 */
namespace StephenFinegan\controllers;

use StephenFinegan\Models\User;
use StephenFinegan\Models\Job;
use StephenFinegan\Models\Applicants;
use StephenFinegan\Models\CV;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MainController
 * @package StephenFinegan\controllers
 */
class MainController
{

    /**
     * sends user to index page
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function indexAction(Request $request, Application $app)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $argsArray = [
            'successMessage'=>'',
            'title' => 'Home',
            'isLoggedIn' => $isLoggedIn,
            'username' => $username
        ];

        // template for index page
        $templateName = 'index';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * sends user to register page
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function registerAction(Request $request, Application $app)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $argsArray = [
            'title' => 'Register',
            'isLoggedIn' => $isLoggedIn,
            'username' => $username
        ];
        // template for register page
        $templateName = 'register';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * sends user to login page
     * @param Application $app
     * @return mixed
     */
    public function loginAction(Application $app)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $argsArray = [
            'title' => 'Login',
            'isLoggedIn' => $isLoggedIn
        ];
        // template for login page
        $templateName = 'login';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * sends user to the jobs page
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function jobsAction(Request $request, Application $app)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $position = $this->positionFromSession();

        $allJobs = Job::getAll();

        $templateName = 'jobs';
        $argsArray = array(
            'title' => "List of jobs",
            'jobs' => $allJobs,
            'isLoggedIn' => $isLoggedIn,
            'username' => $username,
            'position' => $position
        );
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * sending user to the student page
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function studentAction(Request $request, Application $app)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();

        $allCVS = CV::getAll();

        $templateName = 'studentCVS';
        $argsArray = array(
            'title' => "List of student cvs",
            'isLoggedIn' => $isLoggedIn,
            'username' => $username,
            'cvs' => $allCVS
        );
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * sending user to the account page
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function accountAction(Request $request, Application $app)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $position = $this->positionFromSession();

        $allJobs = Job::getAll();
        $allCVS = CV::getAll();
        $allSampleCVS = CV::getAllSampleCVS();

        $argsArray = [
            'title' => 'Account',
            'jobs' => $allJobs,
            'samplecvs' => $allSampleCVS,
            'cvs' => $allCVS,
            'isLoggedIn' => $isLoggedIn,
            'username' => $username,
            'position' => $position
        ];

        // template for index page
        $templateName = 'account';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * sending user to the logout page
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function logoutAction(Request $request, Application $app)
    {
        // logout user
        unset($_SESSION['user']);

        $argsArray = array(
            'title' => 'Home page',
        );

        // render (draw) template
        // ------------
        $templateName = 'index';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * processing the login
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processLoginAction(Request $request, Application $app)
    {
        $username = $request->get('username');
        $hashedPassword = $request->get('hashedPassword');

       // search for user with username in repository
       $isLoggedIn = User::canFindMatchingUsernameAndPassword($username, $hashedPassword);

       // action depending on login success
       if ($isLoggedIn) {
           // STORE login status SESSION
           $_SESSION['user'] = $username;

           $templateName ='loginSuccess';
           $argsArray = array(
               'title' => 'Login successful',
               'isLoggedIn' => $isLoggedIn,
               'username' => $username,
               'successMessage' => "You successfully logged in as $username"
              );

           return $app['twig']->render($templateName . '.html.twig', $argsArray);
       } else {
           $templateName = 'login';

           $argsArray = array(
               'title' => 'Login',
               'isLoggedIn' => $isLoggedIn,
               'message' => 'unsuccessful, please try again'
           );

           return $app['twig']->render($templateName . '.html.twig', $argsArray);
       }
    }

    /**
     * processing the register of user
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function registerUserAction(Request $request, Application $app)
    {
        $firstname = $request->get('firstname');
        $surname = $request->get('surname');
        $username = $request->get('username');
        $hashedPassword = $request->get('hashedPassword');
        $position = $request->get('position');

        if ($position == '1') {
            $makePosition = User::POSITION_1;
        } elseif ($position == '2') {
            $makePosition = User::POSITION_2;
        } else {
            $makePosition = User::POSITION_3;
        }

        User::insert($firstname, $surname, $username, $hashedPassword, $makePosition);

        $templateName = 'index';
        $argsArray = [
            'title' => 'Home',
            'message' => 'login here',
            'username' => $username,
            'isLoggedIn' => $this->isLoggedInFromSession(),
            'successMessage' =>"You successfully registered as $username"
        ];

        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * returning if the user is logged in
     * @return bool
     */
    public function isLoggedInFromSession()
    {
        $isLoggedIn = false;

        // user is logged in if there is a 'user' entry in the SESSION superglobal
        if (isset($_SESSION['user'])) {
            $isLoggedIn = true;
        }

        return $isLoggedIn;
    }

    /**
     * returns the username of the user
     * @return string
     */
    public function usernameFromSession()
    {
        $username = '';

        // extract username from SESSION superglobal
        if (isset($_SESSION['user'])) {
            $username = $_SESSION['user'];
        }

        return $username;
    }

    /**
     * returns the position of the user
     * @return int
     */
    public function positionFromSession()
    {
        if (isset($_SESSION['user'])) {
            $username = $this->usernameFromSession();
            $user = User::getOneByUsername($username);
            $position = $user->getPosition();
        }
        return intval($position);
    }

    /**
     * sending user to error page if error is found
     * @param Application $app
     * @param $message
     * @param $heading
     * @return mixed
     */
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
