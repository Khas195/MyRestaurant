<?php

/**
 * Created by PhpStorm.
 * User: Khas
 * Date: 12/17/2015
 * Time: 10:03 PM
 */
class SearchPageController extends Controller
{
    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }
    public function index()
    {
        $message = PackagePool::Instance()->requestPackage();

        $message->setValue(ControllerDef::COMMAND, ControllerCommand::STATE_CHANGE);
        $message->setValue(DatabaseDef::NAME_STATE, DatabaseDef::STATE_SEARCH);

        PostOffice::Instance()->sendPackage($message);

        $views  = [ViewDef::SLIDE_SHOW, ViewDef::SEARCH_BAR, ViewDef::SEARCH_RESULT_TAB];

        $message->setValue(ControllerDef::COMMAND, ControllerCommand::VIEW_PAGE);
        $message->setValue(ControllerDef::VIEWS, $views);

        PostOffice::Instance()->sendPackage($message);
        PackagePool::Instance()->returnPackage($message);

    }
}