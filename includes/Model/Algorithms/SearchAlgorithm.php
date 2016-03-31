<?php
/**
 * Created by PhpStorm.
 * User: Tran Tinh Chi
 * Date: 12/20/15
 * Time: 11:54 AM
 */


require_once FILE_PATH('algorithms').'Algorithms.php';

abstract class SearchAlgorithm implements Algorithms {
    public function execute (mysqli $conn, Package $messagePackage){
        $content = $messagePackage->getValue(DatabaseDef::KEY_CONTENT);
        $constraints = $messagePackage->getValue(DatabaseDef::KEY_CONSTRAINT);

        if ($content == null || $constraints == null) {
            return false;
        }

        $pack = $this->search($conn, $content, $constraints);

        $messagePackage->setValue(DatabaseDef::RESULT, $pack);

        return true;
    }

    abstract public function search(mysqli $conn, $content, $constraints = []);
}