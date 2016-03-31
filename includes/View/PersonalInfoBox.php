<?php

/**
 * Created by PhpStorm.
 * User: Chanh
 * Date: 20/12/2015
 * Time: 11:35 AM
 */
class PersonalInfoBox extends View
{

    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }

    public function render()
    {
        if (!$this->data){
            return;
        }
        ?>
        <link rel="stylesheet" href="<?php echo FILE_PATH('css') . 'PersonalInfoBox.css'; ?>">

        <?php
        $keys = $this->data->returnKeyList();
        foreach ($keys as $key) {

            ?>
            <div id="infoBox">
                <p id="<?php echo $key;?>" class="infoText"><?php echo $this->data->getValue($key);?></p>
            </div>

            <?php
        }
        ?>
        <?php
    }
}