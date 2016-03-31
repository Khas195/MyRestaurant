<?php
require_once FILE_PATH('patterns') . 'IReceiver.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class ControllerDef
{
    const DATA = 1;
    const VIEWS = 2;
    const COMMAND = 3;

}
abstract class ControllerCommand
{
    const VIEW_PAGE = 'VIEW_PAGE';
    const STATE_CHANGE = 'STATE_CHANGE';
    const GET_DATA = 'GET_DATA';
    const CHOOSE_CONTROLLER = 'CHOOSE_CONTROLLER';
}

abstract class  Controller implements IReceiver
{
    public abstract function index();

}