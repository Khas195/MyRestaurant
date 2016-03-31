<?php
/**
 * Created by PhpStorm.
 * User: Tran Tinh Chi
 * Date: 12/20/15
 * Time: 11:37 AM
 */

require_once FILE_PATH('algorithms').'SearchAlgorithm.php';

class SearchUserAlgorithm extends  SearchAlgorithm {
    public function search (mysqli $conn, $content, $constraints = []) {
        $table = DatabaseDef::TABLE_USER;
        $userId = DatabaseDef::ATTRIBUTE_USER_USERID;

        $sql = "SELECT * FROM $table WHERE (".
            "FName LIKE N'%".$content."%' OR ".
            "LName LIKE N'%".$content."%' OR ".
            "UserName LIKE N'%".$content."%' OR ".
            "MName LIKE N'%".$content."%') OR ";

        if (sizeof($constraints) > 0) {
            $keylist = array_keys($constraints);
            foreach ($keylist as $key) {
                $s = sizeof($constraints[$key]);

                if ($s > 0) {
                    $sql .= " AND (";
                }
                $sql .= "(1 = 2) ";
                foreach ($constraints[$key] as $val) {
                    $sql .= " OR ($key = '$val')";
                }
                if ($s > 0) {
                    $sql .= ")";
                }
            }
        }
        echo $sql;
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $pack = PackagePool::Instance()->requestPackage();
            while($row = $result->fetch_assoc()) {
                $pack->setValue($row["$userId"], $row);
            }
            return $pack;
        }
        else {
            return null;
        }
    }
}