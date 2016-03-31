<?php

/**
 * Created by PhpStorm.
 * User: Khas
 * Date: 12/17/2015
 * Time: 11:05 PM
 */
class SearchResultTab extends View
{
    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }
    public function render()
    {
        if (!isset($_POST['submit'])){
            return;
        }

        $message = PackagePool::Instance()->requestPackage();
        $message->setValue(ControllerDef::COMMAND, ControllerCommand::GET_DATA);
        $message->setValue(DatabaseDef::KEY_CONTENT, $_POST['field']);

        $districts = array();
        var_dump($_POST);
        $i = 0;
        while ($i >= 0){
            if (isset($_POST[$i])){
                array_push($districts, $_POST[$i]);
            }
            if ($i == 10)
            {
                break;
            }
            $i++;
        }
        $message->setValue(DatabaseDef::KEY_CONSTRAINT, array(DatabaseDef::ATTRIBUTE_USER_PROVINCE => array($_POST['province']), DatabaseDef::ATTRIBUTE_USER_DISTRICT => $districts, DatabaseDef::ATTRIBUTE_USER_USERID => 1));

        $tabs = ViewFactory::Instance()->createView(ViewDef::TAB);
        $tabView = PackagePool::Instance()->requestPackage();

        //preapre the recruitments View
        $recruitmentPosts = ViewFactory::Instance()->createView(ViewDef::RESTAURANTS_RECRUITMENT);
        $message->setValue(DatabaseDef::KEY_TARGET, DatabaseDef::TAR_RECRUITMENT);
        PostOffice::Instance()->sendPackage($message);
        var_dump($message->getValue(DatabaseDef::RESULT));
        return;
        $message->setValue(DatabaseDef::KEY_TARGET, DatabaseDef::TAR_USERS);


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
        // add restaurant tab


    }
}