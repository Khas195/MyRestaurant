<?php
/**
 * Created by PhpStorm.
 * User: Tran Tinh Chi
 * Date: 12/20/15
 * Time: 4:40 PM
 */


require_once FILE_PATH('algorithms').'Algorithms.php';

class SignUpDataAlgorithm implements Algorithms {
    private static $ATTRIBUTE_ARRAY = array(
                                    DatabaseDef::ATTRIBUTE_USER_USERNAME,
                                    DatabaseDef::ATTRIBUTE_USER_PASSWORD,
                                    DatabaseDef::ATTRIBUTE_USER_EMAIL,
                                    DatabaseDef::ATTRIBUTE_USER_BIRTHDAY,
                                    DatabaseDef::ATTRIBUTE_USER_FNAME,
                                    DatabaseDef::ATTRIBUTE_USER_MNAME,
                                    DatabaseDef::ATTRIBUTE_USER_LNAME,
                                    DatabaseDef::ATTRIBUTE_USER_ADDRESS,
                                    DatabaseDef::ATTRIBUTE_USER_DISTRICT,
                                    DatabaseDef::ATTRIBUTE_USER_PROVINCE,
                                    DatabaseDef::ATTRIBUTE_USER_PHONE,
                                    DatabaseDef::ATTRIBUTE_USER_GENDER);

    public function execute (mysqli $conn, Package $messagePackage) {
        $curEmail = $messagePackage->getValue(DatabaseDef::ATTRIBUTE_USER_EMAIL);
        $curUserName = $messagePackage->getValue(DatabaseDef::ATTRIBUTE_USER_EMAIL);

        if ($curEmail == null || $curUserName == null) {
            return false;
        }

        $b = "`";
        $a = "'";
        $sql = 'SELECT * FROM '
            .$b.DatabaseDef::TABLE_USER.$b.' WHERE '
            .DatabaseDef::ATTRIBUTE_USER_EMAIL." = $a$curEmail$a OR ".DatabaseDef::ATTRIBUTE_USER_USERNAME." = '$curUserName'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $messagePackage->setValue(DatabaseDef::RESULT, $conn->error);
            return false;
        }

        if (sizeof(SignUpDataAlgorithm::$ATTRIBUTE_ARRAY) > 0) {
            $attr = SignUpDataAlgorithm::$ATTRIBUTE_ARRAY[0];
            $sql =
                "INSERT INTO `Users`(`$attr`";

            $arrayValue = array();

            for ($i = 1 ; $i < sizeof(SignUpDataAlgorithm::$ATTRIBUTE_ARRAY); $i++) {
                $attr = SignUpDataAlgorithm::$ATTRIBUTE_ARRAY[$i];
                $sql .= ",`$attr`";
                array_push($arrayValue, $messagePackage->getValue($attr));
            }
        }

        $sql .= ') VALUES (';

        if (sizeof($arrayValue) > 0) {
            $sql .= "'$arrayValue[0]'";

            for ($i = 1; $i < sizeof($arrayValue); $i++) {
                $sql .= ",'$arrayValue[$i]'";
            }

            $sql .= ");";
            $conn->query($sql);
        }

        $sql = "SELECT Users.UserId FROM Users Where ".DatabaseDef::ATTRIBUTE_USER_USERNAME." = '$curUserName'";
        $id = $conn->query($sql);
        $id = floatval($id['UserId']);

        $messagePackage->setValue(DatabaseDef::RESULT, $id);

        return true;
    }
}