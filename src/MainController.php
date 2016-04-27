<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 13/04/2016
 * Time: 17:10
 */

namespace StephenFinegan;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class MainController
{

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

    public function registerAction(Request $request, Application $app){
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

    public function loginAction(Request $request, Application $app){
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();

        $argsArray = [
            'title' => 'Login',
            'isLoggedIn' => $isLoggedIn,
            'username' => $username
        ];
        // template for login page
        $templateName = 'login';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
   public function processLoginAction(Request $request, Application $app){
       $username = $request->get('username');
       $password = $request->get('password');

       // search for user with username in repository
       $isLoggedIn = User::canFindMatchingUsernameAndPassword($username, $password);

       // action depending on login success
       if($isLoggedIn) {
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
       }else {
           $templateName = 'login';

           $argsArray = array(
               'title' => 'Login',
               'isLoggedIn' => $isLoggedIn,
               'loginError' => 'unsuccessful, please try again.'
           );

           return $app['twig']->render($templateName . '.html.twig', $argsArray);
       }
   }

    public function registerUserAction(Request $request, Application $app){
        $firstname = $request->get('firstname');
        $surname = $request->get('surname');
        $username = $request->get('username');
        $password = $request->get('password');
        $position = $request->get('position');

        if($position == '1'){
            $makePosition = User::POSITION_1;
        }elseif($position == '2'){
            $makePosition = User::POSITION_2;
        }else{
            $makePosition = User::POSITION_3;
        }

        User::insert($firstname, $surname, $username, $password, $makePosition);

        $templateName = 'index';
        $argsArray = array(
            'title' => 'Home',
            'username' => $username,
            'isLoggedIn' => $this->isLoggedInFromSession(),
            'successMessage' =>"You successfully registered"
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