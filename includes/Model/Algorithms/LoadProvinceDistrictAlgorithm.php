<?php

/**
 * Created by PhpStorm.
 * User: Tran Tinh Chi
 * Date: 12/25/15
 * Time: 5:51 PM
 */

require_once FILE_PATH('algorithms').'Algorithms.php';
require_once FILE_PATH('patterns').'Package.php';

class LoadProvinceDistrictAlgorithm implements  Algorithms {
    public function execute (mysqli $conn, Package $messagePackage) {
        $curProvince = $messagePackage->getValue("Province");

        $sql = "select DistrictProvince.DistrictName from District JOIN DistrictProvince ON District.DistrictName = DistrictProvince.DistrictName\n"
            ."where DistrictProvince.ProvinceName = $curProvince";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $pack = PackagePool::Instance()->requestPackage();
            while ($row = $result->fetch_assoc()) {
                $row[DatabaseDef::MATCHED_PERCENTAGE] = MatchingPercentageAlgorithm::adjustResult($row[DatabaseDef::MATCHED_PERCENTAGE]);
                $pack->setValue(null, $row["District"]);
            }
            return $pack;
        } else {
            return null;
        }
    }
}