<?php

/**
 * Created by PhpStorm.
 * User: Khas
 * Date: 12/8/2015
 * Time: 1:13 PM
 */
abstract class View implements IReceiver
{
    protected $data = null;

    public function setData($data)
    {
        $this->data = $data;
    }

    public abstract function render();
}