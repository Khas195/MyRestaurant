<?php

/**
 * Created by PhpStorm.
 * User: Chanh
 * Date: 20/12/2015
 * Time: 11:58 AM
 */
class RestaurantRecruitment extends View
{

    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }

    public function render()
    {
        if ($this->data == null){
            return;
        }
        ?>
        <link rel="stylesheet" href="<?php echo FILE_PATH('css').'RestaurantRecruitment.css';?>">
        <link rel="stylesheet" href="<?php echo FILE_PATH('css') . 'RecruitmentInfoBox.css'; ?>">

        <div id="restaurantRecruitment" class="row">
            <?php
                foreach ($this->data->returnKeyList() as $key){
                    $viewdata = ViewFactory::Instance()->createView('RecruitmentInfoBox');
                    $data = PackagePool::Instance()->requestPackage();
                    $data->setArray($this->data->getValue($key));
                    $viewdata->setData($data);
                    $viewdata->render();
                    PackagePool::Instance()->returnPackage($data);
                }
            ?>
        </div>
        <?php


    }
}