<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 14/04/2016
 * Time: 17:36
 */

/**
 * add namespace to the string, after exploding controller name from action
 *
 * examples:
 * input:   Hdip, main/index
 * output:  Hdip\MainController::indexAction
 *
 * input:   Mattsmithdev\Samples, hello/name
 * output:  Mattsmithdev\Samples\HelloController::nameAction
 *
 * @param $shortName controller and action name separate by "/"
 * @return string namespace, controller class name plus :: plus action name
 */

function controller($namespace, $shortName)
{
    list($shortClass, $shortMethod) = explode('/', $shortName, 2);

    $shortClassCapitlise = ucfirst($shortClass);

    $namespaceClassAction = sprintf($namespace . '\\' . $shortClassCapitlise . 'Controller::' . $shortMethod . 'Action');

    return $namespaceClassAction;
}
