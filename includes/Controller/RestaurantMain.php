<?php

/**
 * Created by PhpStorm.
 * User: Khas
 * Date: 12/18/2015
 * Time: 7:27 AM
 */
class RestaurantMain extends Controller
{
    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }

    public function index()
    {
        $message = PackagePool::Instance()->requestPackage();

        $message->setValue(ControllerDef::COMMAND, ControllerCommand::STATE_CHANGE);
        $message->setValue(DatabaseDef::NAME_STATE, DatabaseDef::STATE_RESTAURANT_PAGE);

        PostOffice::Instance()->sendPackage($message);

        $message->setValue(ControllerDef::COMMAND,ControllerCommand::VIEW_PAGE);
        $message->setValue(ControllerDef::VIEWS, [ViewDef::SLIDE_SHOW, ViewDef::RESTAURANT_TABS]);

        PostOffice::Instance()->sendPackage($message);

        PackagePool::Instance()->returnPackage($message);
    }

}