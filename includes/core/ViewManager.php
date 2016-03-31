<?php
require_once '../includes/View/ViewFactory.php';
require_once FILE_PATH('view') . 'ViewDef.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewManager implements IReceiver
{

    private $viewList = [];
    private static $instance;

    public static function Instance()
    {
        if (is_null(ViewManager::$instance)) {
            ViewManager::$instance = new ViewManager();
        }
        return ViewManager::$instance;
    }
    public function receivePackage(Package $messagePackage)
    {

        if ($messagePackage->getValue(ControllerDef::COMMAND) == ControllerCommand::VIEW_PAGE){
            $views = $messagePackage->getValue(ControllerDef::VIEWS);
            $data = $messagePackage->getValue(ControllerDef::DATA);
            foreach ($views as $view){
                $this->addToViewList($view, $data);
            }
            $this->render();
        }
    }

    private function addToViewList($viewName, Package $data = null)
    {
        $view = ViewFactory::Instance()->createView($viewName);

        $view->setData($data);
        PostOffice::Instance()->addReceiver($view);
        array_push($this->viewList, $view);
    }

    private function render()
    {
        $headerView = ViewFactory::Instance()->createView('Header');
        $headerView->render();
        foreach ($this->viewList as $view) {
            if (!is_null($view)) {
                $view->render();
            }
        }
    }
}

