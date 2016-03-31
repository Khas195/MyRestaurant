<?php

/**
 * Created by PhpStorm.
 * User: Khas
 * Date: 12/17/2015
 * Time: 6:35 PM
 */
class UserListBox extends View
{

    public function render()
    {
        if ($this->data == null){
            return;
        }

        ?>

        <link href="<?php echo FILE_PATH('css') . 'UserListBox.css'; ?>" rel="stylesheet">
        <div id="user_list" class="row">



            <?php
            $viewData = PackagePool::Instance()->requestPackage();
            foreach ($this->data->returnKeyList() as $id) {
                $viewData->setArray($this->data->getValue($id));
                ?>
            <div id="user_box" class="col-md-3">
                        <a href="#">
                            <img id="avatar" src="<?php echo FILE_PATH('image') . 'avatar.png' ?>">
                            <div id="user_list_box">
                                <!-- change key here to restaurant name later -->
                                <p id="name"> <?php echo $viewData->getValue(DatabaseDef::ATTRIBUTE_USER_USERNAME); ?> </p>
                                <p id="address"> <?php echo $viewData->getValue(DatabaseDef::ATTRIBUTE_USER_ADDRESS) . ', '
                                                    . $viewData->getValue(DatabaseDef::ATTRIBUTE_USER_DISTRICT) . ', '
                                                    . $viewData->getValue(DatabaseDef::ATTRIBUTE_USER_PROVINCE); ?> </p>
                                <p id="status" ></p>
                                <button id="add_friend">Add</button>
                            </div>
                        </a>
            </div>
                <?php
            }
            ?>

        </div>
        <?php
    }
    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }
}