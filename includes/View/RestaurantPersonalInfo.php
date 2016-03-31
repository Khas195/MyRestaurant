<?php

/**
 * Created by PhpStorm.
 * User: Chanh
 * Date: 20/12/2015
 * Time: 11:58 AM
 */
class RestaurantPersonalInfo extends View
{

    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }

    public function render()
    {
        ?>
        <link rel="stylesheet" href="<?php echo FILE_PATH('css') . 'RestaurantPersonalInfo.css'; ?>">
        <link rel="stylesheet" href="<?php echo FILE_PATH('css') . 'Map.css'; ?>">

        <script src="https://maps.googleapis.com/maps/api/js"></script>
        <script src="<?php echo FILE_PATH('js') . 'Map.js'; ?>"></script>

        <div id="restaurantPersonalInfo">

            <div id="restaurantMap">

                <div id="map">

                </div>
            </div>

            <div id="restaurantInfo">
                <?php
                $personalInfoBox = ViewFactory::Instance()->createView('PersonalInfoBox');
                $personalInfoBox->render();
                ?>
            </div>
        </div>

        <?php
    }
}