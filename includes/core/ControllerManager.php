<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once FILE_PATH('controller') . 'Controller.php';
class ControllerManager implements  IReceiver
{
    protected $controller = 'Login';

    protected $method = 'index';

    protected $params = [];

    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }

    public function __construct()
    {
        $url = $this->parseUrl();
        /*after split the url into an array, we check if the 1st elements is a controller */
        if (file_exists(FILE_PATH('controller') . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset ($url[0]);
        }

        require_once FILE_PATH('controller') . $this->controller . '.php';

        /*create a new object.   */
        $this->controller = new $this->controller;

        PostOffice::Instance()->addReceiver($this->controller);

        if (isset($url[1])) {
            /* method_exists(class, method name)*/
            if (method_exists($this->controller, $url[1])) {

                $this->method = $url[1];
                unset($url[1]);
            }

        }

        /* if ($url) then = array values else = []  */
        $this->params = $url ? array_values($url) : [];
        $_POST['MyParam'] = $this->params;

        call_user_func_array([$this->controller, $this->method], $this->params);
    }
    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            /* rtrim remove ' ', \t, \n, ... , excepts /
             * filter_var, Filter_sanitize_url -> only excepts string that is of type url
             * explodes will return an array that splitted from the string by the '/' delimeters

            */

            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}

