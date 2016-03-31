<?php

/**
 * Created by PhpStorm.
 * User: Khas
 * Date: 12/17/2015
 * Time: 3:09 PM
 */

class MatchingListBox extends View
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
        $this->prepareData();

        ?>
        <link href="<?php echo FILE_PATH('css') . 'MatchingListBox.css'; ?>" rel="stylesheet">

        <div id="matching_list" class="row">
            <?php
            $this->renderBox(3);
            ?>
        </div>
        <?php
    }

    public function prepareData()
    {
        $message = PackagePool::Instance()->requestPackage();
        $message->setValue(ControllerDef::COMMAND, ControllerCommand::GET_DATA);
        $message->setValue(DatabaseDef::DEFINITION_STATE, StateMainPage::DEF_GET_MATCHING_LIST);
        $message->setValue(DatabaseDef::ATTRIBUTE_USER_USERID, 1);
        PostOffice::Instance()->sendPackage($message);
        $this->data = $message->getValue(DatabaseDef::RESULT);
    }

    public function renderBox($input)
    {
        if ($this->data == null){
            return;
        }
        $i = 1;
        foreach ($this->data->returnKeyList() as $id) {
            $viewData = $this->data->getValue($id);
            if ($input - $i <= 2 && $input - $i >= 0) {

                ?>
                <div id="matching_list_box" class="col-md-3">


                    <img id="avatar" src="<?php echo FILE_PATH('image') . 'avatar.png' ?>">

                    <div id="restaurant_info">
                        <h3 id="name"> <?php echo $viewData[DatabaseDef::ATTRIBUTE_RECRUITMENT_POST_NAME]; ?> </h3>

                        <p id="adress"> <?php echo $viewData[DatabaseDef::ATTRIBUTE_RESTAURANT_PROVINCE] . ', District: ' .
                                $viewData[DatabaseDef::ATTRIBUTE_RESTAURANT_DISTRICT]; ?> </p>
                    </div>
                    <div id="user_related">
                        <h4 id="match">
                            Match: <?php echo $viewData[DatabaseDef::MATCHED_PERCENTAGE] * 100 . '%'; ?> </h4>

                        <h4 id="position">
                            Position: <?php echo $viewData[DatabaseDef::ATTRIBUTE_RECRUITMENT_JOB]; ?> </h4>
                    </div>


                    <input type="button" name="applyButton" id="applyButton" value="apply">
                </div>
                <?php
                $i++;
            }
        }
    }

}

/*
if (isset($_POST['randomlistIndex'])) {
    echo '<br> 2 <br>';
    echo '<br> 2 <br>';
    echo '<br> 2 <br>';
    echo '<br> 2 <br>';
    echo '<br> 2 <br>';


    ?>
    <script> alert('run post');</script>
    <?php
    $input = $_POST['randomlistIndex'];
    $view = ViewFactory::Instance()->createView(ViewDef::MATCHING_LIST_BOX);

    $view->prepareData();
    $view->renderBox($input);
    $input = $input + 3;
    echo $input;
}
    ?>
<script>
    var index = 0;
    function plus3() {
        $.ajax({
            type: "POST",
            data: {
                randomlistIndex: index
            },
            url: 'http://localhost/MyRestaurant/public_html/MainPage/index',
            dataType: "html",

            success: function (output) {
                alert('success' + index);
                index = output;
            },
            error: function () {
                alert('error');
            }
        });

    }
</script>
<?php
*/
