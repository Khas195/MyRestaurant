<?php

/**
 * Created by PhpStorm.
 * User: Chanh
 * Date: 20/12/2015
 * Time: 12:48 PM
 */
class RecruitmentInfoBox extends View
{

    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }

    public function render()
    {
        ?>
        <div id="recruitmentInfo" class="col-md-3">
            <div id="recruitmentDetail">
            <?php
            $keys = $this->data->returnKeyList();
            foreach ($keys as $key) {
                if ($key == DatabaseDef::ATTRIBUTE_RESTAURANT_SKILL) {
                    $skill = $this->data->getValue($key);
                    $skillKeys = $skill->returnKeyList();
                    ?>
                    <p id="<?php echo $key; ?>" class="infoText">Skill:
                        <p id="skillDetail">
                        <?php
                        foreach ($skillKeys as $skillKey) {
                                echo  $skillKey . " " . $skill->getValue($skillKey) . "</br>";
                        }
                        ?>
                    </p>
                    </p>
                    <?php
                } else if($key == DatabaseDef::ATTRIBUTE_RECRUITMENT_STARTDATE){
                    ?>
                    <p id="<?php echo $key; ?>" class="infoText"><?php echo "Start : " . $this->data->getValue($key); ?></p>
                    <?php
                }

                 else if($key == DatabaseDef::ATTRIBUTE_RECRUITMENT_POST_NAME){
                    ?>
                    <p id="<?php echo $key; ?>" class="infoText"><?php echo  $this->data->getValue($key); ?></p>
                    <?php
                }


                else {
                    ?>
                    <p id="<?php echo $key; ?>" class="infoText"><?php echo $key . ": " .$this->data->getValue($key); ?></p>
                    <?php
                }

            }
            ?>
            </div>
            <button id="applyButton">Apply</button>
        </div>
        <?php
    }
}