<?php

/**
 * Created by PhpStorm.
 * User: Khas
 * Date: 12/23/2015
 * Time: 4:31 PM
 */
class ActivityUser extends View
{
    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }

    public function render()
    {
        if (!$this->data) {
            return;
        }
        foreach ($this->data->returnKeyList() as $key) {
            $viewData = $this->data->getValue($key);
            ?>
            <div id="recent_activity_box" class="col-md-3">
                <a href="#"><img id="avatar"
                                 src="<?php echo FILE_PATH('image') . $viewData->getValue('avatar'); ?>"></a>

                <div id="info_box">
                    <p id="position"> <!-- POSITION -->
                        Position: <?php echo $viewData->getValue(DatabaseDef::ATTRIBUTE_RECRUITMENT_POSITION); ?> </p>

                    <?php // PRINT SALARY IF EXIST
                    $salary = $viewData->getValue(DatabaseDef::ATTRIBUTE_RECRUITMENT_POST_SALARY);
                    if ($salary) {
                        ?>
                        <p id="salary">Salary: <?php echo $salary; ?></p>
                        <?php
                    }
                    ?>

                    <p id="province"><!-- PROVINCE -->
                        Province: <?php echo $viewData->getValue(DatabaseDef::ATTRIBUTE_USER_PROVINCE); ?> </p>


                </div>
                <p id="name"><?php echo $viewData->getValue(DatabaseDef::ATTRIBUTE_USER_FULLNAME); ?></p>

            </div>
            <?php
        }
    }
}