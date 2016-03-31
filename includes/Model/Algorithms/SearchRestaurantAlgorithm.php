<?php
/**
 * Created by PhpStorm.
 * User: Tran Tinh Chi
 * Date: 12/20/15
 * Time: 11:50 AM
 */

require_once FILE_PATH('algorithms').'SearchAlgorithm.php';

class SearchRestaurantAlgorithm extends SearchAlgorithm {
    public function search (mysqli $conn, $content, $constraints = []) {
        $table = DatabaseDef::TABLE_RESTAURANT;
        $RID = DatabaseDef::ATTRIBUTE_RESTAURANT_RID;

        $sql = "SELECT * FROM $table WHERE (".
            "RName LIKE N'%".$content."%') ";

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

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $pack = PackagePool::Instance()->requestPackage();
            while($row = $result->fetch_assoc()) {
                $pack->setValue($row["$RID"], $row);
            }
            return $pack;
        }
        else {
            return null;
        }
    }
}