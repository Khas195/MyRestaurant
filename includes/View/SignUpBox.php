<?php

/**
 * Created by PhpStorm.
 * User: Chanh
 * Date: 09/12/2015
 * Time: 12:03 PM
 */
class SignUpBox extends View
{
    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }

    public function render()
    {
        ?>

        <link rel="stylesheet" href="<?php echo FILE_PATH('css').'SignUp.css';?>">
        <meta charset="UTF-8">
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

        <?php
        require_once HTML_PUBLIC . 'SignUp.html';
    }
}