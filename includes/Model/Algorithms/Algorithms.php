<?php
/**
 * Created by PhpStorm.
 * User: Tran Tinh Chi
 * Date: 12/20/15
 * Time: 10:37 AM
 */
require_once FILE_PATH('model').'DatabaseDef.php';

interface Algorithms {
    public function execute (mysqli $conn, Package $messagePackage);
}

