<?php

/**
 * Created by PhpStorm.
 * User: Chanh
 * Date: 20/12/2015
 * Time: 3:19 PM
 */
class RestaurantPhoto extends View
{

    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }

    public function render()
    {
        $this->data = PackagePool::Instance()->requestPackage();
        $photoList = PackagePool::Instance()->requestPackage();

        $photoList->setValue('Photo1','MonkeyInBlack.jpg');
        $photoList->setValue('Photo2','inbox.png');
        $photoList->setValue('Photo3','tu.jpg');

        $this->data->setValue(DatabaseDef::ATTRIBUTE_RESTAURANT_PHOTO, $photoList);

        ?>
        <link rel="stylesheet" href="<?php echo FILE_PATH('css').'RestaurantPhoto.css'?>">

        <div id="recruitmentPhoto" class="row">
            <?php
            foreach ($this->data->returnKeyList() as $key) {
                if ($key == DatabaseDef::ATTRIBUTE_RESTAURANT_PHOTO) {
                    $photoList = $this->data->getValue($key);
                    $photoListKey = $photoList->returnKeyList();
                    foreach ($photoListKey as $photo) {
                        ?>
                         <img class="photo" src="<?php echo FILE_PATH('image') . $photoList->getValue($photo); ?>">
                        <?php
                    }
                }

            }
            ?>
        </div>
        <?php
    }
}