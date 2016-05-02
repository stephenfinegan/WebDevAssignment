<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 02/05/2016
 * Time: 13:52
 */

/**
 * namespace for cv controller
 */
namespace StephenFinegan\controllers;

use StephenFinegan\Models\User;
use StephenFinegan\Models\Job;
use StephenFinegan\Models\Applicants;
use StephenFinegan\Models\CV;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CVController
 * @package StephenFinegan\controllers
 */
class CVController
{

    /**
     * Brings the user to the accounts page where a same cv is displayed which they can edit and sumbit as their own
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processCVAction(Request $request, Application $app)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $position = $this->positionFromSession();

        $firstname = $request->get('firstname');
        $surname = $request->get('surname');
        $email = $request->get('email');
        $number = $request->get('phoneNumber');
        $picture = $request->get('picture');
        $address = $request->get('address');
        $town = $request->get('town');
        $previousJobs = $request->get('previousJobs');
        $qualifications = $request->get('qualifications');

        $processCV = CV::insert($firstname, $surname, $email, $number, $picture, $address, $town, $previousJobs, $qualifications);
        $CVS = CV::getOneByUsername($username);

        if ($processCV) {
            $worked = "CV has been successfully added";
        } else {
            $failed = "Unable to add CV";
        }
        $templateName = 'account';
        $argsArray = array(
            'title' => 'Account',
            'worked' => $worked,
            'isLoggedIn' =>$isLoggedIn,
            'username'=>$username,
            'position'=>$position,
            'CVS'=>$CVS

        );
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * returns if the user is logged in
     * @return bool
     */
    public function isLoggedInFromSession()
    {
        $isLoggedIn = false;

        if (isset($_SESSION['user'])) {
            $isLoggedIn = true;
        }
        return $isLoggedIn;
    }

    /*
     * returns username if the user is logged in
     */
    public function usernameFromSession()
    {
        $username = '';

        if (isset($_SESSION['user'])) {
            $username = $_SESSION['user'];
        }
        return $username;
    }

    /*
     * returns position of user
     */
    public function positionFromSession()
    {
        if (isset($_SESSION['user'])) {
            $username = $this->usernameFromSession();
            $user = User::getOneByUsername($username);
            $position = $user->getposition();
        }
        return intval($position);
    }
}
