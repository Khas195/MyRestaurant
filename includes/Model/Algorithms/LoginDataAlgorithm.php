<?php
/**
 * Created by PhpStorm.
 * User: Tran Tinh Chi
 * Date: 12/20/15
 * Time: 10:58 AM
 */

require_once FILE_PATH('algorithms').'Algorithms.php';
require_once FILE_PATH('patterns').'Package.php';


class LoginDataAlgorithm implements Algorithms {
    public function execute (mysqli $conn, Package $messagePackage) {
        $curEmail = $messagePackage->getValue(DatabaseDef::ATTRIBUTE_USER_EMAIL);
        $curPassword = $messagePackage->getValue(DatabaseDef::ATTRIBUTE_USER_PASSWORD);

        if ($curEmail == null || $curPassword == null) {
            return false;
        }

        $b = "`";
        $a = "'";
        $sql = 'SELECT * FROM '
            .$b.DatabaseDef::TABLE_USER.$b.' WHERE '
            .DatabaseDef::ATTRIBUTE_USER_EMAIL." = $a$curEmail$a AND "
            .DatabaseDef::ATTRIBUTE_USER_PASSWORD." = $a$curPassword$a";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $pack = PackagePool::Instance()->requestPackage();

            while ($row = $result->fetch_assoc()) {
                $temp = PackagePool::Instance()->requestPackage();
                $temp->setArray($row);
                $pack->setValue($row[DatabaseDef::ATTRIBUTE_USER_USERID], $temp);
            }

            $messagePackage->setValue(DatabaseDef::RESULT, $pack);

        }
        else {
            $messagePackage->setValue(DatabaseDef::RESULT, null);
        }

        return true;
    }
}