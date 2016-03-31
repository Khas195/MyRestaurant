<?php

/**
 * Created by PhpStorm.
 * User: Khas
 * Date: 12/17/2015
 * Time: 11:10 PM
 */
class RestaurantListBox extends View
{
    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }

    public function render()
    {
        /*
        if ($this->data == null) {
            return;
        }*/
        $data = PackagePool::Instance()->requestPackage();
        $test1 = PackagePool::Instance()->requestPackage();
        $test2 = PackagePool::Instance()->requestPackage();
        $test3 = PackagePool::Instance()->requestPackage();

        $test1->setValue(DatabaseDef::ATTRIBUTE_RECRUITMENT_POST_NAME, 'Jollibe');
        $test1->setValue(DatabaseDef::ATTRIBUTE_RESTAURANT_ADDRESS, 'Ho Chi MInh');
        $test1->setValue('User_Status', 'Available');

        $test2->setValue(DatabaseDef::ATTRIBUTE_RECRUITMENT_POST_NAME, 'Mac DOnal');
        $test2->setValue(DatabaseDef::ATTRIBUTE_RESTAURANT_ADDRESS, 'Hai Phong');
        $test2->setValue('User_Status', 'Hired');

        $test3->setValue(DatabaseDef::ATTRIBUTE_RECRUITMENT_POST_NAME, 'KFC');
        $test3->setValue(DatabaseDef::ATTRIBUTE_RESTAURANT_ADDRESS, 'Nha Trang');
        $test3->setValue('User_Status', 'Available');

        $data->setValue('ID1', $test1);
        $data->setValue('ID2', $test2);
        $data->setValue('ID3', $test3);

        $this->data = $data;

        ?>
        <link href="<?php echo FILE_PATH('css') . 'RestaurantListBox.css'; ?>" rel="stylesheet">
        <div id="restaurant_list" class="row">
            <?php
            foreach ($this->data->returnKeyList() as $id) {
                $viewData = $this->data->getValue($id);
                ?>


                <div id="restaurant_list_box" class="col-md-3">
                    <img id="avatar" src="<?php echo FILE_PATH('image') . 'avatar.png' ?>">
                    <!-- change key here to restaurant name later -->
                    <div id="restaurant_text">
                        <p id="name"> <?php echo $viewData->getValue(DatabaseDef::ATTRIBUTE_RECRUITMENT_POST_NAME); ?> </p>

                        <p id="address"> <?php echo $viewData->getValue(DatabaseDef::ATTRIBUTE_RESTAURANT_ADDRESS); ?> </p>

                        <button id="follow"> Follow</button>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
}