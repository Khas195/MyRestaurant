<?php
/**
 * Created by PhpStorm.
 * User: macpro
 * Date: 12/20/15
 * Time: 1:05 PM
 */

require_once FILE_PATH('algorithms').'Algorithms.php';

class NullAlgorithm implements Algorithms {
    public function execute (mysqli $conn, Package $messagePackage) {
        echo 'Error - No satisfied algorithm <br>';
    }
}
