<?php
/**
 * Created by PhpStorm.
 * User: Chanh
 * Date: 10/12/2015
 * Time: 12:59 PM
 */

class SlideShow extends  View{

    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }

    public function render()
    {
        ?>
        <link rel="stylesheet" href="<?php echo FILE_PATH('css').'mainPageStyle.css'?>">
        <script type="text/javascript" src="<?php echo FILE_PATH('js') . 'prefixfree.min.js'?>"></script>
        <script type="text/javascript" src="<?php echo FILE_PATH('js') . 'index.js'?>"></script>
        <?php
        require_once HTML_PUBLIC . 'SlideShow.html';
        ?>
        <script type="text/javascript" src="<?php echo FILE_PATH('js') . 'index.js'?>"></script>
        <?php
    }
}