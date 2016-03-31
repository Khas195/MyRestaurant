<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class Header extends View
{
    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }

    public function render()
    {
        ?>
        <div>
            <link rel="stylesheet" type="text/css" href= <?php echo FILE_PATH('css') . 'Header.css' ?>>
            <?php
            require_once HTML_PUBLIC . 'Header.html';
            ?>
        </div>
        <?php
    }
}