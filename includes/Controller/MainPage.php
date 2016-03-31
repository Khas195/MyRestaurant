<?php

/**
 * Created by PhpStorm.
 * User: Khas
 * Date: 12/17/2015
 * Time: 9:49 AM
 */
class MainPage extends Controller
{
    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }
    public function index()
    {
        $data = PackagePool::Instance()->requestPackage();
        $data->setValue(ControllerDef::COMMAND, ControllerCommand::STATE_CHANGE);
        $data->setValue(DatabaseDef::NAME_STATE, DatabaseDef::STATE_MAIN_PAGE);
        PostOffice::Instance()->sendPackage($data);


        $views = [ViewDef::SLIDE_SHOW,ViewDef::MATCHING_LIST_BOX, ViewDef::RECENT_ACTIVITIES_BOX];
        $message = PackagePool::Instance()->requestPackage();

        $message->setValue(ControllerDef::COMMAND, ControllerCommand::VIEW_PAGE);
        $message->setValue(ControllerDef::VIEWS, $views);

        PostOffice::Instance()->sendPackage($message);

        PackagePool::Instance()->returnPackage($data);
        PackagePool::Instance()->returnPackage($message);


    }
}