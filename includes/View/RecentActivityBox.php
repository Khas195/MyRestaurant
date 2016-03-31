<?php

/**
 * Created by PhpStorm.
 * User: Khas
 * Date: 12/17/2015
 * Time: 4:52 PM
 */
class RecentActivityBox extends View
{
    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }
    public function prepareMessage($max, $target)
    {
        $message = PackagePool::Instance()->requestPackage();

        $message->setValue(ControllerDef::COMMAND, ControllerCommand::GET_DATA);
        $message->setValue(DatabaseDef::DEFINITION_STATE, StateMainPage::DEF_GET_RECENT_ACTIVITY);
        $message->setValue(DatabaseDef::MAX_NUMBER_RESULTS, $max);
        $message->setValue(DatabaseDef::KEY_TARGET, $target);
        ModelManager::Instance()->receivePackage($message);
        return $message->getValue(DatabaseDef::RESULT);
    }
    public function render()
    {
        ?>
            <h1 align = "center" style ="bold"> Recent Activities</h1>
        <?php


        $tabs = ViewFactory::Instance()->createView(ViewDef::TAB);
        $tabView = PackagePool::Instance()->requestPackage();

        // Prepare some of the key for info retreival
        $message = PackagePool::Instance()->requestPackage();
        $message->setValue(ControllerDef::COMMAND, ControllerCommand::GET_DATA);
        $message->setValue(DatabaseDef::DEFINITION_STATE, StateMainPage::DEF_GET_RECENT_ACTIVITY);
        $message->setValue(DatabaseDef::MAX_NUMBER_RESULTS, 3);

        //preapre the recruitments View
        $recruitmentPosts = ViewFactory::Instance()->createView(ViewDef::RESTAURANTS_RECRUITMENT);
        $message->setValue(DatabaseDef::KEY_TARGET, DatabaseDef::TAR_RECRUITMENT);
        $message->setValue(DatabaseDef::ATTRIBUTE_USER_USERID, '1');

        PostOffice::Instance()->sendPackage($message);

        $recruitmentPosts->setData($message->getValue(DatabaseDef::RESULT));

        // Prepare the list of restaurant view
        $restaurants = ViewFactory::Instance()->createView(ViewDef::RESTAURANT_LIST_BOX);
        $message->setValue(DatabaseDef::KEY_TARGET, DatabaseDef::TAR_RESTAURANT);
        PostOffice::Instance()->sendPackage($message);
        $restaurants->setData($message->getValue(DatabaseDef::RESULT));

        // prepare the llist of user
        $users = ViewFactory::Instance()->createView(ViewDef::USER_LIST_BOX);
        $message->setValue(DatabaseDef::KEY_TARGET, DatabaseDef::TAR_USERS);
        PostOffice::Instance()->sendPackage($message);
        $users->setData($message->getValue(DatabaseDef::RESULT));

        $tabView->setValue('RECRUITMENT', $recruitmentPosts);
        $tabView->setValue('RESTAURANT', $restaurants);
        $tabView->setValue('USER', $users);

        $tabs->setData($tabView);
        $tabs->render();
        PackagePool::Instance()->returnPackage($tabView);

    }
}