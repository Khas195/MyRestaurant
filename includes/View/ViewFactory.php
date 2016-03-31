<?php
/**
 * Created by PhpStorm.
 * User: Khas
 * Date: 12/8/2015
 * Time: 1:15 PM
 */
require_once 'View.php';
class ViewFactory{
    private static $instance;
    public static function Instance(){
        if (!ViewFactory::$instance){
            ViewFactory::$instance = new ViewFactory();
        }
        return ViewFactory::$instance;
    }

    public function createView($viewName){
        $path = '../includes/View/' . $viewName . '.php';
        if (file_exists($path)) {
            require_once "$path";
            $viewName = new $viewName;
            return $viewName;
        }

        return null;
    }
}