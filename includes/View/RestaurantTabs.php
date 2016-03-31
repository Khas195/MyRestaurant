<?php

/**
 * Created by PhpStorm.
 * User: Khas
 * Date: 12/20/2015
 * Time: 4:05 PM
 */
class RestaurantTabs extends View
{
    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }
    public function render()
    {
        $mTabs = ViewFactory::Instance()->createView('Tab');

        $overallTab = ViewFactory::Instance()->createView('RestaurantPersonalInfo');
        $restaurantRecruit = ViewFactory::Instance()->createView('RestaurantRecruitment');
        $message = PackagePool::Instance()->requestPackage();

        $photoList = ViewFactory::Instance()->createView('RestaurantPhoto');
        $statistic = ViewFactory::Instance()->createView('Statistic');

        $tabData = PackagePool::Instance()->requestPackage();


        $tabData->setValue('Overall', $overallTab);
        $tabData->setValue('Recruitments', $restaurantRecruit);
        $tabData->setValue('Photo', $photoList);
        $tabData->setValue('Statistic', $statistic);


        $mTabs->setData($tabData);
        $mTabs->render();
    }
}