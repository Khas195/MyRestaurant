<?php

/**
 * Created by PhpStorm.
 * User: Khas
 * Date: 12/20/2015
 * Time: 3:59 PM
 */
class Statistic extends View
{
    public  function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }
    public function render()
    {
        ?>
            <p>Pending: 30</p>
            <p>Employee: 30</p>
        <?php
    }
}