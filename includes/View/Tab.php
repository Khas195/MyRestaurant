<?php

/**
 * Created by PhpStorm.
 * User: Chanh
 * Date: 10/12/2015
 * Time: 1:36 PM
 */
class Tab extends View
{

    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }

    public function render()
    {
        $list = $this->data->returnKeyList();
        ?>

        <link rel="stylesheet" href="<?php echo FILE_PATH('css') . 'tab.css'; ?>">
        <body>
        <div class="tabMenuWrapper">


            <ul id="tabMenu">

                <?php

                foreach ($list as $tab) {
                    ?>
                    <li role="presentation" ><a href="#<?php echo $tab;?>" role="tab"> <?php echo $tab; ?> </a></li>
                    <?php
                }
                ?>

                <li class="slider"></li>

            </ul>

            <div class="tab-content">
                <?php
                $i = 0;
                foreach ($list as $tab) {

                    ?>
                    <div id="<?php echo $tab; ?>" class="tab <?php if ($i == 0) {echo 'active'; $i++;} ?>">
                        <?php
                        $view = $this->data->getValue($tab);
                        $view->render();

                        ?>
                    </div>
                    <?php

                }
                ?>

            </div>
        </div>

        </body>
        <script type="text/javascript" src="<?php echo FILE_PATH('js') . 'BetterTab.js'; ?>"></script>

        <?php

    }
}