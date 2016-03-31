<?php

/**
 * Created by PhpStorm.
 * User: Chanh
 * Date: 09/12/2015
 * Time: 11:17 AM
 */
class SearchBar extends View
{

    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }

    public function render()
    {

        ?>
        <link rel="stylesheet" href="<?php echo FILE_PATH('css') . 'SearchBar.css' ?>">
        <script type="text/javascript" src=""></script>
        <div id="searchContainer">
            <form action="http://localhost/MyRestaurant/public_html/SearchPageController" name="search" method="POST" class="">
                <input id="field" name="field" type="text" placeholder="Search"/>
                <button id="submit" name="submit" type="submit" value="Search">Search</button>
                <div id="advance_search" onclick="appearAdvanceSearch();">Advance Search</div>
                <?php
                if (!$this->data || $this->data->getValue('AdvanceSearch') == 1) {
                    ?>
                    <div id="advanceSearch" style="display: none">
                        <?php
                        $advanceSearch = ViewFactory::Instance()->createView('AdvanceSearch');
                        $advanceSearch->render();
                        ?>
                    </div>
                    <?php
                }
                ?>
            </form>
        </div>
        <script>
            function appearAdvanceSearch(){
                if(document.getElementById("advanceSearch").style.display == "block"){
                    document.getElementById("advanceSearch").style.display = "none";
                }
                else
                    document.getElementById("advanceSearch").style.display = "block";
            }
        </script>
        <?php
    }
}